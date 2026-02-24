<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       
        // User::updateOrCreate([
        // 'name' => 'Admin',
        // 'email' => 'admin@example.com',
        // 'password' => Hash::make('password123'),
        // ]);
        //$this->call(BenefitsSectionSeeder::class);
        //$this->call(NeedsSectionSeeder::class);
        //$this->call(FooterContactSeeder::class);
        //$this->call(FooterSocialLinkSeeder::class);
        //$this->call(HeroSectionSeeder::class);
        //$this->call(FounderSectionWithMediaSeeder::class);
        //  $this->call(TestimonialsSectionsSeeder::class);
        //  $this->call(TemptationSectionSeeder::class);
         $this->call(OfferSectionSeeder::class);
    }
}
