<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';

    protected $fillable = [
        'testimonials_section_id',
        'video_media_id',
        'text',
        'name',
        'position',
        'duration_seconds',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'testimonials_section_id' => 'integer',
        'video_media_id' => 'integer',
        'duration_seconds' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'integer',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function section()
    {
        return $this->belongsTo(TestimonialsSection::class, 'testimonials_section_id');
    }

    public function video()
    {
        return $this->belongsTo(Media::class, 'video_media_id');
    }
}