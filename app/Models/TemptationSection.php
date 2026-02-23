<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemptationSection extends Model
{
    protected $table = 'temptation_sections';

    protected $fillable = [
        'hook',
        'title',
        'description',
        'button1_text',
        'button1_link',
        'button2_text',
        'button2_link',
        'image_media_id'
    ];

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_media_id');
    }

    public function requirements()
    {
        return $this->hasMany(TemptationRequirement::class);
    }
}