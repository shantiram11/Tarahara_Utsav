<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sponsor;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = [
            // Tier 1 Sponsors (Premium)
            [
                'title' => 'TechCorp Solutions',
                'image' => 'sponsors/techcorp-logo.png',
                'amount' => 'RS. 2,00,000/-',
                'label' => 'TITLE SPONSOR',
                'tier' => 'tier1',
                'website_url' => 'https://techcorp.example.com',
                'is_active' => true,
            ],
            [
                'title' => 'InnovateHub',
                'image' => 'sponsors/innovatehub-logo.png',
                'amount' => 'RS. 1,00,000/-',
                'label' => 'SPONSORS',
                'tier' => 'tier1',
                'website_url' => 'https://innovatehub.example.com',
                'is_active' => true,
            ],
            [
                'title' => 'Global Dynamics',
                'image' => 'sponsors/globaldynamics-logo.png',
                'amount' => 'RS. 50,000/-',
                'label' => 'CO-SPONSORS',
                'tier' => 'tier1',
                'website_url' => 'https://globaldynamics.example.com',
                'is_active' => true,
            ],
            [
                'title' => 'Future Systems',
                'image' => 'sponsors/futuresystems-logo.png',
                'amount' => 'RS. 25,000/-',
                'label' => 'CELEB. PARTNERS',
                'tier' => 'tier1',
                'website_url' => 'https://futuresystems.example.com',
                'is_active' => true,
            ],

            // Tier 2 Sponsors (Standard)
            [
                'title' => 'Digital Solutions',
                'image' => 'sponsors/digitalsolutions-logo.png',
                'amount' => 'RS. 20K',
                'label' => 'SUPPORTERS',
                'tier' => 'tier2',
                'website_url' => 'https://digitalsolutions.example.com',
                'is_active' => true,
            ],
            [
                'title' => 'Creative Studios',
                'image' => 'sponsors/creativestudios-logo.png',
                'amount' => 'RS. 15K',
                'label' => 'SUPPORTERS',
                'tier' => 'tier2',
                'website_url' => 'https://creativestudios.example.com',
                'is_active' => true,
            ],
            [
                'title' => 'Smart Technologies',
                'image' => 'sponsors/smarttech-logo.png',
                'amount' => 'RS. 10K',
                'label' => 'SUPPORTERS',
                'tier' => 'tier2',
                'website_url' => 'https://smarttech.example.com',
                'is_active' => true,
            ],
            [
                'title' => 'NextGen Labs',
                'image' => 'sponsors/nextgenlabs-logo.png',
                'amount' => 'RS. 5K',
                'label' => 'SUPPORTERS',
                'tier' => 'tier2',
                'website_url' => 'https://nextgenlabs.example.com',
                'is_active' => true,
            ],
            [
                'title' => 'Innovation Corp',
                'image' => 'sponsors/innovationcorp-logo.png',
                'amount' => 'IN-KIND',
                'label' => 'SPONSORS',
                'tier' => 'tier2',
                'website_url' => 'https://innovationcorp.example.com',
                'is_active' => true,
            ],
            [
                'title' => 'Tech Partners',
                'image' => 'sponsors/techpartners-logo.png',
                'amount' => 'COMMUNITY',
                'label' => 'SUPPORTERS',
                'tier' => 'tier2',
                'website_url' => 'https://techpartners.example.com',
                'is_active' => true,
            ],
        ];

        foreach ($sponsors as $sponsor) {
            Sponsor::updateOrCreate(
                ['title' => $sponsor['title'], 'tier' => $sponsor['tier']],
                $sponsor
            );
        }
    }
}
