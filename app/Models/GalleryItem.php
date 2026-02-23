<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $table = 'gallery_items';

    protected $fillable = [
        'gallery_section_id',
        'image_media_id',
        'title',
        'description',
        'sort_order',
        'is_active'
    ];

    public function section()
    {
        return $this->belongsTo(GallerySection::class);
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_media_id');
    }
}