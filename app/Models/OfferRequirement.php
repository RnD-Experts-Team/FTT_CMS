<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferRequirement extends Model
{
    protected $table = 'offer_requirements';

    protected $fillable = [
        'offer_section_id',
        'text',
        'sort_order'
    ];

    public function offerSection()
    {
        return $this->belongsTo(OfferSection::class);
    }
}