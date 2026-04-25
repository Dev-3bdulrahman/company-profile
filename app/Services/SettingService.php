<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    /**
     * Get all settings with defaults
     */
    public function getSettings(): array
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        $defaults = [
            'site_name' => ['ar' => 'المستقبل السريع للرياضة', 'en' => 'Al Mustaqbal Al Sarea Sports'],
            'job_title' => ['ar' => 'خبراء إنشاء وتجهيز الملاعب الرياضية', 'en' => 'Sports Court Construction & Installation Experts'],
            'hero_subtitle' => ['ar' => 'حلول متكاملة لبناء ملاعب البادل وكرة القدم والسلة والمسابح بمعايير عالمية في الإمارات والخليج', 'en' => 'Total sports solutions for Padel, Football, Basketball, and Swimming Pools across UAE and Gulf countries'],
            'site_description' => ['ar' => 'شركة رائدة في تصنيع وتركيب الملاعب الرياضية', 'en' => 'A leading sports courts manufacturing and installation company'],
            'contact_email' => 'Office@almustaqbalalsarea.com',
            'contact_phone' => '+971 50 853 3362',
            'whatsapp' => '+971501280047',
            'facebook' => 'https://www.facebook.com/AlmustaqbalAlsarie',
            'twitter' => '',
            'instagram' => 'https://www.instagram.com/almustaqbal_alsarea_factory/',
            'linkedin' => '',
            'tiktok' => 'https://www.tiktok.com/@almustaqbal_alsarea',
            'youtube' => 'https://www.youtube.com/@almustaqbalalalsarea',
            'logo_light' => null,
            'logo_dark' => null,
            'favicon' => null,
            'seo_title' => ['ar' => 'المستقبل السريع للرياضة | تركيب ملاعب بادل وكرة قدم', 'en' => 'Al Mustaqbal Al Sarea Sports | Padel & Football Court Installation'],
            'seo_description' => [
                'ar' => 'المستقبل السريع للرياضة متخصصة في بناء وتجهيز كافة أنواع الملاعب الرياضية في الإمارات ودول الخليج.',
                'en' => 'Almustaqbal Alsarea specializes in construction and installation of all types of sports courts in UAE and Gulf.'
            ],
            'seo_keywords' => ['ar' => 'تركيب ملاعب بادل, بناء ملاعب كرة قدم, أرضيات رياضية', 'en' => 'Padel court construction, football field installation, sports flooring'],
            'dark_mode_supported' => true,
            'default_theme' => 'dark',
            'show_theme_toggle' => true,
            'pdf_show_background' => true,
            'pdf_show_company_signature' => true,
            'pdf_show_client_signature' => true,
            'logo_pdf' => null,
            'logo_pdf_watermark' => null,
            'google_analytics_id' => '',
            'google_tag_manager_id' => '',
            'facebook_pixel_id' => '',
            'custom_header_scripts' => '',
            'custom_body_scripts' => '',
            'custom_footer_scripts' => '',
            'landing_hero_title_1' => ['ar' => 'نبني الملاعب', 'en' => 'We Build Courts'],
            'landing_hero_title_2' => ['ar' => 'بمعايير البطولات', 'en' => 'To Tournament Standards'],
            'landing_hero_cta_1' => ['ar' => 'ابدأ مشروعك', 'en' => 'Start Your Project'],
            'landing_hero_cta_2' => ['ar' => 'شاهد أعمالنا', 'en' => 'View Our Work'],
            'landing_stats_projects_count' => '37',
            'landing_stats_projects_label' => ['ar' => 'مشروع منجز', 'en' => 'Projects Done'],
            'landing_stats_years_count' => '4',
            'landing_stats_years_label' => ['ar' => 'سنوات خبرة', 'en' => 'Years Experience'],
            'landing_stats_countries_count' => '7',
            'landing_stats_countries_label' => ['ar' => 'دول', 'en' => 'Countries'],
            'landing_stats_clients_count' => '33',
            'landing_stats_clients_label' => ['ar' => 'عميل سعيد', 'en' => 'Happy Clients'],
            
            // New Landing Page Keys
            'l_hero_eyebrow' => ['ar' => 'حلول رياضية احترافية', 'en' => 'Professional Sports Solutions'],
            'l_hero_title1' => ['ar' => 'نبني ملاعب', 'en' => 'Build Your'],
            'l_hero_title2' => ['ar' => 'أحلامك الرياضية', 'en' => 'Dream Sports Court'],
            'l_hero_subtitle' => ['ar' => 'خبرة في تصميم وبناء وصيانة كافة أنواع الملاعب الرياضية.', 'en' => 'Expert design, construction and maintenance for all types of sports surfaces.'],
            'l_hero_cta1' => ['ar' => 'خدماتنا', 'en' => 'Our Services'],
            'l_hero_cta2' => ['ar' => 'شاهد الفيديو', 'en' => 'Watch Video'],
            
            'l_stats_years_count' => '12',
            'l_stats_years_label' => ['ar' => 'سنوات خبرة', 'en' => 'Years Experience'],
            'l_stats_countries_count' => '7',
            'l_stats_countries_label' => ['ar' => 'دول', 'en' => 'Countries'],
            'l_stats_clients_count' => '33+',
            'l_stats_clients_label' => ['ar' => 'عميل سعيد', 'en' => 'Happy Clients'],
            
            'l_services_eyebrow' => ['ar' => 'خدمات احترافية', 'en' => 'Professional Services'],
            'l_services_title' => ['ar' => 'ماذا نقدم', 'en' => 'What We Offer'],
            'l_services_subtitle' => ['ar' => 'حلول شاملة لكل احتياجاتك الرياضية.', 'en' => 'Comprehensive solutions for every sporting need.'],
            
            'l_process_eyebrow' => ['ar' => 'سير العمل', 'en' => 'Our Workflow'],
            'l_process_title' => ['ar' => 'كيف نعمل', 'en' => 'How We Work'],
            
            'l_test_eyebrow' => ['ar' => 'قصص النجاح', 'en' => 'Client Stories'],
            'l_test_title' => ['ar' => 'ماذا يقول الناس', 'en' => 'What People Say'],
            
            'l_cta_title' => ['ar' => 'جاهز لبدء مشروعك؟', 'en' => 'Ready to Start Your Project?'],
            'l_cta_subtitle' => ['ar' => 'تواصل معنا اليوم للحصول على استشارة مجانية وعرض سعر.', 'en' => 'Contact us today for a free consultation and quote.'],
            'l_cta_button' => ['ar' => 'اتصل بنا الآن', 'en' => 'Call Us Now'],
        ];

        return array_merge($defaults, $settings);
    }

    /**
     * Get a specific setting value
     */
    public function getSetting(string $key, $default = null)
    {
        return SiteSetting::getValue($key, $default);
    }

    /**
     * Get settings resolved to a single locale string (for views/PDF)
     */
    public function getLocalizedSettings(): array
    {
        $settings = $this->getSettings();
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');
        $localized = [];

        foreach ($settings as $key => $value) {
            if (is_array($value)) {
                $localized[$key] = $value[$locale] ?? $value[$fallback] ?? reset($value);
            } else {
                $localized[$key] = $value;
            }
        }

        return $localized;
    }

    /**
     * Update settings
     */
    public function updateSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        
        Cache::forget('site_settings');
    }
}
