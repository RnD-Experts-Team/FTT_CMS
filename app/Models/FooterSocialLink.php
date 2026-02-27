<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSocialLink extends Model
{
    protected $table = 'footer_social_links';

    protected $fillable = [
        'platform',
        'url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'integer',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}