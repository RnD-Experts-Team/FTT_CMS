<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroMedia extends Model
{
    protected $table = 'hero_media';

    protected $fillable = [
        'hero_section_id','media_id','sort_order'
    ];

    public function heroSection()
    {
        return $this->belongsTo(HeroSection::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}