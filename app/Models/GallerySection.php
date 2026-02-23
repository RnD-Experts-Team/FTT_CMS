<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GallerySection extends Model
{
    protected $table = 'gallery_sections';

    protected $fillable = [
        'hook',
        'title',
        'description'
    ];

    public function items()
    {
        return $this->hasMany(GalleryItem::class);
    }
}