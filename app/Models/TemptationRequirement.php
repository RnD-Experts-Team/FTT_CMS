<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemptationRequirement extends Model
{
    protected $table = 'temptation_requirements';

    protected $fillable = [
        'temptation_section_id',
        'text',
        'sort_order'
    ];

    public function temptationSection()
    {
        return $this->belongsTo(TemptationSection::class);
    }
}