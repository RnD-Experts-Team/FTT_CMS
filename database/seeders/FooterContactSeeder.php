<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterContact;

class FooterContactSeeder extends Seeder
{
    public function run(): void
    {
        FooterContact::updateOrCreate(
            ['id' => 1],
            [
                'phone'    => '+1 123 456 7890',
                'whatsapp' => '+1 123 456 7890',
                'email'    => 'support@example.com',
                'address'  => '123 Main Street, New York, USA'
            ]
        );
    }
}