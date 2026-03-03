<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ctas')->insert([
            [
                
                'title'        => 'Start Your Free Trial',
                'description'  => 'Sign up today and get 30 days free access.',
                'button1_text' => 'Get Started',
                'button1_link' => 'https://example.com/signup',
                'button2_text' => 'Learn More',
                'button2_link' => 'https://example.com/learn-more',
                'sort_order'   => 1,
                'is_active'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Boost Your Business',
                'description'  => 'Grow faster with our powerful tools.',
                'button1_text' => 'View Plans',
                'button1_link' => 'https://example.com/plans',
                'button2_text' => 'Contact Sales',
                'button2_link' => 'https://example.com/contact',
                'sort_order'   => 2,
                'is_active'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'All-in-One Dashboard',
                'description'  => 'Manage everything from a single place.',
                'button1_text' => 'Open Dashboard',
                'button1_link' => 'https://example.com/dashboard',
                'button2_text' => 'Documentation',
                'button2_link' => 'https://example.com/docs',
                'sort_order'   => 3,
                'is_active'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Team Collaboration',
                'description'  => 'Invite your team and work together seamlessly.',
                'button1_text' => 'Invite Team',
                'button1_link' => 'https://example.com/team',
                'button2_text' => 'Permissions',
                'button2_link' => 'https://example.com/permissions',
                'sort_order'   => 4,
                'is_active'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Secure & Reliable',
                'description'  => 'We protect your data with top security standards.',
                'button1_text' => 'Security Info',
                'button1_link' => 'https://example.com/security',
                'button2_text' => 'System Status',
                'button2_link' => 'https://example.com/status',
                'sort_order'   => 5,
                'is_active'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Coming Soon',
                'description'  => 'Exciting new features are on the way.',
                'button1_text' => 'Join Waitlist',
                'button1_link' => 'https://example.com/waitlist',
                'button2_text' => 'View Roadmap',
                'button2_link' => 'https://example.com/roadmap',
                'sort_order'   => 6,
                'is_active'    => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}