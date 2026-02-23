<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cta extends Model
{
    protected $table = 'ctas';

    protected $fillable = [
        'title',
        'description',
        'button1_text',
        'button1_link',
        'button2_text',
        'button2_link',
        'sort_order',
        'is_active'
    ];
}