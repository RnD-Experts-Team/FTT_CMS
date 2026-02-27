<?php

namespace App\Services;

use App\Models\OfferRequirement;
use Throwable;

class OfferRequirementService
{
    public function store(array $data): OfferRequirement
    {
        try {
            // التعامل مع sort_order للتأكد من أنه فريد
            $existingRecord = OfferRequirement::where('sort_order', $data['sort_order'])->first();
            while ($existingRecord) {
                $data['sort_order'] += 1; // زيادة 1 في القيمة
                $existingRecord = OfferRequirement::where('sort_order', $data['sort_order'])->first();
            }

            return OfferRequirement::create($data);
        } catch (Throwable $e) {
            throw new \Exception('Error creating offer requirement: ' . $e->getMessage());
        }
    }

    public function index()
    {
        return OfferRequirement::with('offerSection')->orderBy('sort_order')->get(); //بالترتيب استرجاع جميع المتطلبات مع قسم العرض المرتبط
    }

    public function show(int $id): ?OfferRequirement
    {
        return OfferRequirement::with('offerSection')->find($id);
    }

    public function update(int $id, array $data): OfferRequirement
    {
        try {
            $requirement = OfferRequirement::find($id);
            if (!$requirement) {
                throw new \Exception('Offer requirement not found.');
            }

            // التعامل مع sort_order للتأكد من أنه فريد
            if (isset($data['sort_order'])) {
                $existingRecord = OfferRequirement::where('sort_order', $data['sort_order'])->first();
                while ($existingRecord && $existingRecord->id != $requirement->id) {
                    $data['sort_order'] += 1; // زيادة 1 في القيمة
                    $existingRecord = OfferRequirement::where('sort_order', $data['sort_order'])->first();
                }
            }

            $requirement->update($data);
            return $requirement;
        } catch (Throwable $e) {
            throw new \Exception('Error updating offer requirement: ' . $e->getMessage());
        }
    }

    public function destroy(int $id): bool
    {
        try {
            $requirement = OfferRequirement::find($id);
            if (!$requirement) {
                throw new \Exception('Offer requirement not found.');
            }

            return $requirement->delete();
        } catch (Throwable $e) {
            throw new \Exception('Error deleting offer requirement: ' . $e->getMessage());
        }
    }
}