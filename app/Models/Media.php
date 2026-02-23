<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'path','type','mime_type','width','height',
        'size_bytes','alt_text','title'
    ];
}
