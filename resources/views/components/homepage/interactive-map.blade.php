<!-- Interactive Map Section -->
<section id="interactive-map" class="relative h-screen overflow-hidden bg-gray-100">
    <div class="relative w-full h-full">
        <!-- Image Map -->
        <img id="map-image" src="/images/photos/DJI_0683.jpg" alt="Mirissa Area Map" class="w-full h-full object-cover">

        <!-- SVG Overlay for clickable areas -->
        <svg id="map-overlay" class="absolute inset-0 w-full h-full pointer-events-none" style="top: 0; left: 0;">
            <!-- Areas will be dynamically added here -->
        </svg>

        <!-- Floating Icon Buttons -->
        <div id="landmark-buttons" class="absolute inset-0 w-full h-full pointer-events-none">
            <!-- Buttons will be dynamically added here -->
        </div>
    </div>

    <!-- Popup Modal -->
    <div id="landmark-popup"
        class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-lg max-w-2xl w-full mx-4 transform scale-95 transition-transform duration-300 relative"
            id="popup-content">
            <!-- Close Button -->
            <button onclick="closeLandmarkPopup()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <!-- Popup Image -->
            <div class="h-64 overflow-hidden rounded-t-lg">
                <img id="popup-image" src="" alt="" class="w-full h-full object-cover">
            </div>

            <!-- Popup Content -->
            <div class="p-6">
                <h3 id="popup-title" class="text-3xl font-['STIX_Two_Text'] text-stone-700 mb-4"></h3>
                <p id="popup-description" class="text-lg text-stone-600 leading-relaxed"></p>
            </div>
        </div>
    </div>
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
            image: "/images/photos/DJI_0660.jpg",
            description: "A small rocky island accessible by foot during low tide. Known for its colorful parrots and stunning sunset views.",
            icon: '<svg class="w-full h-full" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        },
        "Saylors Mirissa": {
            coords: "3293,1965,3562,1972,3541,2205,3279,2198",
            centerX: 3420,
            centerY: 2090,
            image: "/images/photos/DJI_0712.jpg",
            description: "Your home base in paradise. Perfectly located in the heart of Mirissa with easy access to all major attractions.",
            icon: '<svg class="w-full h-full" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>'
        },
        "Coconut Tree Hill": {
            coords: "5767,4558,5710,4912,6530,5286,7300,6000,7979,6000,7979,4678,7519,4735,7032,4742,6191,4502",
            centerX: 6870,
            centerY: 5250,
            image: "/images/photos/DJI_0660.jpg",
            description: "Instagram-famous viewpoint with iconic coconut trees overlooking the ocean. Best visited at sunrise or sunset.",
            icon: '<svg class="w-full h-full" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>'
        },
        "Sandy Beach": {
            coords: "1223,1760,2057,1852,2247,1958,2163,2177,1823,2226,1449,2141,827,2332,106,1795,530,1774",
            centerX: 1176,
            centerY: 2050,
            image: "/images/photos/DJI_0660.jpg",
            description: "A pristine stretch of golden sand perfect for sunbathing and swimming. One of Mirissa's most beautiful beaches with calm waters.",
            icon: '<svg class="w-full h-full" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
        },
        "Surf Beach": {
            coords: "2052,2177,3187,2261,3392,2375,3371,2601,2466,2664,1753,2254",
            centerX: 2620,
            centerY: 2420,
            image: "/images/photos/DJI_0660.jpg",
            description: "Popular surf spot with consistent waves perfect for beginners and intermediate surfers. Surf lessons available.",
            icon: '<svg class="w-full h-full" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        },
        "Turtle Beach": {
            coords: "3367,2650,4155,2756,5428,3102,6170,3413,7011,3951,7265,4410,6876,4650,2580,2721",
            centerX: 4900,
            centerY: 3650,
            image: "/images/photos/DJI_0660.jpg",
            description: "Protected nesting ground for sea turtles. Visit during nesting season to witness baby turtles making their way to the ocean.",
            icon: '<svg class="w-full h-full" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>'
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

    function updateMapAreas() {
        const img = document.getElementById('map-image');
        const svg = document.getElementById('map-overlay');
        const buttonsContainer = document.getElementById('landmark-buttons');

        if (!img || !svg || !buttonsContainer) return;

        const containerRect = svg.getBoundingClientRect();

        // Calculate how object-cover scales and positions the image
        const imageAspect = ORIGINAL_WIDTH / ORIGINAL_HEIGHT;
        const containerAspect = containerRect.width / containerRect.height;

        let scale, offsetX, offsetY;

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

    function openLandmarkPopup(landmarkName) {
        const landmark = landmarkData[landmarkName];
        if (!landmark) return;

        const popup = document.getElementById('landmark-popup');
        const popupContent = document.getElementById('popup-content');

        document.getElementById('popup-title').textContent = landmarkName;
        document.getElementById('popup-description').textContent = landmark.description;
        document.getElementById('popup-image').src = landmark.image;
        document.getElementById('popup-image').alt = landmarkName;

        popup.classList.remove('hidden');

        setTimeout(() => {
            popup.classList.remove('opacity-0');
            popupContent.classList.remove('scale-95');
            popupContent.classList.add('scale-100');
        }, 10);

        document.body.style.overflow = 'hidden';
    }

    function closeLandmarkPopup() {
        const popup = document.getElementById('landmark-popup');
        const popupContent = document.getElementById('popup-content');

        popup.classList.add('opacity-0');
        popupContent.classList.remove('scale-100');
        popupContent.classList.add('scale-95');

        setTimeout(() => {
            popup.classList.add('hidden');
        }, 300);

        document.body.style.overflow = '';
    }

    // Initialize map areas when image loads
    const img = document.getElementById('map-image');
    img.addEventListener('load', updateMapAreas);

    // Update on window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updateMapAreas, 100);
    });

    // Close popup when clicking outside
    document.getElementById('landmark-popup')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeLandmarkPopup();
        }
    });

    // Close popup with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLandmarkPopup();
        }
    });

    // Initial update if image is already loaded
    if (img.complete) {
        updateMapAreas();
    }
</script>
