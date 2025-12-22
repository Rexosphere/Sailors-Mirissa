<!-- Interactive Map Section -->
<section id="interactive-map" class="relative h-screen overflow-hidden bg-gray-100">
    <div class="relative w-full h-full">
        <!-- Image Map -->
        <img id="map-image" src="/images/photos/interactive-map.avif" alt="Mirissa Area Map" class="w-full h-full object-cover">

        <!-- SVG Overlay for clickable areas -->
        <svg id="map-overlay" class="absolute inset-0 w-full h-full pointer-events-none" style="top: 0; left: 0;">
            <!-- Areas will be dynamically added here -->
        </svg>

        <!-- Floating Icon Buttons -->
        <div id="landmark-buttons" class="absolute inset-0 w-full h-full pointer-events-none">
            <!-- Buttons will be dynamically added here -->
        </div>
    </div>

    <!-- Floating Card Popup -->
    <div id="floating-card" class="fixed pointer-events-none z-40 opacity-0 transition-all duration-500">
        <div id="card-content" class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl max-w-sm overflow-hidden pointer-events-all transform scale-90">
            <div class="h-48 relative overflow-hidden">
                <img id="card-image" src="" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <button id="close-card" class="absolute top-3 right-3 bg-white/20 backdrop-blur p-2 rounded-full hover:bg-white/40 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <h3 id="card-title" class="text-2xl font-bold text-stone-800 mb-3 font-['STIX_Two_Text']"></h3>
                <p id="card-description" class="text-stone-600 leading-relaxed"></p>
            </div>
        </div>
    </div>

    <!-- Curved Connection Line -->
    <svg id="connection-line" class="fixed inset-0 pointer-events-none z-30" width="100%" height="100%">
        <path id="curved-path" fill="none" stroke="#ffffff" stroke-width="3" stroke-dasharray="8,6" opacity="0.9"
            filter="drop-shadow(0 4px 6px rgba(0,0,0,0.3))">
        </path>
    </svg>
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
        /* fill: rgba(255, 255, 255, 0.2); */
        /* stroke: rgba(255, 255, 255, 0.5); */
        stroke-width: 5;
        filter: drop-shadow(0 0 20px rgba(0, 0, 0, 0.3));
    }

    #map-overlay polygon.active {
        /* fill: rgba(255, 255, 255, 0.25) !important; */
        /* stroke: #ffffff !important; */
        stroke-width: 6;
        filter: drop-shadow(0 0 25px rgba(255, 255, 255, 0.6));
        transition: all 0.4s ease;
    }

    .landmark-button.active .landmark-icon {
        opacity: 0 !important;
        transform: scale(0) !important;
        transition: opacity 0.3s ease, transform 0.3s ease !important;
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

    .landmark-button:hover .landmark-icon {
        /* transform: scale(1.5);
        box-shadow: 0px 11px 19px rgba(255, 255, 255, 0.6); */

        transform: scale(1.5);
        /* Use filter: drop-shadow instead of box-shadow */
        filter: drop-shadow(0px 8px 8px rgba(242, 242, 242, 0.9));
        /* You may need to add transition to the filter property as well */
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .landmark-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: transparent;
        /* backdrop-filter: blur(10px); */
        display: flex;
        align-items: center;
        justify-content: center;
        /* box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2); */
        cursor: pointer;
        position: relative;
        z-index: 2;
        /* transition: transform 0.3s ease; */

        filter: drop-shadow(0 4px 12px rgba(255, 255, 255, 0.2));
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .landmark-tail {
        display: none;
        width: 2px;
        height: 60px;
        z-index: 1;
    }

    .landmark-tail svg {
        width: 100%;
        height: 100%;
    }
</style>

<script>
    // Landmark configuration with original image coordinates
    // Original image dimensions: 8000 x 6000 (adjust if different)
    const ORIGINAL_WIDTH = 8000;
    const ORIGINAL_HEIGHT = 6000;

    const landmarkData = {
        "Parrot Island": {
            coords: "834,2339,1470,2155,1803,2247,1590,2339,1046,2403",
            centerX: 1350,
            centerY: 2300,
            image: "/images/photos/hero-background.avif",
            description: "A small rocky island accessible by foot during low tide. Known for its colorful parrots and stunning sunset views.",
            icon: '<img src="/images/icons/hawaii/white-parrot.avif" class="w-full h-full object-contain" alt="Parrot">'
        },
        "Saylors Mirissa": {
            coords: "3293,1965,3562,1972,3541,2205,3279,2198",
            centerX: 3420,
            centerY: 2090,
            image: "/images/photos/360-panaroma.avif",
            description: "Your home base in paradise. Perfectly located in the heart of Mirissa with easy access to all major attractions.",
            icon: '<img src="/images/icons/hawaii/white-hotel.avif" class="w-full h-full object-contain" alt="Hotel">'
        },
        "Coconut Tree Hill": {
            coords: "5767,4558,5710,4912,6530,5286,7300,6000,7979,6000,7979,4678,7519,4735,7032,4742,6191,4502",
            centerX: 6870,
            centerY: 5250,
            image: "/images/photos/hero-background.avif",
            description: "Instagram-famous viewpoint with iconic coconut trees overlooking the ocean. Best visited at sunrise or sunset.",
            icon: '<img src="/images/icons/hawaii/white-coconut-tree.avif" class="w-full h-full object-contain" alt="Coconut Tree">'
        },
        "Sandy Beach": {
            coords: "1223,1760,2057,1852,2247,1958,2163,2177,1823,2226,1449,2141,827,2332,106,1795,530,1774",
            centerX: 1176,
            centerY: 2050,
            image: "/images/photos/hero-background.avif",
            description: "A pristine stretch of golden sand perfect for sunbathing and swimming. One of Mirissa's most beautiful beaches with calm waters.",
            icon: '<img src="/images/icons/hawaii/white-sun.avif" class="w-full h-full object-contain" alt="Sun">'
        },
        "Surf Beach": {
            coords: "2052,2177,3187,2261,3392,2375,3371,2601,2466,2664,1753,2254",
            centerX: 2620,
            centerY: 2420,
            image: "/images/photos/hero-background.avif",
            description: "Popular surf spot with consistent waves perfect for beginners and intermediate surfers. Surf lessons available.",
            icon: '<img src="/images/icons/hawaii/white-surfboard.avif" class="w-full h-full object-contain" alt="Surfboard">'
        },
        "Turtle Beach": {
            coords: "3367,2650,4155,2756,5428,3102,6170,3413,7011,3951,7265,4410,6876,4650,2580,2721",
            centerX: 4900,
            centerY: 3650,
            image: "/images/photos/hero-background.avif",
            description: "Protected nesting ground for sea turtles. Visit during nesting season to witness baby turtles making their way to the ocean.",
            icon: '<img src="/images/icons/hawaii/white-turtle.avif" class="w-full h-full object-contain" alt="Turtle">'
        }
    };

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

        // Calculate how object-cover scales and positions the image
        const imageAspect = ORIGINAL_WIDTH / ORIGINAL_HEIGHT;
        const containerAspect = containerRect.width / containerRect.height;

        if (containerAspect > imageAspect) {
            // Container is wider - image fills width, crops top/bottom
            scale = containerRect.width / ORIGINAL_WIDTH;
            offsetX = 0;
            offsetY = (containerRect.height - (ORIGINAL_HEIGHT * scale)) / 2;
        } else {
            // Container is taller - image fills height, crops left/right
            scale = containerRect.height / ORIGINAL_HEIGHT;
            offsetX = (containerRect.width - (ORIGINAL_WIDTH * scale)) / 2;
            offsetY = 0;
        }

        // Clear existing polygons and buttons
        svg.innerHTML = '';
        buttonsContainer.innerHTML = '';
        svg.setAttribute('viewBox', `0 0 ${containerRect.width} ${containerRect.height}`);

        // Create polygons and buttons for each landmark
        Object.entries(landmarkData).forEach(([name, data]) => {
            // Create polygon
            const polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
            const scaledCoords = scaleCoordinates(data.coords, scale, scale, offsetX, offsetY);

            polygon.setAttribute('points', scaledCoords);
            polygon.setAttribute('data-landmark', name);
            polygon.setAttribute('id', `polygon-${name.replace(/\s+/g, '-')}`);

            svg.appendChild(polygon);

            // Create floating button
            const buttonX = (data.centerX * scale) + offsetX;
            const buttonY = (data.centerY * scale) + offsetY;

            const button = document.createElement('div');
            button.className = 'landmark-button';
            button.style.left = `${buttonX}px`;
            button.style.top = `${buttonY}px`;
            button.setAttribute('data-landmark', name);

            button.innerHTML = `
                <div class="landmark-icon">
                    ${data.icon}
                </div>
                <div class="landmark-tail">
                    <svg viewBox="0 0 2 60" xmlns="http://www.w3.org/2000/svg">
                        <line x1="1" y1="0" x2="1" y2="60" stroke="rgba(255,255,255,0.8)" stroke-width="2" stroke-dasharray="5,5" stroke-linecap="round"/>
                    </svg>
                </div>
            `;

            // Add hover listeners
            button.addEventListener('mouseenter', () => {
                polygon.classList.add('highlight');
            });

            button.addEventListener('mouseleave', () => {
                polygon.classList.remove('highlight');
            });

            button.addEventListener('click', () => openLandmarkPopup(name));

            buttonsContainer.appendChild(button);
        });
    }

    let activeLandmark = null;
    const floatingCard = document.getElementById('floating-card');
    const cardContent = document.getElementById('card-content');
    const cardImage = document.getElementById('card-image');
    const cardTitle = document.getElementById('card-title');
    const cardDescription = document.getElementById('card-description');
    const curvedPath = document.getElementById('curved-path');

    function openLandmarkPopup(landmarkName) {
        if (activeLandmark === landmarkName) return;
        closeLandmarkPopup(); // Close any previous

        const landmark = landmarkData[landmarkName];
        if (!landmark) return;

        activeLandmark = landmarkName;

        // Update card content
        cardTitle.textContent = landmarkName;
        cardDescription.textContent = landmark.description;
        cardImage.src = landmark.image;
        cardImage.alt = landmarkName;

        // Find the button and polygon
        const button = document.querySelector(`.landmark-button[data-landmark="${landmarkName}"]`);
        const polygon = document.getElementById(`polygon-${landmarkName.replace(/\s+/g, '-')}`);

        if (!button) return;

        // Highlight polygon and button
        polygon.classList.add('active');
        button.classList.add('active');

        // Position the popup
        positionPopup();

        floatingCard.classList.add('visible');
    }

    function positionPopup() {
        if (!activeLandmark) return;

        const button = document.querySelector(`.landmark-button[data-landmark="${activeLandmark}"]`);
        if (!button) return;

        // Get button position relative to viewport
        const buttonRect = button.getBoundingClientRect();
        const markerX = buttonRect.left + buttonRect.width / 2;
        const markerY = buttonRect.top;

        // Card dimensions (approx)
        const cardWidth = 384;
        const cardHeight = 500;

        // Decide card position (prefer right, fallback left/top/bottom)
        let cardX = markerX + 80;
        let cardY = markerY - cardHeight / 2;

        if (cardX + cardWidth > window.innerWidth - 20) {
            cardX = markerX - cardWidth - 80;
        }
        if (cardY < 20) cardY = 20;
        if (cardY + cardHeight > window.innerHeight - 20) {
            cardY = window.innerHeight - cardHeight - 20;
        }

        // Position card
        floatingCard.style.left = `${cardX}px`;
        floatingCard.style.top = `${cardY}px`;

        // Draw curved connection line
        const startX = markerX;
        const startY = markerY; // top of icon
        const endX = cardX + (cardX > markerX ? 0 : cardWidth);
        const endY = cardY + cardHeight / 2;

        const ctrl1X = startX + (endX - startX) * 0.5;
        const ctrl1Y = startY - 100;
        const ctrl2X = endX;
        const ctrl2Y = endY - 80;

        const pathData = `M ${startX} ${startY}
                        C ${ctrl1X} ${ctrl1Y}, ${ctrl2X} ${ctrl2Y}, ${endX} ${endY}`;

        curvedPath.setAttribute('d', pathData);

        // Reset dash animation only on initial open
        if (!floatingCard.classList.contains('visible')) {
            curvedPath.querySelector('animate')?.beginElement();
        }
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

    // Close on button click
    document.getElementById('close-card')?.addEventListener('click', (e) => {
        e.stopPropagation();
        closeLandmarkPopup();
    });

    // Close on escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLandmarkPopup();
    });

    // Close when clicking outside the card
    document.addEventListener('click', (e) => {
        if (!activeLandmark) return;

        const cardContent = document.getElementById('card-content');
        const landmarkButtons = document.querySelectorAll('.landmark-button');

        // Check if click is outside card and not on any landmark button
        let clickedButton = false;
        landmarkButtons.forEach(button => {
            if (button.contains(e.target)) clickedButton = true;
        });

        if (!cardContent.contains(e.target) && !clickedButton) {
            closeLandmarkPopup();
        }
    });

    // Initialize map areas when image loads
    const img = document.getElementById('map-image');
    img.addEventListener('load', updateMapAreas);

    // Update on window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            updateMapAreas();
            positionPopup(); // Reposition popup if open
        }, 100);
    });

    // Update popup position on scroll
    window.addEventListener('scroll', () => {
        positionPopup();
    }, { passive: true });

    // Initial update if image is already loaded
    if (img.complete) {
        updateMapAreas();
    }
</script>
