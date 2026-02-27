<?php

namespace App\Services;

use App\Models\SiteMetadata;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SiteMetadataService
{
    public function update(int $id, array $data, $logo, $favicon): SiteMetadata
    {
        try {
            // البحث عن السجل الحالي
            $siteMetadata = SiteMetadata::find($id);
            if (!$siteMetadata) {
                throw new \Exception('Site metadata not found.');
            }

            // التعامل مع شعار الموقع
            if ($logo) {
                // حذف الشعار القديم إذا كان موجودًا
                if ($siteMetadata->logo) {
                    Storage::disk('public')->delete($siteMetadata->logo->path);
                    $siteMetadata->logo->delete();
                }

                // حفظ الشعار الجديد
                $logoPath = $logo->store('site_metadata', 'public');
                $logoMedia = Media::create([
                    'path' => $logoPath,
                    'type' => 'image',
                    'mime_type' => $logo->getClientMimeType(),
                    'width' => getimagesize($logo)[0],
                    'height' => getimagesize($logo)[1],
                    'size_bytes' => $logo->getSize(),
                    'alt_text' => $data['logo_alt_text'] ?? '', // التحقق من alt_text
                    'title' => $data['logo_title'] ?? '', // التحقق من title
                ]);
                $data['logo_media_id'] = $logoMedia->id;
            }

            // التعامل مع فافيكون الموقع
            if ($favicon) {
                // حذف الفافيكون القديم إذا كان موجودًا
                if ($siteMetadata->favicon) {
                    Storage::disk('public')->delete($siteMetadata->favicon->path);
                    $siteMetadata->favicon->delete();
                }

                // حفظ الفافيكون الجديد
                $faviconPath = $favicon->store('site_metadata', 'public');
                $faviconMedia = Media::create([
                    'path' => $faviconPath,
                    'type' => 'image',
                    'mime_type' => $favicon->getClientMimeType(),
                    'width' => getimagesize($favicon)[0],
                    'height' => getimagesize($favicon)[1],
                    'size_bytes' => $favicon->getSize(),
                    'alt_text' => $data['favicon_alt_text'] ?? '', // التحقق من alt_text
                    'title' => $data['favicon_title'] ?? '', // التحقق من title
                ]);
                $data['favicon_media_id'] = $faviconMedia->id;
            }

            // تحديث السجل بالبيانات الجديدة
            $siteMetadata->update($data);
            return $siteMetadata;
        } catch (Throwable $e) {
            throw new \Exception('Error updating site metadata: ' . $e->getMessage());
        }
    }

     // دالة لاسترجاع بيانات الموقع مع الصور المرتبطة (Logo و Favicon)
    public function getSiteMetadata()
    {
          try {
            // تحميل البيانات مع الصور المرتبطة (logo و favicon)
            $siteMetadata = SiteMetadata::with(['logo', 'favicon'])->first();

            // إرجاع الـ response مع البيانات المطلوبة
            return response()->json([
                'success' => true,
                'message' => 'Site metadata updated successfully',
                'data' => [
                    'name' => $siteMetadata->name,
                    'description' => $siteMetadata->description,
                    'keywords' => $siteMetadata->keywords,
                    'logo' => $siteMetadata->logo->url,  // استخدام الـ URL للـ logo
                    'favicon' => $siteMetadata->favicon->url  // استخدام الـ URL للفافيكون
                ],
                'meta' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch site metadata',
                'error' => $e->getMessage()
            ], 500);
        }
 }
}