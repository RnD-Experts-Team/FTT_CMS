<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FounderSection extends Model
{
    protected $table = 'founder_sections';

    protected $fillable = [
        'hook_text',
        'title',
        'description',
        'video_media_id',
    ];

    protected $casts = [
        'video_media_id' => 'integer',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function video()
    {
        return $this->belongsTo(Media::class, 'video_media_id');
    }
}