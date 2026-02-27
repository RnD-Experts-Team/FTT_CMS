<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterContact extends Model
{
    protected $table = 'footer_contacts';

    protected $fillable = [
        'phone',
        'whatsapp',
        'email',
        'address',
    ];

    public $timestamps = true;

    // لأنك مستخدم TIMESTAMP مع useCurrent، نخلي Laravel يستخدم نفس أسماء الأعمدة
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}