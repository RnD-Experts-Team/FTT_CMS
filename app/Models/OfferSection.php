<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferSection extends Model
{
    protected $table = 'offer_sections';

    protected $fillable = [
        'hook',
        'title',
        'description',
        'button_text',
        'button_link',
        'image_media_id'
    ];

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_media_id');
    }

    public function requirements()
    {
        return $this->hasMany(OfferRequirement::class);
    }
}