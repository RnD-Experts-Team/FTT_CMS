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

        // ترتيب افتراضي ثابت ومفيد
        $query->orderBy($sortBy, $sortDir)->orderBy('id', 'desc');

        return $query->paginate($perPage);
    }

    public function create(array $data): Cta
    {
        return Cta::create($data);
    }

    public function update(Cta $cta, array $data): Cta
    {
        $cta->fill($data);
        $cta->save();

        return $cta->refresh();
    }

    public function delete(Cta $cta): void
    {
        $cta->delete();
    }
}