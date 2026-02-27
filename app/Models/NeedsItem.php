<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeedsItem extends Model
{
    protected $table = 'needs_items';

    protected $fillable = [
        'needs_section_id',
        'text',
        'sort_order'
    ];

    public function section()
    {
        return $this->belongsTo(NeedsSection::class);
    }
}