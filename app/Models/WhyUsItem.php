<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyUsItem extends Model
{
    protected $table = 'why_us_items';

    protected $fillable = [
        'name',
        'icon_media_id',
        'sort_order',
        'is_active'
    ];

    public function icon()
    {
        return $this->belongsTo(Media::class, 'icon_media_id');
    }
}