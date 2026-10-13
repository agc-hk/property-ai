<?php

namespace App\Services\Rag;

use Illuminate\Support\Facades\Http;
class Embedder
{
    private function embed(array $texts): array
    {
        return Http::timeout(180)->post(config('services.ollama.url') . '/api/embed', [
            'model' => config('services.ollama.embed_model'),
            'input' => $texts,
        ])->throw()->json('embeddings');
    }

    public function documents(array $texts): array
    {
        return $this->embed(array_map(fn ($t) => 'search_document: ' . $t, $texts));
    }

    public function query(string $q): array
    {
        return $this->embed(['search_query: ' . $q])[0];
    }
}