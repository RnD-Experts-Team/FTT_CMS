<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialsSection extends Model
{
    protected $table = 'testimonials_sections';

    protected $fillable = [
        'hook',
        'title',
        'description',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'testimonials_section_id');
    }
}