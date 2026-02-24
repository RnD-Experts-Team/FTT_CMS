<?php

namespace App\Services;

use App\Models\TemptationRequirement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class TemptationRequirementService
{
    public function store(array $data): TemptationRequirement
    {
        try {
            // تحقق من إذا كانت قيمة sort_order المدخلة موجودة مسبقًا
            $existingRecord = TemptationRequirement::where('sort_order', $data['sort_order'])->first();
            
            // إذا كانت موجودة، زد القيمة تدريجيًا حتى تجد قيمة غير مكررة
            while ($existingRecord) {
                $data['sort_order'] += 1; // زيادة 1 في القيمة
                $existingRecord = TemptationRequirement::where('sort_order', $data['sort_order'])->first();
            }

            // إنشاء السجل الجديد بالقيمة المعدلة لـ sort_order
            return TemptationRequirement::create($data);
        } catch (Throwable $e) {
            throw new \Exception('Error creating temptation requirement: ' . $e->getMessage());
        }
    }

    public function index(): Collection
    {
        try {
            return TemptationRequirement::all();
        } catch (Throwable $e) {
            throw new \Exception('Error fetching temptation requirements: ' . $e->getMessage());
        }
    }

    public function show(int $id): ?TemptationRequirement
    {
        try {
            return TemptationRequirement::find($id);
        } catch (Throwable $e) {
            throw new \Exception('Error fetching temptation requirement: ' . $e->getMessage());
        }
    }

    public function update(int $id, array $data): ?TemptationRequirement
    {
        try {
            // العثور على السجل بناءً على ID
            $temptationRequirement = TemptationRequirement::find($id);

            if (!$temptationRequirement) {
                throw new \Exception('Temptation requirement not found.');
            }

            // تحقق إذا كانت قيمة sort_order المدخلة موجودة مسبقًا
            $existingRecord = TemptationRequirement::where('sort_order', $data['sort_order'])->first();

            // إذا كانت موجودة، زد القيمة تدريجيًا حتى تجد قيمة غير مكررة
            while ($existingRecord && $existingRecord->id != $temptationRequirement->id) {
                $data['sort_order'] += 1; // زيادة 1 في القيمة
                $existingRecord = TemptationRequirement::where('sort_order', $data['sort_order'])->first();
            }

            // تحديث السجل بالقيم الجديدة
            $temptationRequirement->update($data);
            
            return $temptationRequirement;
        } catch (Throwable $e) {
            throw new \Exception('Error updating temptation requirement: ' . $e->getMessage());
        }
    }

    public function destroy(int $id): bool
    {
        try {
            $temptationRequirement = TemptationRequirement::find($id);
            if (!$temptationRequirement) {
                throw new \Exception('Temptation requirement not found.');
            }
            return $temptationRequirement->delete();
        } catch (Throwable $e) {
            throw new \Exception('Error deleting temptation requirement: ' . $e->getMessage());
        }
    }
}