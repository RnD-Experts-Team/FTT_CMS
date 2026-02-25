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
        $siteMetadataData = [
            'name' => $siteMetadata->name,
            'description' => $siteMetadata->description,
            'keywords' => $siteMetadata->keywords,
            'logo' => $siteMetadata->logo->url, // استخدام URL من العلاقة media
            'favicon' => $siteMetadata->favicon->url, // استخدام URL من العلاقة media
        ];
        // Footer
        $footer = [
            'contact_info' => FooterContact::first(),
            'social_links' => FooterSocialLink::all()->map(function ($socialLink) {
                return [
                    'platform' => $socialLink->platform,
                    'url' => $socialLink->url,
                    'is_active' => $socialLink->is_active,
                ];
            }),
        ];

        // تعديل الاستجابة لتكون بالشكل المطلوب
        $footerData = [
            'contact_info' => [
                'phone' => $footer['contact_info']->phone,
                'whatsapp' => $footer['contact_info']->whatsapp,
                'email' => $footer['contact_info']->email,
                'address' => $footer['contact_info']->address,
            ],
            'social_links' => $footer['social_links'],
        ];
        // Hero Section with Media
        $heroSection = HeroSection::with('media')->first();
        $heroSectionData = [
            'subheader' => $heroSection->subheader,
            'title' => $heroSection->title,
            'description_html' => $heroSection->description_html,
            'button1_text' => $heroSection->button1_text,
            'button1_link' => $heroSection->button1_link,
            'button2_text' => $heroSection->button2_text,
            'button2_link' => $heroSection->button2_link,
            'media' => $heroSection->media->map(function ($mediaItem) {
                return [
                    'id' => $mediaItem->id,
                    'url' => $mediaItem->media->url,  // URL من علاقة media
                ];
            }),
        ];

        // Testimonials Section
        $testimonialsSection = TestimonialsSection::with('testimonials.video')->first();
        $testimonialsData = $testimonialsSection->testimonials->map(function ($testimonial) {
            return [
                'video_media_id' => $testimonial->video_media_id,
                'text' => $testimonial->text,
                'name' => $testimonial->name,
                'position' => $testimonial->position,
                'duration_seconds' => $testimonial->duration_seconds,
                'sort_order' => $testimonial->sort_order,
                'is_active' => $testimonial->is_active,
            ];
        });

        // CTAs
        $ctas = Cta::all()->map(function ($cta) {
            return [
                'id' => $cta->id,
                'title' => $cta->title,
                'description' => $cta->description,
                'button1_text' => $cta->button1_text,
                'button1_link' => $cta->button1_link,
                'button2_text' => $cta->button2_text,
                'button2_link' => $cta->button2_link,
            ];
        });

       // Why Us Section
        $whyUsSection = WhyUsItem::all()->map(function ($item) {
            return [
                'name' => $item->name,
                'icon' => $item->icon ? $item->icon->url : null,
            ];
        });

         $whyUsSectionData = [
            'items' => $whyUsSection
        ];

        // Offer Section with Image
        $offerSection = OfferSection::with(['image', 'requirements'])->first();
        $offerSectionData = [
            'hook' => $offerSection->hook,
            'title' => $offerSection->title,
            'description' => $offerSection->description,
            'button_text' => $offerSection->button_text,
            'button_link' => $offerSection->button_link,
            'image' => $offerSection->image->url, // الحصول على URL الصورة
            'requirements' => $offerSection->requirements->map(function ($requirement) {
                return ['text' => $requirement->text]; // استخراج النص من كل متطلب
            }),
        ];

         // Temptation Section with Image
        $temptationSection = TemptationSection::with(['image', 'requirements'])->first();
        $temptationSectionData = [
            'hook' => $temptationSection->hook,
            'title' => $temptationSection->title,
            'description' => $temptationSection->description,
            'button1_text' => $temptationSection->button1_text,
            'button1_link' => $temptationSection->button1_link,
            'button2_text' => $temptationSection->button2_text,
            'button2_link' => $temptationSection->button2_link,
            'image' => $temptationSection->image->url,  
            'requirements' => $temptationSection->requirements->map(function ($requirement) {
                return ['text' => $requirement->text];  
            }),
        ];
       // Benefits Section
        $benefitsSection = BenefitsSection::with('items')->first();
        $benefitsSectionData = [
            'items' => $benefitsSection->items->map(function ($item) {
                return ['text' => $item->text];
            })
        ];

            // Needs Section
        $needsSection = NeedsSection::all()->map(function ($item) {
            return ['text' => $item->text];
        });

         $needsSectionData = [
            'items' => $needsSection
        ];

        // Founder Section
        $founderSection = FounderSection::with('video')->first();
        $founderSectionData = [
            'hook_text' => $founderSection->hook_text,
            'title' => $founderSection->title,
            'description' => $founderSection->description,
            'video_media_id' => $founderSection->video_media_id,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Home data retrieved successfully',
            'data' => [
                'site_metadata' => $siteMetadataData,
                'footer' => $footerData,
                'hero_section' => $heroSectionData,
                'testimonials_section' => [
                    'hook' => $testimonialsSection->hook,
                    'title' => $testimonialsSection->title,
                    'description' => $testimonialsSection->description,
                    'testimonials' => $testimonialsData,
                ],
                'ctas' => $ctas,
                'why_us_section' => $whyUsSectionData,
                'offer_section' => $offerSectionData,
                'temptation_section' => $temptationSectionData,
                'benefits_section' => $benefitsSectionData,
                'needs_section' => $needsSectionData,
                'founder_section' => $founderSectionData,
            ],
            'meta' => [],
        ]);
    }
}