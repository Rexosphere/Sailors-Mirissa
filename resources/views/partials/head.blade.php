{{-- Get SEO config --}}
@php
    $seoConfig = config('seo');
    // Convert ComponentSlot to string if needed
    $pageKeyStr = isset($pageKey) ? (string)$pageKey : 'home';
    $pageSeo = $seoConfig['pages'][$pageKeyStr] ?? $seoConfig['pages']['home'];
    $currentUrl = url()->current();
    $ogImage = asset($seoConfig['images']['og_image']);
@endphp

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

{{-- Primary Meta Tags --}}
<title>{{ $title ?? $pageSeo['title'] }}</title>
<meta name="title" content="{{ $title ?? $pageSeo['title'] }}" />
<meta name="description" content="{{ $description ?? $pageSeo['description'] }}" />
<meta name="keywords" content="{{ $pageSeo['keywords'] }}" />
<meta name="author" content="{{ $seoConfig['site_name'] }}" />
<meta name="robots" content="index, follow" />
<meta name="language" content="English" />
<meta name="revisit-after" content="7 days" />

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $canonical ?? $currentUrl }}" />

{{-- Geographic Meta Tags --}}
<meta name="geo.region" content="LK-3" />
<meta name="geo.placename" content="Mirissa" />
<meta name="geo.position" content="{{ $seoConfig['business']['geo']['latitude'] }};{{ $seoConfig['business']['geo']['longitude'] }}" />
<meta name="ICBM" content="{{ $seoConfig['business']['geo']['latitude'] }}, {{ $seoConfig['business']['geo']['longitude'] }}" />

{{-- Open Graph / Facebook Meta Tags --}}
<meta property="og:type" content="{{ $pageSeo['og_type'] ?? 'website' }}" />
<meta property="og:url" content="{{ $currentUrl }}" />
<meta property="og:title" content="{{ $title ?? $pageSeo['title'] }}" />
<meta property="og:description" content="{{ $description ?? $pageSeo['description'] }}" />
<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:site_name" content="{{ $seoConfig['site_name'] }}" />
<meta property="og:locale" content="en_US" />

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ $currentUrl }}" />
<meta name="twitter:title" content="{{ $title ?? $pageSeo['title'] }}" />
<meta name="twitter:description" content="{{ $description ?? $pageSeo['description'] }}" />
<meta name="twitter:image" content="{{ $ogImage }}" />

{{-- Mobile & PWA Meta Tags --}}
<meta name="theme-color" content="#72B6B9" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="apple-mobile-web-app-title" content="{{ $seoConfig['site_name'] }}" />

{{-- Favicons & Web Manifest --}}
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">

{{-- Preconnect for Performance --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Nata+Sans:wght@500&display=swap" rel="stylesheet">

{{-- Structured Data - LocalBusiness & Hotel Schema --}}
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => ['Hotel', 'LodgingBusiness'],
                '@id' => $seoConfig['site_url'] . '#hotel',
                'name' => $seoConfig['business']['name'],
                'legalName' => $seoConfig['business']['legal_name'],
                'url' => $seoConfig['site_url'],
                'logo' => asset($seoConfig['images']['og_image']),
                'image' => $ogImage,
                'description' => $pageSeo['description'],
                'priceRange' => $seoConfig['business']['price_range'],
                'telephone' => $seoConfig['business']['contact']['phone'],
                'email' => $seoConfig['business']['contact']['email'],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $seoConfig['business']['address']['street'],
                    'addressLocality' => $seoConfig['business']['address']['city'],
                    'addressRegion' => $seoConfig['business']['address']['region'],
                    'postalCode' => $seoConfig['business']['address']['postal_code'],
                    'addressCountry' => $seoConfig['business']['address']['country']
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => $seoConfig['business']['geo']['latitude'],
                    'longitude' => $seoConfig['business']['geo']['longitude']
                ],
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => $seoConfig['business']['rating']['value'],
                    'reviewCount' => $seoConfig['business']['rating']['count']
                ],
                'amenityFeature' => [
                    ['@type' => 'LocationFeatureSpecification', 'name' => 'Free WiFi', 'value' => true],
                    ['@type' => 'LocationFeatureSpecification', 'name' => 'Free Parking', 'value' => true],
                    ['@type' => 'LocationFeatureSpecification', 'name' => 'Air Conditioning', 'value' => true],
                    ['@type' => 'LocationFeatureSpecification', 'name' => 'Beach Access', 'value' => true],
                    ['@type' => 'LocationFeatureSpecification', 'name' => 'Room Service', 'value' => true]
                ],
                'sameAs' => [
                    $seoConfig['social']['facebook'],
                    $seoConfig['social']['instagram']
                ]
            ],
            [
                '@type' => 'Organization',
                '@id' => $seoConfig['site_url'] . '#organization',
                'name' => $seoConfig['business']['name'],
                'url' => $seoConfig['site_url'],
                'logo' => asset($seoConfig['images']['og_image']),
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => $seoConfig['business']['contact']['phone'],
                    'contactType' => 'customer service',
                    'email' => $seoConfig['business']['contact']['email'],
                    'availableLanguage' => ['English', 'Sinhala']
                ],
                'sameAs' => [
                    $seoConfig['social']['facebook'],
                    $seoConfig['social']['instagram']
                ]
            ]
        ]
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
