<?php

namespace App\Services\Rag;
class Chunker
{
    // Markdown: split at headings so each chunk keeps its section context
    public function markdown(string $md, int $size = 1000): array
    {
        $out = [];
        foreach (preg_split('/^(?=#{1,3}\\s)/m', $md, -1, PREG_SPLIT_NO_EMPTY) as $section) {
            $heading = preg_match('/^#{1,3}\\s+(.+)$/m', $section, $m) ? trim($m[1]) : null;
            foreach ($this->split(trim($section), $size) as $piece) {
                $out[] = ['text' => $piece, 'meta' => ['heading' => $heading]];
            }
        }
        return $out;
    }

    public function text(string $text, int $size = 1000, array $meta = []): array
    {
        return array_map(fn ($p) => ['text' => $p, 'meta' => $meta], $this->split($text, $size));
    }

    // paragraph-aware packing with overlap
    private function split(string $text, int $size, int $overlap = 150): array
    {
        $chunks = [];
        $cur = '';
        foreach (preg_split('/\\R{2,}/', $text) as $p) {
            if ($cur !== '' && mb_strlen($cur) + mb_strlen($p) > $size) {
                $chunks[] = trim($cur);
                $cur = mb_substr($cur, -$overlap) . PHP_EOL . PHP_EOL;
            }
            $cur .= $p . PHP_EOL . PHP_EOL;
        }
        if (trim($cur) !== '') {
            $chunks[] = trim($cur);
        }
        return $chunks;
    }
}
