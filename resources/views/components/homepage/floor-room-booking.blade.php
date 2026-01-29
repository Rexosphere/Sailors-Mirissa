<section id="floor-booking" class="relative h-screen overflow-hidden bg-gray-100">
    <!-- Page Title -->
    <div class="absolute top-0 left-0 right-0 z-30 text-center py-8">
        <h1 class="text-3xl md:text-5xl font-bold font-serif text-black">Explore Our Rooms</h1>
        <p class="text-black mt-3 text-lg font-light tracking-wide">Select a floor to discover available accommodations</p>
    </div>

    <!-- Hotel Floor Image (Fullscreen Background) -->
    <div id="hotel-container" class="relative w-full h-full" style="background-color: ivory;">
        <img src="{{ asset('images/building_transparent.png') }}" alt="Hotel Floors" class="absolute right-0 top-1/2 -translate-y-1/2 w-1/2 h-3/4 object-contain" />
        
        <!-- SVG Overlay for Lines -->
        <svg id="svg-overlay" viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 10;">
            <defs>
                <marker id="dot-marker" viewBox="0 0 10 10" refX="5" refY="5" markerWidth="6" markerHeight="6">
                    <circle cx="5" cy="5" r="5" fill="#fff" />
                </marker>
            </defs>
            <!-- Clickable floor indicators (dashed boxes) -->

            <!-- Note: pointer-events="auto" allows clicking these polygons even if parent config is none -->
            <polygon id="floor-box-ground" points="" stroke="white" stroke-width="3" stroke-dasharray="8,6" stroke-linecap="round" stroke-linejoin="round"
                fill="transparent" class="floor-box cursor-pointer" style="pointer-events: auto; opacity: 0.9; filter: drop-shadow(0px 0px 1px rgba(0,0,0,0.8)); vector-effect: non-scaling-stroke;" />
            <polygon id="floor-box-first" points="" stroke="white" stroke-width="3" stroke-dasharray="8,6" stroke-linecap="round" stroke-linejoin="round"
                fill="transparent" class="floor-box cursor-pointer" style="pointer-events: auto; opacity: 0.9; filter: drop-shadow(0px 0px 1px rgba(0,0,0,0.8)); vector-effect: non-scaling-stroke;" />
            <polygon id="floor-box-second" points="" stroke="white" stroke-width="3" stroke-dasharray="8,6" stroke-linecap="round" stroke-linejoin="round"
                fill="transparent" class="floor-box cursor-pointer" style="pointer-events: auto; opacity: 0.9; filter: drop-shadow(0px 0px 1px rgba(0,0,0,0.8)); vector-effect: non-scaling-stroke;" />
            <polygon id="floor-box-third" points="" stroke="white" stroke-width="3" stroke-dasharray="8,6" stroke-linecap="round" stroke-linejoin="round"
                fill="transparent" class="floor-box cursor-pointer" style="pointer-events: auto; opacity: 0.9; filter: drop-shadow(0px 0px 1px rgba(0,0,0,0.8)); vector-effect: non-scaling-stroke;" />
            
            <!-- Path connecting card to floor -->
            <path id="connector-line" d="" stroke="white" stroke-width="3" stroke-dasharray="8,6" stroke-linecap="round" stroke-linejoin="round" fill="none" 
                style="filter: drop-shadow(0px 0px 0.5px rgba(0,0,0,0.8)); vector-effect: non-scaling-stroke;" />
            
            <!-- Polygon highlighting the selected floor -->
            <polygon id="floor-highlight" points="" stroke="#FCD34D" stroke-width="3" stroke-dasharray="8,6" stroke-linecap="round" stroke-linejoin="round"
                fill="rgba(255, 255, 255, 0.1)" style="display: none; filter: drop-shadow(0px 0px 1px rgba(0,0,0,0.8)); vector-effect: non-scaling-stroke;" />
        </svg>
    </div>

    <!-- Interactive Card (Fixed Left Half) -->
    <div id="info-card" style="display: none;" 
        class="absolute left-4 top-40 bottom-28 w-[40vw] z-20 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/20 flex flex-col">
        
        <!-- Header -->
        <div class="card-header bg-slate-900 text-white p-6 flex justify-between items-center shrink-0 cursor-move select-none">
            <div>
                <h2 id="card-floor-title" class="text-3xl font-bold font-serif tracking-wide"></h2>
                <p id="card-floor-view" class="text-slate-400 text-base mt-1"></p>
            </div>
            <button onclick="floorBookingCloseCard()" class="text-slate-400 hover:text-white transition p-2 hover:bg-white/10 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col">
            <!-- Carousel Container -->
            <div class="relative group shrink-0">
                <!-- Left Arrow -->
                <button onclick="floorBookingNavigate(-1)" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-slate-800 p-3 rounded-full shadow-lg z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <!-- Carousel Items -->
                <div id="room-carousel" class="flex overflow-x-auto snap-x snap-mandatory h-64 no-scrollbar scroll-smooth">
                    <!-- Dynamic content will be injected here -->
                </div>
    
                <!-- Right Arrow -->
                <button onclick="floorBookingNavigate(1)" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-slate-800 p-3 rounded-full shadow-lg z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
    
            <!-- Room Details -->
            <div class="p-8 space-y-6 flex-1 bg-white">
                <div class="border-b border-slate-100 pb-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 id="room-type" class="text-2xl font-bold text-slate-800"></h3>
                        <div class="text-right">
                            <span id="room-price" class="text-3xl font-bold text-slate-900"></span>
                            <span class="text-sm text-slate-500 block">per night</span>
                        </div>
                    </div>
                    <p id="room-description" class="text-slate-600 leading-relaxed text-lg"></p>
                </div>
                
                <!-- Additional Room Features / Mock Content to fill space -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center text-slate-600">
                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Free Wi-Fi</span>
                    </div>
                    <div class="flex items-center text-slate-600">
                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Air Conditioning</span>
                    </div>
                    <div class="flex items-center text-slate-600">
                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>24/7 Room Service</span>
                    </div>
                    <div class="flex items-center text-slate-600">
                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Premium Amenities</span>
                    </div>
                </div>

                <div class="pt-4">
                    <button class="w-full bg-slate-900 hover:bg-slate-800 text-white py-4 rounded-xl font-medium text-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Check Availability & Book
                    </button>
                    <p class="text-center text-slate-400 text-sm mt-3">No credit card required for inquiry</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Instruction Overlay (More Left of Building Image) -->
    <div id="instruction-text" class="absolute left-1/4 top-1/2 -translate-x-1/2 -translate-y-1/2 z-10 text-center pointer-events-none">
        <div class="bg-black/40 backdrop-blur-md px-8 py-4 rounded-full border border-white/20 shadow-2xl">
            <p class="text-white text-lg font-medium tracking-wide flex items-center gap-2">
                <span class="animate-bounce">👆</span> Select a floor to explore rooms
            </p>
        </div>
    </div>

    <style>
        /* Hide scrollbar for carousel */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }
        
        .fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        #svg-overlay {
            /* Handled in HTML now, but verify */
            pointer-events: none;
        }
        
        /* Ensure polygon hovers work */
        .floor-box {
            transition: all 0.3s ease;
        }
        .floor-box:hover {
            opacity: 1 !important;
            fill: rgba(255, 255, 255, 0.1) !important;
            stroke-width: 1.2px !important;
        }

        #info-card {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>

    <script>
        (function() {
            'use strict';
            
        // --- Configuration ---
        const floors = {!! json_encode(\App\Models\Room::all()->groupBy('floor_id')->map(function($rooms, $floorId) {
            $firstRoom = $rooms->first();
            return [
                'id' => $floorId,
                'name' => $firstRoom->floor_name,
                'view' => $firstRoom->floor_view,
                'originalCoords' => array_map('intval', explode(',', $firstRoom->floor_coords)),
                'rooms' => $rooms->map(function($room) {
                    return [
                        'id' => $room->room_number,
                        'name' => $room->room_name,
                        'price' => $room->price,
                        'image' => asset($room->image_url),
                        'description' => $room->description,
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray()) !!};

        let activeFloor = null;
        let activeRoomIndex = 0;

        // --- DOM Elements ---
        const containerEl = document.getElementById('hotel-container');
        const cardEl = document.getElementById('info-card');
        const instructionEl = document.getElementById('instruction-text');
        
        // SVG Elements
        const svgConnector = document.getElementById('connector-line');
        const svgHighlight = document.getElementById('floor-highlight');
        
        // Card Content Elements
        const cardTitle = document.getElementById('card-floor-title');
        const cardView = document.getElementById('card-floor-view');
        const carouselEl = document.getElementById('room-carousel');
        const roomTypeEl = document.getElementById('room-type');
        const roomDescEl = document.getElementById('room-description');
        const roomPriceEl = document.getElementById('room-price');

        // --- Initialization ---
        function init() {
            window.addEventListener('resize', handleResize);
            window.addEventListener('scroll', handleScroll, { passive: true });
            
            // Render map areas and attach listeners to SVG polygons
            handleResize();

            // Attach listeners to SVG polygons
            attachPolygonListeners();

            // Make card draggable
            makeDraggable(document.getElementById('info-card'));
        }

        function makeDraggable(element) {
            const header = element.querySelector('.card-header');
            const dragTarget = header || element;
            
            if (header) {
                header.style.cursor = 'move';
            }

            let isDragging = false;
            let startX, startY, initialLeft, initialTop;

            dragTarget.addEventListener('mousedown', dragMouseDown);

            function dragMouseDown(e) {
                // Ignore if clicking a button (like the close button)
                if (e.target.closest('button')) return;

                e.preventDefault();
                
                // Lock height before releasing bottom constraint to prevent collapse
                const rect = element.getBoundingClientRect();
                element.style.height = rect.height + 'px';
                element.style.bottom = 'auto'; // Release bottom constraint
                
                // Get mouse start position
                startX = e.clientX;
                startY = e.clientY;
                
                // Get element start position
                initialLeft = element.offsetLeft;
                initialTop = element.offsetTop;
                
                isDragging = true;
                if (header) header.style.cursor = 'grabbing';
                
                document.addEventListener('mousemove', elementDrag);
                document.addEventListener('mouseup', closeDragElement);
            }

            function elementDrag(e) {
                if (!isDragging) return;
                e.preventDefault();
                
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;
                
                element.style.left = (initialLeft + dx) + "px";
                element.style.top = (initialTop + dy) + "px";
            }

            function closeDragElement() {
                isDragging = false;
                if (header) header.style.cursor = 'move';
                document.removeEventListener('mousemove', elementDrag);
                document.removeEventListener('mouseup', closeDragElement);
            }
        }

        function attachPolygonListeners() {
            floors.forEach(floor => {
                const el = document.getElementById(`floor-box-${floor.id}`);
                if (el) {
                    el.addEventListener('click', (e) => {
                        e.stopPropagation(); // Prevent document click handler
                        selectFloor(floor);
                    });
                    
                    // Add hover listeners if needed via JS, though CSS handles visuals
                    el.addEventListener('mouseenter', () => {
                         // Optional: could trigger tooltip
                    });
                }
            });
        }

        // --- Core Logic ---
        function handleResize() {
            renderCoordinates();
            if (activeFloor) {
                drawLines(activeFloor);
            }
        }

        function handleScroll() {
            if (activeFloor) {
                drawLines(activeFloor);
            }
        }

        // Landmark configuration with original image coordinates
        const ORIGINAL_WIDTH = 2166;
        const ORIGINAL_HEIGHT = 1366;

        function scaleCoordinates(coordsArray, scaleX, scaleY, offsetX, offsetY) {
            const scaledCoords = [];

            for (let i = 0; i < coordsArray.length; i += 2) {
                scaledCoords.push((coordsArray[i] * scaleX) + offsetX);
                scaledCoords.push((coordsArray[i + 1] * scaleY) + offsetY);
            }

            return scaledCoords;
        }

        function renderCoordinates() {
            const width = containerEl.clientWidth;
            const height = containerEl.clientHeight;
            
            // Calculate how object-cover scales and positions the image
            // We use the new constant dimensions as the source of truth for the coordinate system
            const imageAspect = ORIGINAL_WIDTH / ORIGINAL_HEIGHT;
            const containerAspect = width / height;

            let scale, offsetX, offsetY;

            if (containerAspect > imageAspect) {
                // Container is wider - image fills width, crops top/bottom
                scale = width / ORIGINAL_WIDTH;
                offsetX = 0;
                offsetY = (height - (ORIGINAL_HEIGHT * scale)) / 2;
            } else {
                // Container is taller - image fills height, crops left/right
                scale = height / ORIGINAL_HEIGHT;
                offsetX = (width - (ORIGINAL_WIDTH * scale)) / 2;
                offsetY = 0;
            }

            floors.forEach(floor => {
                // Scale coordinates using the robust logic
                // Pass scale for both X and Y because object-cover maintains aspect ratio
                const scaledCoords = scaleCoordinates(floor.originalCoords, scale, scale, offsetX, offsetY);
                
                // Update SVG points
                const floorBox = document.getElementById(`floor-box-${floor.id}`);
                if (floorBox) {
                    // SVG uses the same coordinate system as the container (viewBox 0 0 width height in the other file, 
                    // but here the SVG is viewBox="0 0 100 100" preserveAspectRatio="none".
                    // WAIT. The target file has `viewBox="0 0 100 100"`.
                    // The `interactive-map` implementation updates the viewBox to match the container rect:
                    // `svg.setAttribute('viewBox', 0 0 ${containerRect.width} ${containerRect.height});`
                    // I should probably switch this SVG to use pixel coordinates to match the robust logic easier, 
                    // OR convert the robust pixel coords back to percentages for the 100x100 viewBox.
                    
                    // Converting to percentages for 100x100 viewbox:
                    const percentCoords = scaledCoords.map((val, i) => {
                        return (i % 2 === 0) ? (val / width) * 100 : (val / height) * 100;
                    });
                    
                    floorBox.setAttribute('points', percentCoords.join(' '));
                }
            });
        }

        function selectFloor(floor) {
            activeFloor = floor;
            activeRoomIndex = 0;
            
            updateCard(floor);
            cardEl.style.display = 'flex'; // Changed to flex for the column layout
            cardEl.classList.remove('fade-out');
            cardEl.classList.add('fade-in');
            
            if (instructionEl) {
                instructionEl.style.opacity = '0';
            }
            
            drawLines(floor);
        }

        function updateCard(floor) {
            cardTitle.textContent = floor.name;
            cardView.textContent = floor.view;
            
            // Generate Carousel Items
            carouselEl.innerHTML = floor.rooms.map((room, index) => `
                <div class="carousel-item min-w-[40%] h-full relative snap-start cursor-pointer border-r border-white/10" data-index="${index}">
                    <img src="${room.image}" class="w-full h-full object-cover transition hover:opacity-90" alt="${room.name}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-2 left-2 text-white font-bold text-sm pointer-events-none drop-shadow-md">
                        ${room.name}
                    </div>
                </div>
            `).join('');

            updateRoomDetails(0);
        }

        
        function selectRoom(index) {
            // Bounds check
            if (!activeFloor || index < 0 || index >= activeFloor.rooms.length) return;
            
            activeRoomIndex = index;
            updateRoomDetails(index);
            updateCarouselHighlight(index);
            
            const items = carouselEl.children;
            if (items[index]) {
                items[index].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }

        // Add event delegation for carousel items
        carouselEl.addEventListener('click', (e) => {
            const item = e.target.closest('.carousel-item');
            if (item) {
                const index = parseInt(item.dataset.index, 10);
                if (!isNaN(index)) {
                    selectRoom(index);
                }
            }
        });

        function updateRoomDetails(index) {
            if (!activeFloor) return;
            const room = activeFloor.rooms[index];
            if (!room) return;
            
            roomTypeEl.textContent = room.name;
            roomDescEl.textContent = room.description;
            roomPriceEl.textContent = room.price;
        }

        function updateCarouselHighlight(activeIndex) {
            const items = Array.from(carouselEl.children);
            items.forEach((item, index) => {
                if (index === activeIndex) {
                    item.classList.add('ring-4', 'ring-blue-500', 'z-10');
                    item.classList.remove('opacity-50');
                } else {
                    item.classList.remove('ring-4', 'ring-blue-500', 'z-10');
                    // Optional: fade others
                }
            });
        }

        function navigateRoom(direction) {
            if (!activeFloor) return;
            let newIndex = activeRoomIndex + direction;
            
            // Loop navigation or clamp? Let's clamp.
            if (newIndex < 0) newIndex = 0;
            if (newIndex >= activeFloor.rooms.length) newIndex = activeFloor.rooms.length - 1;
            
            selectRoom(newIndex);
        }

        function closeCard() {
            cardEl.style.display = 'none';
            svgConnector.setAttribute('d', '');
            svgHighlight.style.display = 'none';
            activeFloor = null;
            
            if (instructionEl) {
                instructionEl.style.opacity = '1';
            }
        }

        function drawLines(floor) {
            if (!floor) return;

            const width = containerEl.clientWidth;
            const height = containerEl.clientHeight; 
            
            // ... (rest of logic)
            
            // Find coordinates again (would be better to cache, but cheap to recalc)
            // ... (Duping calculation logic for conciseness or accessing updated DOM)
            // Actually, we can just grab the points from the attribute if we trust renderCoordinates ran.
            const floorBox = document.getElementById(`floor-box-${floor.id}`);
            if (!floorBox) return;
            
            const pointsStr = floorBox.getAttribute('points');
            if (!pointsStr) return;
            
            const coords = pointsStr.split(' ').map(Number);
            
            // Calculate Center of Floor
            let sumX = 0, sumY = 0, count = 0;
            for (let i = 0; i < coords.length; i += 2) {
                sumX += coords[i];
                sumY += coords[i + 1];
                count++;
            }
            const centerX = sumX / count;
            const centerY = sumY / count;

            // Highlight
            svgHighlight.setAttribute('points', pointsStr);
            svgHighlight.style.display = 'block';

            // Get Card Position
            const cardRect = cardEl.getBoundingClientRect();
            const imgRect = containerEl.getBoundingClientRect();
            
            // Connection Point on Card (Middle Right?)
            // If card is on left half, we want the connection to come from its Right edge.
            const cardRightX = (cardRect.right - imgRect.left) / width * 100;
            const cardCenterY = ((cardRect.top + cardRect.height / 2) - imgRect.top) / height * 100;

            // START: Card Right Edge
            const sx = cardRightX;
            const sy = cardCenterY;
            
            // END: Floor Center
            const ex = centerX;
            const ey = centerY;
            
            // Control Points for Cubic Bezier to make "Curved Dashed Line"
            // We want it to go out right, then curve to target.
            // C cp1x cp1y, cp2x cp2y, endx endy
            
            // Determine distance
            const dist = Math.abs(ex - sx);
            
            // CP1: Push out to the right from card
            const cp1x = sx + (dist * 0.5); 
            const cp1y = sy;
            
            // CP2: Approach floor from left? or just smooth curve?
            // Let's make it S-shaped horizontalish
            const cp2x = ex - (dist * 0.5);
            const cp2y = ey;
            
            // Alternative: Simply use midpoint x
            const midX = (sx + ex) / 2;
            
            // Use smoother curve
             const d = `M ${sx} ${sy} C ${midX} ${sy}, ${midX} ${ey}, ${ex} ${ey}`;

            svgConnector.setAttribute('d', d);
        }

        // Click outside to close
        document.addEventListener('click', (e) => {
            if (!activeFloor) return;
            
            const clickedBox = e.target.closest('.floor-box');
            if (clickedBox) return; // Handled by box click
            
            const clickedCard = cardEl.contains(e.target);
            
            if (!clickedCard) {
                closeCard();
            }
        });

        // Initialize on load
        init();
        
        // Expose functions
        window.floorBookingCloseCard = closeCard;
        window.floorBookingNavigate = navigateRoom; // Changed from scrollCarousel
        window.floorBookingSelectRoom = selectRoom;
        
        })(); // End of IIFE
    </script>
</section>