<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenefitsItem extends Model
{
    protected $table = 'benefits_items';

    protected $fillable = [
        'benefits_section_id',
        'text',
        'sort_order'
    ];

    public function section()
    {
        return $this->belongsTo(BenefitsSection::class);
    }
}