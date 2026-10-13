<?php

namespace App\Services\Rag;

use Illuminate\Support\Facades\DB;

class KnowledgeSearch
{
    public function __construct(private Embedder $embedder) {}

    public function search(string $query, ?int $propertyId = null, int $k = 5): array
    {
        $vec = '[' . implode(',', $this->embedder->query($query)) . ']';

        return DB::table('document_chunks as c')
            ->join('documents as d', 'd.id', '=', 'c.document_id')
            ->where('d.status', 'ready')
            ->when($propertyId, fn ($q) => $q->where('d.property_id', $propertyId))
            ->selectRaw('d.id as document_id, d.title, c.content, c.metadata, 1 - (c.embedding <=> ?::vector) as score', [$vec])
            ->orderByRaw('c.embedding <=> ?::vector', [$vec])
            ->limit($k)
            ->get()
            ->map(fn ($r) => (array) $r)
            ->all();
    }
}
