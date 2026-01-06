<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SEO Settings
    |--------------------------------------------------------------------------
    |
    | Default meta tags and SEO settings for the website
    |
    */

    'site_name' => "Sailor's Mirissa",
    'site_url' => env('APP_URL', 'https://sailorsmirissa.com'),
    
    // Business Information
    'business' => [
        'name' => "Sailor's Mirissa",
        'legal_name' => "Sailor's Mirissa Guest House",
        'type' => 'Hotel',
        'address' => [
            'street' => 'Bandaramulla',
            'city' => 'Mirissa',
            'region' => 'Southern Province',
            'postal_code' => '81740',
            'country' => 'LK',
        ],
        'geo' => [
            'latitude' => '5.9467',
            'longitude' => '80.4707',
        ],
        'contact' => [
            'email' => 'sailors.mirissa@gmail.com',
            'phone' => '+94412260652',
            'phone_alt' => '+94718170002',
            'hotline' => '+94770020151',
        ],
        'price_range' => '$$',
        'rating' => [
            'value' => '4.5',
            'count' => '150',
        ],
    ],

    // Social Media Profiles
    'social' => [
        'facebook' => 'https://www.facebook.com/sailorsmirissa/',
        'instagram' => 'https://www.instagram.com/sailors_mirissa/',
    ],

    // Default Images
    'images' => [
        'og_image' => '/cover.png',
        'logo' => '/images/logo.png',
    ],

    // Target Keywords
    'keywords' => [
        'primary' => [
            'hotel in Mirissa',
            'Mirissa accommodation',
            'beach hotel Mirissa',
            'guesthouse Mirissa Sri Lanka',
        ],
        'secondary' => [
            'Mirissa beach stay',
            'affordable hotel Mirissa',
            'sea view rooms Mirissa',
            'whale watching Mirissa hotel',
            'Coconut Tree Hill hotel',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Page-Specific SEO Settings
    |--------------------------------------------------------------------------
    |
    | SEO settings for individual pages
    |
    */

    'pages' => [
        'home' => [
            'title' => "Sailor's Mirissa - Cozy Beach Hotel in Mirissa, Sri Lanka | Steps from the Beach",
            'description' => "Experience cozy stays at Sailors Mirissa, steps from Mirissa Beach in Sri Lanka. Enjoy free WiFi, parking, room service, and sea views in the heart of the tourist zone. Book now for a relaxing getaway!",
            'keywords' => 'hotel in Mirissa, Mirissa accommodation, beach hotel Mirissa, guesthouse Mirissa Sri Lanka, Mirissa beach stay, affordable hotel Mirissa',
            'og_type' => 'website',
        ],
        'accommodation' => [
            'title' => "Rooms & Accommodation - Sailor's Mirissa | Single, Double, Triple & Family Rooms",
            'description' => "Choose from single, double, triple, or family rooms at Sailors Mirissa. All rooms feature AC, WiFi, and modern amenities. Just 2 minutes walk to Mirissa Beach. Book your perfect room today!",
            'keywords' => 'Mirissa hotel rooms, sea view rooms Mirissa, family rooms Mirissa, affordable accommodation Mirissa, beach hotel rooms',
            'og_type' => 'website',
        ],
        'experiences' => [
            'title' => "Things to Do in Mirissa - Experiences & Activities | Sailor's Mirissa",
            'description' => "Discover the best experiences in Mirissa! Whale watching, surfing, Coconut Tree Hill, Secret Beach, and more. Your perfect Sri Lanka adventure starts at Sailors Mirissa.",
            'keywords' => 'things to do in Mirissa, Mirissa activities, whale watching Mirissa, Coconut Tree Hill, Mirissa surfing, Secret Beach',
            'og_type' => 'website',
        ],
        'location' => [
            'title' => "Location - Sailor's Mirissa | Heart of Mirissa, 2 Minutes to Beach",
            'description' => "Perfectly located in the heart of Mirissa, just 2 minutes walk to the beach. Easy access to Coconut Tree Hill, whale watching harbor, restaurants, and Galle Fort. Find us in Bandaramulla, Mirissa.",
            'keywords' => 'Mirissa location, where to stay in Mirissa, Mirissa beach hotel location, hotels near Coconut Tree Hill, Mirissa map',
            'og_type' => 'website',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Structured Data Templates
    |--------------------------------------------------------------------------
    |
    | JSON-LD structured data templates
    |
    */

    'structured_data' => [
        'organization' => true,
        'local_business' => true,
        'hotel' => true,
        'breadcrumbs' => true,
    ],
];
