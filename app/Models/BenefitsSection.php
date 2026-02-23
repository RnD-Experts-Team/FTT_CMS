<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class BenefitsSection extends Model
{
    protected $table = 'benefits_sections';

    protected $fillable = ['hook','title'];

    public function items()
    {
        return $this->hasMany(BenefitsItem::class);
    }
}