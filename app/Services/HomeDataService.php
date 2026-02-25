<?php

namespace App\Services;

use App\Models\SiteMetadata;
use App\Models\FooterSocialLink;
use App\Models\FooterContact;
use App\Models\HeroSection;
use App\Models\Cta;
use App\Models\WhyUsItem;
use App\Models\OfferSection;
use App\Models\TemptationSection;
use App\Models\BenefitsSection;
use App\Models\NeedsSection;
use App\Models\FounderSection;
use App\Models\TestimonialsSection;

class HomeDataService
{
    public function getHomeData()
    {
        // Site Metadata
        $siteMetadata = SiteMetadata::with('logo', 'favicon')->first();

        // Footer
        $footer = [
            'contact_info' => FooterContact::first(),
            'social_links' => FooterSocialLink::all(),
        ];

        // Hero Section with Media
        $heroSection = HeroSection::with('media')->first();

        // Testimonials Section
        $testimonialsSection = TestimonialsSection::with('testimonials.video')->first();  // تحميل testimonials مع الفيديوهات

        // CTAs
        $ctas = Cta::all();

        // Why Us Section
        $whyUsSection = WhyUsItem::all();

        // Offer Section with Image
        $offerSection = OfferSection::with('image')->first();

        // Temptation Section with Image
        $temptationSection = TemptationSection::with('image')->first();

        // Benefits Section
        $benefitsSection = BenefitsSection::with('items')->first();

        // Needs Section
        $needsSection = NeedsSection::all();

        // Founder Section
        $founderSection = FounderSection::with('video')->first();

        // Return all the collected data without gallery_section
        return [
            'site_metadata' => $siteMetadata,
            'footer' => $footer,
            'hero_section' => $heroSection,
            'testimonials_section' => $testimonialsSection,
            'ctas' => $ctas,
            'why_us_section' => $whyUsSection,
            'offer_section' => $offerSection,
            'temptation_section' => $temptationSection,
            'benefits_section' => $benefitsSection,
            'needs_section' => $needsSection,
            'founder_section' => $founderSection,
        ];
    }
}