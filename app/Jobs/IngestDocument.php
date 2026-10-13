<?php

namespace App\Jobs;

use App\Models\Document;
use App\Services\Rag\Chunker;
use App\Services\Rag\Embedder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IngestDocument implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $timeout = 900;
    public int $tries = 1;

    public function __construct(public Document $doc) {}

    public function handle(Chunker $chunker, Embedder $embedder): void
    {
        $this->doc->update(['status' => 'processing', 'error' => null]);

        try {
            $path = Storage::path($this->doc->path);
            $chunks = [];

            if ($this->doc->type === 'md') {
                $chunks = $chunker->markdown(file_get_contents($path));
            } else {
                $pdf = (new \Smalot\PdfParser\Parser())->parseFile($path);
                foreach ($pdf->getPages() as $i => $page) {
                    $text = trim($page->getText());
                    if ($text !== '') {
                        array_push($chunks, ...$chunker->text($text, 1000, ['page' => $i + 1]));
                    }
                }
            }

            if (! $chunks) {
                throw new \RuntimeException('No extractable text. Scanned PDF? Run OCR first.');
            }

            $this->doc->chunks()->delete();   // idempotent re-ingest

            foreach (array_chunk($chunks, 16, true) as $batch) {
                $vectors = array_values($embedder->documents(array_column($batch, 'text')));
                $n = 0;
                foreach ($batch as $idx => $c) {
                    DB::table('document_chunks')->insert([
                        'document_id' => $this->doc->id,
                        'chunk_index' => $idx,
                        'content' => $c['text'],
                        'metadata' => json_encode($c['meta']),
                        'embedding' => '[' . implode(',', $vectors[$n++]) . ']',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $this->doc->update(['status' => 'ready']);
        } catch (\Throwable $e) {
            $this->doc->update(['status' => 'failed', 'error' => $e->getMessage()]);
            throw $e;
        }
    }
}
