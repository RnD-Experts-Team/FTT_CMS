<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $table = 'hero_sections';

    protected $fillable = [
        'subheader','title','description_html',
        'button1_text','button1_link',
        'button2_text','button2_link'
    ];

    public function media()
    {
        return $this->hasMany(HeroMedia::class);
    }
}