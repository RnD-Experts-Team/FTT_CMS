<?php

namespace App\Services;

use App\Models\Cta;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CtaService
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $q        = $filters['q'] ?? null;
        $isActive = $filters['is_active'] ?? null;
        $sortBy   = $filters['sort_by'] ?? 'sort_order';
        $sortDir  = $filters['sort_dir'] ?? 'asc';
        $perPage  = (int)($filters['per_page'] ?? 15);

        $query = Cta::query();

        if ($isActive !== null) {
            $query->where('is_active', (int)$isActive);
        }

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $query->orderBy($sortBy, $sortDir)->orderBy('id', 'desc');

        return $query->paginate($perPage);
    }

    public function create(array $data): Cta
    {
        $this->ensureUniqueSortOrder($data);
        return Cta::create($data);
    }

    public function update(Cta $cta, array $data): Cta
    {
        $this->ensureUniqueSortOrder($data);
        $cta->fill($data);
        $cta->save();

        return $cta->refresh();
    }

    public function delete(Cta $cta): void
    {
        $cta->delete();
    }
     private function ensureUniqueSortOrder(array &$data)
    {
        // Check if the sort_order is already in use
        $existingItem = Cta::where('sort_order', $data['sort_order'])->first();
        
        // If the sort_order already exists, increment it until it's unique
        if ($existingItem) {
            do {
                $data['sort_order'] += 1;
                $existingItem = Cta::where('sort_order', $data['sort_order'])->first();
            } while ($existingItem);
        }
    }
}