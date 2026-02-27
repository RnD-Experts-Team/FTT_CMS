<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'path','type','mime_type','width','height',
        'size_bytes','alt_text','title'
    ];
  // إضافة خاصية url إلى الـ $appends لتكون موجودة تلقائيًا
    protected $appends = ['url'];

    /**
     * تزويد URL للصورة بناءً على المسار المخزن في الـ path.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        // إذا كان نوع الملف صورة أو فيديو، قم بإرجاع URL
        if ($this->type == 'image' || $this->type == 'video') {
            // توليد URL باستخدام دالة asset() المدمجة، والتي ستضيف قاعدة الدومين في المسار
            return asset('storage/' . $this->path);
        }

        // في حال كان نوع الملف مختلف، يمكننا تعديل المنطق حسب الحاجة
        return null;
    }
}
