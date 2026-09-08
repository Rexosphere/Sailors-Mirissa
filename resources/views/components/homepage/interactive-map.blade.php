@php
    $landmarks = \App\Models\MapPoint::orderBy('name')->get();
    $landmarkData = $landmarks->mapWithKeys(fn ($point) => [
        $point->name => [
            'coords' => $point->coords,
            'centerX' => $point->center_x,
            'centerY' => $point->center_y,
            'image' => $point->image_url,
            'description' => $point->description,
            'icon' => $point->icon,
        ],
    ]);
@endphp

<!-- Interactive Map Section -->
<section id="interactive-map" class="fp-screen bg-gray-100" data-fp-section data-header-theme="dark" tabindex="-1" aria-label="Explore Mirissa">

    <!-- Desktop: clickable map -->
    <div class="relative hidden h-full w-full md:block">
        <div class="relative h-full w-full">
            <!-- Image Map -->
            <img id="map-image" src="/images/photos/interactive-map.avif" alt="Mirissa Area Map" decoding="async"
                class="h-full w-full object-cover">

            <!-- SVG Overlay for clickable areas -->
            <svg id="map-overlay" class="pointer-events-none absolute inset-0 h-full w-full" style="top: 0; left: 0;" aria-hidden="true">
                <!-- Areas will be dynamically added here -->
            </svg>

            <!-- Floating Icon Buttons -->
            <div id="landmark-buttons" class="pointer-events-none absolute inset-0 h-full w-full">
                <!-- Buttons will be dynamically added here -->
            </div>
        </div>

        <!-- Floating Card Popup -->
        <div id="floating-card" class="pointer-events-none absolute z-40 opacity-0 transition-all duration-500">
            <div id="card-content"
                class="pointer-events-all glass-card max-w-sm scale-90 transform overflow-hidden rounded-2xl">
                <div class="relative h-48 overflow-hidden">
                    <img id="card-image" src="" alt="" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a1628]/80 via-[#0a1628]/10 to-transparent"></div>
                    <button id="close-card" type="button" aria-label="Close"
                        class="absolute right-3 top-3 grid size-10 place-items-center rounded-full bg-white/15 text-white backdrop-blur transition hover:bg-white/30 active:scale-95">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <p class="fp-eyebrow !text-[#8fd0d3]">Landmark</p>
                    <h3 id="card-title" class="mt-1 mb-3 font-serif text-2xl font-bold text-white"></h3>
                    <p id="card-description" class="leading-relaxed text-white/80"></p>
                </div>
            </div>
        </div>

        <!-- Curved Connection Line -->
        <svg id="connection-line" class="pointer-events-none absolute inset-0 z-30" width="100%" height="100%" aria-hidden="true">
            <path id="curved-path" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-dasharray="7,7" opacity="0.85"
                filter="drop-shadow(0 4px 6px rgba(0,0,0,0.3))">
            </path>
        </svg>
    </div>

    <!-- Mobile: map backdrop + swipeable landmark cards -->
    <div class="relative flex h-full flex-col md:hidden" data-carousel-group>
        <img src="/images/photos/interactive-map.avif" alt="" loading="lazy" decoding="async"
            class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-black/70"></div>

        <div class="relative z-10 flex h-full flex-col pb-16 pt-24">
            <div class="px-5">
                <p class="fp-eyebrow !text-[#8fd0d3]">Around the hotel</p>
                <h2 class="mt-1 font-serif text-3xl font-bold text-white">Explore Mirissa</h2>
                <p class="mt-1 text-sm text-white/80">Swipe through the landmarks within reach</p>
            </div>

            <div data-carousel class="fp-carousel mt-4 flex min-h-0 flex-1 snap-x snap-mandatory items-center gap-4 overflow-x-auto px-5">
                @foreach ($landmarks as $point)
                    <article class="glass-card w-[78vw] max-w-sm shrink-0 snap-center overflow-hidden rounded-2xl">
                        <div class="relative h-[28dvh] max-h-64">
                            <img src="{{ $point->image_url }}" alt="{{ $point->name }}" loading="lazy" decoding="async" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a1628]/70 to-transparent"></div>
                            @if ($point->icon)
                                <span class="absolute left-3 top-3 grid size-11 place-items-center rounded-full bg-[#0a1628]/60 p-2 backdrop-blur">{!! $point->icon !!}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-serif text-lg font-bold text-white">{{ $point->name }}</h3>
                            <p class="mt-1 line-clamp-3 text-sm leading-relaxed text-white/80">{{ $point->description }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div data-carousel-dots class="mt-2 flex justify-center text-white"></div>
        </div>
    </div>

    <x-scroll-next target="floor-booking" label="our rooms" theme="dark" />
</section>

<style>
    #map-overlay polygon {
        fill: transparent;
        stroke: transparent;
        stroke-width: 4;
        stroke-dasharray: 5, 20;
        stroke-linecap: round;
        stroke-linejoin: round;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    #map-overlay polygon.highlight {
        stroke-width: 5;
        filter: drop-shadow(0 0 20px rgba(0, 0, 0, 0.3));
    }

    #map-overlay polygon.active {
        stroke-width: 6;
        filter: drop-shadow(0 0 25px rgba(255, 255, 255, 0.6));
        transition: all 0.4s ease;
    }

    .landmark-button.active .landmark-icon {
        opacity: 1 !important;
        transform: scale(1.2) !important;
        transition: opacity 0.3s ease, transform 0.3s ease !important;
        filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.8));
    }

    #floating-card.visible {
        opacity: 1;
    }

    #floating-card.visible #card-content {
        transform: scale(1);
    }

    .landmark-button {
        position: absolute;
        pointer-events: all;
        transform: translate(-50%, -100%);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Ripple effect container */
    .landmark-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translate(-50%, 0);
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.6);
        z-index: 1;
        animation: ripple 2s ease-out infinite;
    }

    .landmark-button:hover .landmark-icon,
    .landmark-button:focus-visible .landmark-icon {
        transform: scale(1.5);
        filter: drop-shadow(0px 10px 20px rgba(0, 0, 0, 1)) drop-shadow(0 0 25px rgba(255, 255, 255, 1)) drop-shadow(0 0 40px rgba(255, 255, 255, 0.8)) drop-shadow(0 0 60px rgba(255, 255, 255, 0.5));
        animation: none;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .landmark-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: transparent;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 6px 16px rgba(0, 0, 0, 0.8)) drop-shadow(0 0 12px rgba(255, 255, 255, 0.6)) drop-shadow(0 0 20px rgba(255, 255, 255, 0.4));
        transition: transform 0.3s ease, filter 0.3s ease;
        animation: gentle-pulse 2.5s ease-in-out infinite;
    }

    /* Pulsing animation for icons */
    @keyframes gentle-pulse {

        0%,
        100% {
            transform: scale(1);
            filter: drop-shadow(0 6px 16px rgba(0, 0, 0, 0.8)) drop-shadow(0 0 12px rgba(255, 255, 255, 0.6)) drop-shadow(0 0 20px rgba(255, 255, 255, 0.4));
        }

        50% {
            transform: scale(1.05);
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.9)) drop-shadow(0 0 18px rgba(255, 255, 255, 0.8)) drop-shadow(0 0 30px rgba(255, 255, 255, 0.6));
        }
    }

    /* Ripple animation - expanding ring effect */
    @keyframes ripple {
        0% {
            transform: translate(-50%, 0) scale(1);
            opacity: 0.6;
        }

        100% {
            transform: translate(-50%, 0) scale(2.5);
            opacity: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .landmark-button::before,
        .landmark-icon {
            animation: none;
        }
    }
</style>

<script>
    // Landmark configuration with original image coordinates
    // Original image dimensions: 8000 x 6000
    const ORIGINAL_WIDTH = 8000;
    const ORIGINAL_HEIGHT = 6000;

    const landmarkData = {!! json_encode($landmarkData) !!};

    function scaleCoordinates(coordsString, scaleX, scaleY, offsetX, offsetY) {
        const coords = coordsString.split(',').map(Number);
        const scaledCoords = [];

        for (let i = 0; i < coords.length; i += 2) {
            scaledCoords.push((coords[i] * scaleX) + offsetX);
            scaledCoords.push((coords[i + 1] * scaleY) + offsetY);
        }

        return scaledCoords.join(',');
    }

    let scale, offsetX, offsetY; // Make these global for popup positioning

    function updateMapAreas() {
        const img = document.getElementById('map-image');
        const svg = document.getElementById('map-overlay');
        const buttonsContainer = document.getElementById('landmark-buttons');

        if (!img || !svg || !buttonsContainer) return;

        const containerRect = svg.getBoundingClientRect();
        if (containerRect.width === 0) return;

        // Calculate how object-cover scales and positions the image
        const imageAspect = ORIGINAL_WIDTH / ORIGINAL_HEIGHT;
        const containerAspect = containerRect.width / containerRect.height;

        if (containerAspect > imageAspect) {
            scale = containerRect.width / ORIGINAL_WIDTH;
            offsetX = 0;
            offsetY = (containerRect.height - (ORIGINAL_HEIGHT * scale)) / 2;
        } else {
            scale = containerRect.height / ORIGINAL_HEIGHT;
            offsetX = (containerRect.width - (ORIGINAL_WIDTH * scale)) / 2;
            offsetY = 0;
        }

        svg.innerHTML = '';
        buttonsContainer.innerHTML = '';
        svg.setAttribute('viewBox', `0 0 ${containerRect.width} ${containerRect.height}`);

        Object.entries(landmarkData).forEach(([name, data]) => {
            const polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
            const scaledCoords = scaleCoordinates(data.coords, scale, scale, offsetX, offsetY);

            polygon.setAttribute('points', scaledCoords);
            polygon.setAttribute('data-landmark', name);
            polygon.setAttribute('id', `polygon-${name.replace(/\s+/g, '-')}`);

            svg.appendChild(polygon);

            const buttonX = (data.centerX * scale) + offsetX;
            const buttonY = (data.centerY * scale) + offsetY;

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'landmark-button';
            button.style.left = `${buttonX}px`;
            button.style.top = `${buttonY}px`;
            button.setAttribute('data-landmark', name);
            button.setAttribute('aria-label', name);

            button.innerHTML = `<div class="landmark-icon">${data.icon ?? ''}</div>`;

            button.addEventListener('mouseenter', () => polygon.classList.add('highlight'));
            button.addEventListener('mouseleave', () => polygon.classList.remove('highlight'));
            button.addEventListener('click', () => openLandmarkPopup(name));

            buttonsContainer.appendChild(button);
        });
    }

    let activeLandmark = null;
    const floatingCard = document.getElementById('floating-card');
    const cardImage = document.getElementById('card-image');
    const cardTitle = document.getElementById('card-title');
    const cardDescription = document.getElementById('card-description');
    const curvedPath = document.getElementById('curved-path');

    function openLandmarkPopup(landmarkName) {
        if (activeLandmark === landmarkName) return;
        closeLandmarkPopup();

        const landmark = landmarkData[landmarkName];
        if (!landmark) return;

        activeLandmark = landmarkName;

        cardTitle.textContent = landmarkName;
        cardDescription.textContent = landmark.description;
        cardImage.src = landmark.image;
        cardImage.alt = landmarkName;

        const button = document.querySelector(`.landmark-button[data-landmark="${landmarkName}"]`);
        const polygon = document.getElementById(`polygon-${landmarkName.replace(/\s+/g, '-')}`);

        if (!button) return;

        polygon.classList.add('active');
        button.classList.add('active');

        positionPopup();

        floatingCard.classList.add('visible');
    }

    function positionPopup() {
        if (!activeLandmark) return;

        const button = document.querySelector(`.landmark-button[data-landmark="${activeLandmark}"]`);
        if (!button) return;

        const container = document.getElementById('interactive-map');
        const containerRect = container.getBoundingClientRect();

        const markerX = button.offsetLeft + button.offsetWidth / 2;
        const markerY = button.offsetTop;

        const cardWidth = 384;
        const cardHeight = 500;

        let cardX = markerX + 80;
        let cardY = markerY - cardHeight / 2;

        if (cardX + cardWidth > containerRect.width - 20) {
            cardX = markerX - cardWidth - 80;
        }
        if (cardY < 100) cardY = 100;
        if (cardY + cardHeight > containerRect.height - 20) {
            cardY = containerRect.height - cardHeight - 20;
        }

        floatingCard.style.left = `${cardX}px`;
        floatingCard.style.top = `${cardY}px`;

        const startX = markerX;
        const startY = markerY;
        const endX = cardX + (cardX > markerX ? 0 : cardWidth);
        const endY = cardY + cardHeight / 2;

        const ctrl1X = startX + (endX - startX) * 0.5;
        const ctrl1Y = startY - 100;
        const ctrl2X = endX;
        const ctrl2Y = endY - 80;

        curvedPath.setAttribute('d', `M ${startX} ${startY} C ${ctrl1X} ${ctrl1Y}, ${ctrl2X} ${ctrl2Y}, ${endX} ${endY}`);
    }

    function closeLandmarkPopup() {
        if (!activeLandmark) return;

        const polygon = document.getElementById(`polygon-${activeLandmark.replace(/\s+/g, '-')}`);
        const button = document.querySelector('.landmark-button.active');

        polygon?.classList.remove('active');
        button?.classList.remove('active');

        floatingCard.classList.remove('visible');
        curvedPath.setAttribute('d', '');
        activeLandmark = null;
    }

    document.getElementById('close-card')?.addEventListener('click', (e) => {
        e.stopPropagation();
        closeLandmarkPopup();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLandmarkPopup();
    });

    document.addEventListener('click', (e) => {
        if (!activeLandmark) return;

        const cardContent = document.getElementById('card-content');
        const clickedButton = e.target.closest('.landmark-button');

        if (!cardContent.contains(e.target) && !clickedButton) {
            closeLandmarkPopup();
        }
    });

    const mapImage = document.getElementById('map-image');
    mapImage.addEventListener('load', updateMapAreas);

    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            updateMapAreas();
            positionPopup();
        }, 100);
    });

    if (mapImage.complete) {
        updateMapAreas();
    }
</script>
