<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeedsSection extends Model
{
    protected $table = 'needs_sections';

    protected $fillable = ['hook','title'];

    public function items()
    {
        return $this->hasMany(NeedsItem::class);
    }
}