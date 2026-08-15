<?php

/*
|--------------------------------------------------------------------------
| Editable site content
|--------------------------------------------------------------------------
|
| Every piece of front-end copy that an admin is allowed to change is declared
| here. This file is the schema; the `site_contents` table only stores the
| values that have actually been overridden, so untouched keys always fall
| back to the defaults below (or to the config key named by `config`).
|
| field types: text | textarea | url | image
|
*/

return [

    /*
    | Where uploaded CMS images are stored (public disk).
    */
    'image_path' => 'cms',

    'groups' => [

        'company' => [
            'label' => 'Company & contact',
            'description' => 'Used across the whole site — navigation, footer, contact page and emails. These values override config/company.php.',
            'fields' => [
                'company.name_en' => ['label' => 'Company name (English)', 'type' => 'text', 'config' => 'company.name_en'],
                'company.name_np' => ['label' => 'Company name (Nepali)', 'type' => 'text', 'config' => 'company.name_np'],
                'company.tagline_en' => ['label' => 'Tagline (English)', 'type' => 'textarea', 'config' => 'company.tagline_en'],
                'company.tagline_np' => ['label' => 'Tagline (Nepali)', 'type' => 'textarea', 'config' => 'company.tagline_np'],
                'company.contact_person' => ['label' => 'Contact person', 'type' => 'text', 'config' => 'company.contact_person'],
                'company.contact_person_np' => ['label' => 'Contact person (Nepali)', 'type' => 'text', 'config' => 'company.contact_person_np'],
                'company.phone' => ['label' => 'Phone', 'type' => 'text', 'config' => 'company.phone'],
                'company.email' => ['label' => 'Email', 'type' => 'text', 'config' => 'company.email'],
                'company.address_en' => ['label' => 'Address (English)', 'type' => 'text', 'config' => 'company.address_en'],
                'company.address_np' => ['label' => 'Address (Nepali)', 'type' => 'text', 'config' => 'company.address_np'],
                'company.facebook' => ['label' => 'Facebook page URL', 'type' => 'url', 'config' => 'company.facebook'],
            ],
        ],

        'home' => [
            'label' => 'Home page',
            'description' => 'The hero, the stat strip and every section heading on the landing page.',
            'fields' => [
                'home.hero.badge' => ['label' => 'Hero badge', 'type' => 'text', 'default' => 'Lagankhel, Lalitpur'],
                'home.hero.title' => ['label' => 'Hero heading', 'type' => 'textarea', 'default' => 'Find your next home, land or investment with Om Realtors'],
                'home.hero.subtitle' => ['label' => 'Hero subtitle (English)', 'type' => 'textarea', 'config' => 'company.tagline_en'],
                'home.hero.subtitle_np' => ['label' => 'Hero subtitle (Nepali)', 'type' => 'textarea', 'config' => 'company.tagline_np'],
                'home.hero.image' => ['label' => 'Hero background image', 'type' => 'image', 'help' => 'Optional. A wide photo (about 1920×900) shown behind the hero text.'],
                'home.hero.cta_primary' => ['label' => 'Primary button label', 'type' => 'text', 'default' => 'Browse Properties'],
                'home.hero.cta_secondary' => ['label' => 'Secondary button label', 'type' => 'text', 'default' => 'List Your Property'],
                'home.search.keyword_label' => ['label' => 'Search — keyword label', 'type' => 'text', 'default' => 'Keyword or City'],
                'home.search.keyword_placeholder' => ['label' => 'Search — keyword placeholder', 'type' => 'text', 'default' => 'e.g. Lalitpur, Bhaktapur, land in...'],
                'home.search.type_label' => ['label' => 'Search — listing type label', 'type' => 'text', 'default' => 'Listing type'],
                'home.search.button' => ['label' => 'Search — button label', 'type' => 'text', 'default' => 'Search'],
                'home.stats.properties_label' => ['label' => 'Stat 1 label', 'type' => 'text', 'default' => 'Active Listings'],
                'home.stats.sold_label' => ['label' => 'Stat 2 label', 'type' => 'text', 'default' => 'Deals Closed'],
                'home.stats.cities_label' => ['label' => 'Stat 3 label', 'type' => 'text', 'default' => 'Cities Covered'],
                'home.featured.title' => ['label' => 'Featured section heading', 'type' => 'text', 'default' => 'Featured Properties'],
                'home.featured.subtitle' => ['label' => 'Featured section subtitle', 'type' => 'text', 'default' => 'Hand-picked listings from our team'],
                'home.services.title' => ['label' => 'Services section heading', 'type' => 'text', 'default' => 'हाम्रा सेवाहरू — Our Services'],
                'home.services.subtitle' => ['label' => 'Services section subtitle', 'type' => 'text', 'default' => 'End-to-end support for every real estate need'],
                'home.services.cta' => ['label' => 'Services button label', 'type' => 'text', 'default' => 'See all services'],
                'home.latest.title' => ['label' => 'Latest listings heading', 'type' => 'text', 'default' => 'Latest Listings'],
                'home.cta.title' => ['label' => 'Closing banner heading', 'type' => 'text', 'default' => 'Ready to sell, rent, or list your property?'],
                'home.cta.body' => ['label' => 'Closing banner text', 'type' => 'textarea', 'default' => 'Create a free agent account and reach genuine buyers in minutes.'],
                'home.cta.button' => ['label' => 'Closing banner button', 'type' => 'text', 'default' => 'Get Started'],
            ],
        ],

        'services' => [
            'label' => 'Services page',
            'description' => 'Headings on the services page. The service cards themselves are managed under Services.',
            'fields' => [
                'services.hero.title' => ['label' => 'Page heading', 'type' => 'text', 'default' => 'हाम्रा सेवाहरू — Our Services'],
                'services.hero.subtitle' => ['label' => 'Page subtitle', 'type' => 'textarea', 'default' => 'Complete support for buying, selling, and managing property in Nepal'],
                'services.cta.title' => ['label' => 'Bottom card heading', 'type' => 'text', 'default' => 'Need help with a service?'],
                'services.cta.body' => ['label' => 'Bottom card text', 'type' => 'textarea', 'default' => 'Reach out to our team — our staff are ready to assist you in Nepali or English.'],
                'services.cta.button' => ['label' => 'Bottom card button', 'type' => 'text', 'default' => 'Contact Us'],
            ],
        ],

        'about' => [
            'label' => 'About page',
            'fields' => [
                'about.badge' => ['label' => 'Badge', 'type' => 'text', 'default' => 'About Us'],
                'about.title' => ['label' => 'Heading', 'type' => 'text', 'config' => 'company.name_en'],
                'about.subtitle' => ['label' => 'Sub-heading', 'type' => 'text', 'config' => 'company.name_np'],
                'about.body_en' => ['label' => 'Story (English)', 'type' => 'textarea', 'default' => 'Om Realtors Pvt. Ltd. is a real estate services company based in Batukbhairab, Hanumansthan, Lagankhel, Lalitpur. We help buyers, sellers, and investors navigate every step of a property transaction — from accounting and land surveys to plotting, loans, map design, and buying or selling homes and land across the Kathmandu Valley.'],
                'about.body_np' => ['label' => 'Story (Nepali)', 'type' => 'textarea', 'default' => 'हामी ग्राहकहरूलाई घर जग्गा किनबेच, जग्गा नापजाँच, प्लटिङ्ग, ऋण सेवा र नक्सा डिजाइनमा विश्वसनीय र पारदर्शी सेवा प्रदान गर्दछौं।'],
                'about.stats.properties_label' => ['label' => 'Stat 1 label', 'type' => 'text', 'default' => 'Properties handled'],
                'about.stats.sold_label' => ['label' => 'Stat 2 label', 'type' => 'text', 'default' => 'Successful deals'],
                'about.cta_label' => ['label' => 'Button label', 'type' => 'text', 'default' => 'Get in touch'],
                'about.image_primary' => ['label' => 'Main image', 'type' => 'image', 'default_asset' => 'images/business-card-front.jpg'],
                'about.image_secondary' => ['label' => 'Second image', 'type' => 'image', 'default_asset' => 'images/business-card-back.jpg'],
                'about.cards.office_title' => ['label' => 'Card 1 heading', 'type' => 'text', 'default' => 'Our Office'],
                'about.cards.phone_title' => ['label' => 'Card 2 heading', 'type' => 'text', 'default' => 'Talk to Us'],
                'about.cards.email_title' => ['label' => 'Card 3 heading', 'type' => 'text', 'default' => 'Email'],
            ],
        ],

        'contact' => [
            'label' => 'Contact page',
            'fields' => [
                'contact.title' => ['label' => 'Page heading', 'type' => 'text', 'default' => 'Contact Us'],
                'contact.subtitle' => ['label' => 'Page subtitle', 'type' => 'textarea', 'default' => 'We usually respond within one business day.'],
                'contact.form_button' => ['label' => 'Form button label', 'type' => 'text', 'default' => 'Send Message'],
            ],
        ],

        'footer' => [
            'label' => 'Footer',
            'fields' => [
                'footer.about_text' => ['label' => 'Footer blurb (English)', 'type' => 'textarea', 'config' => 'company.tagline_en'],
                'footer.about_text_np' => ['label' => 'Footer blurb (Nepali)', 'type' => 'textarea', 'config' => 'company.tagline_np'],
                'footer.explore_title' => ['label' => 'Links column heading', 'type' => 'text', 'default' => 'Explore'],
                'footer.contact_title' => ['label' => 'Contact column heading', 'type' => 'text', 'default' => 'Contact'],
            ],
        ],

        'seo' => [
            'label' => 'SEO & sharing',
            'description' => 'Defaults used in the page <title> and meta description when a page does not set its own.',
            'fields' => [
                'seo.title' => ['label' => 'Default page title', 'type' => 'text', 'config' => 'company.name_en'],
                'seo.description' => ['label' => 'Default meta description', 'type' => 'textarea', 'config' => 'company.tagline_en'],
            ],
        ],

    ],

];
