<section x-data="{
    selectedFloor: null,
    selectedRoom: null,
    currentImageIndex: 0,
    selectFloor(floorId) {
        this.selectedFloor = floorId;
        this.selectedRoom = null;
        this.currentImageIndex = 0;
        // Smooth scroll to room selection after a brief delay
        setTimeout(() => {
            const element = document.getElementById('room-selection-section');
            if (element) {
                const offset = 80; // Offset from top for better visual positioning
                const elementPosition = element.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        }, 300);
    },
    selectRoom(roomId) {
        this.selectedRoom = roomId;
        this.currentImageIndex = 0;
        // Wait for Alpine to update DOM, then scroll as transition begins
        this.$nextTick(() => {
            requestAnimationFrame(() => {
                const element = document.getElementById('gallery-section');
                if (element) {
                    const offset = 120; // Offset from top for better visual positioning
                    const elementPosition = element.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - offset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    },
    floors: [
        {
            id: 1,
            name: 'Ground Floor',
            view: 'Garden View',
            image: '{{ asset('images/floors/floor1.jpg') }}',
            rooms: [
                { id: 101, name: 'Room 101', images: ['{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 102, name: 'Room 102', images: ['{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 103, name: 'Room 103', images: ['{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/ground_floor_2.png') }}'] },
                { id: 104, name: 'Room 104', images: ['{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/ground_floor_1.png') }}'] }
            ]
        },
        {
            id: 2,
            name: 'First Floor',
            view: 'Partial Ocean View',
            image: '{{ asset('images/floors/floor2.jpg') }}',
            rooms: [
                { id: 201, name: 'Room 201', images: ['{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 202, name: 'Room 202', images: ['{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 203, name: 'Room 203', images: ['{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/first_floor_2.png') }}'] },
                { id: 204, name: 'Room 204', images: ['{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/first_floor_1.png') }}'] }
            ]
        },
        {
            id: 3,
            name: 'Second Floor',
            view: 'Ocean View',
            image: '{{ asset('images/floors/floor3.jpg') }}',
            rooms: [
                { id: 301, name: 'Room 301', images: ['{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 302, name: 'Room 302', images: ['{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 303, name: 'Room 303', images: ['{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 304, name: 'Room 304', images: ['{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/first_floor_1.png') }}'] }
            ]
        },
        {
            id: 4,
            name: 'Top Floor',
            view: 'Panoramic Ocean View',
            image: '{{ asset('images/floors/floor4.jpg') }}',
            rooms: [
                { id: 401, name: 'Room 401', images: ['{{ asset('images/rooms/top_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 402, name: 'Room 402', images: ['{{ asset('images/rooms/top_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 403, name: 'Room 403', images: ['{{ asset('images/rooms/top_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 404, name: 'Room 404', images: ['{{ asset('images/rooms/top_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] }
            ]
        }
    ]
}" class="relative py-32 bg-gradient-to-br from-blue-50 via-white to-amber-50 overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="relative max-w-screen-2xl mx-auto px-6 lg:px-12">
        <!-- Section Header - MUCH BIGGER -->
        <div class="text-center mb-20">
        
            <h2 class="text-5xl md:text-7xl font-['STIX_Two_Text'] text-stone-900 mb-6 leading-tight">
                Find Your <span class="bg-gradient-to-r from-blue-600 to-amber-600 bg-clip-text text-transparent">Perfect Room</span>
            </h2>
            <p class="text-stone-600 text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed">
                Experience paradise with stunning ocean views. Choose your floor, select your sanctuary.
            </p>
        </div>

        <!-- Floor Selection - HERO SIZE -->
        <div class="mb-24">
            <div class="text-center mb-12">
                <h3 class="text-3xl md:text-4xl font-['STIX_Two_Text'] text-stone-800 mb-3 flex items-center justify-center gap-3">
                    <span class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full text-2xl font-bold">1</span>
                    Choose Your Floor
                </h3>
                <p class="text-stone-500 text-lg">Select the view that speaks to your soul</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <template x-for="floor in floors" :key="floor.id">
                    <div @click="selectFloor(floor.id)"
                        :class="selectedFloor === floor.id ? 'ring-4 ring-blue-600 scale-105 shadow-2xl' : 'hover:scale-105 hover:shadow-xl'"
                        class="group cursor-pointer transition-all duration-500 rounded-3xl overflow-hidden bg-white">
                        <div class="relative h-80 overflow-hidden">
                            <img :src="floor.image" :alt="floor.name"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            
                            <!-- Floor Info -->
                            <div class="absolute bottom-6 left-6 right-6 text-white">
                                <h4 class="text-2xl font-bold mb-2 drop-shadow-lg" x-text="floor.name"></h4>
                                <p class="text-base opacity-90 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="floor.view"></span>
                                </p>
                            </div>
                            
                            <!-- Selection Badge -->
                            <div x-show="selectedFloor === floor.id"
                                x-transition
                                class="absolute top-6 right-6 bg-white rounded-full p-3 shadow-lg">
                                <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-blue-600/0 group-hover:bg-blue-600/10 transition-colors duration-300"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Room Selection - LARGER CARDS -->
        <div id="room-selection-section" x-show="selectedFloor !== null" 
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="mb-24">
            <div class="text-center mb-12">
                <h3 class="text-3xl md:text-4xl font-['STIX_Two_Text'] text-stone-800 mb-3 flex items-center justify-center gap-3">
                    <span class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full text-2xl font-bold">2</span>
                    Select Your Room
                </h3>
                <p class="text-stone-500 text-lg">Your personal sanctuary awaits</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <template x-for="floor in floors.filter(f => f.id === selectedFloor)" :key="floor.id">
                    <template x-for="room in floor.rooms" :key="room.id">
                        <div @click="selectRoom(room.id)"
                            :class="selectedRoom === room.id ? 'ring-4 ring-amber-500 scale-105 shadow-2xl' : 'hover:scale-105 hover:shadow-xl'"
                            class="group cursor-pointer transition-all duration-500 rounded-3xl overflow-hidden bg-white">
                            <div class="relative h-64 overflow-hidden">
                                <img :src="room.images[0]" :alt="room.name" 
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                                
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h5 class="text-xl font-bold drop-shadow-lg" x-text="room.name"></h5>
                                    <p class="text-sm opacity-90 mt-1">Tap to explore</p>
                                </div>
                                
                                <div x-show="selectedRoom === room.id"
                                    x-transition
                                    class="absolute top-4 right-4 bg-white rounded-full p-2.5 shadow-lg">
                                    <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <div class="absolute inset-0 bg-amber-600/0 group-hover:bg-amber-600/10 transition-colors duration-300"></div>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </div>

        <!-- Room Image Gallery - PREMIUM PRESENTATION -->
        <div id="gallery-section" x-show="selectedRoom !== null" 
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <template x-for="floor in floors.filter(f => f.id === selectedFloor)" :key="floor.id">
                <template x-for="room in floor.rooms.filter(r => r.id === selectedRoom)" :key="room.id">
                    <div class="max-w-6xl mx-auto">
                        <div class="text-center mb-12">
                            <h3 class="text-3xl md:text-4xl font-['STIX_Two_Text'] text-stone-800 mb-3">
                                <span x-text="room.name"></span> Gallery
                            </h3>
                            <p class="text-stone-500 text-lg">Explore every detail of your future stay</p>
                        </div>
                        
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-white p-2">
                            <!-- Main Image -->
                            <div class="relative h-[500px] bg-stone-100 rounded-2xl overflow-hidden">
                                <template x-for="(image, index) in room.images" :key="index">
                                    <img x-show="currentImageIndex === index" :src="image"
                                        :alt="room.name + ' - Image ' + (index + 1)"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        class="w-full h-full object-cover absolute inset-0">
                                </template>

                                <!-- Navigation Arrows -->
                                <button
                                    @click="currentImageIndex = (currentImageIndex - 1 + room.images.length) % room.images.length"
                                    class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/95 hover:bg-white rounded-full p-4 shadow-xl transition-all hover:scale-110 group">
                                    <svg class="w-7 h-7 text-stone-900 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="currentImageIndex = (currentImageIndex + 1) % room.images.length"
                                    class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/95 hover:bg-white rounded-full p-4 shadow-xl transition-all hover:scale-110 group">
                                    <svg class="w-7 h-7 text-stone-900 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                <!-- Image Counter -->
                                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-black/70 backdrop-blur-sm text-white px-6 py-3 rounded-full text-base font-medium">
                                    <span x-text="currentImageIndex + 1"></span> / <span x-text="room.images.length"></span>
                                </div>
                            </div>

                            <!-- Thumbnail Strip -->
                            <div class="flex gap-3 p-6 bg-stone-50 overflow-x-auto rounded-b-2xl">
                                <template x-for="(image, index) in room.images" :key="index">
                                    <button @click="currentImageIndex = index"
                                        :class="currentImageIndex === index ? 'ring-4 ring-blue-600 scale-105' : 'opacity-60 hover:opacity-100'"
                                        class="flex-shrink-0 w-28 h-28 rounded-xl overflow-hidden transition-all shadow-md hover:shadow-lg">
                                        <img :src="image" :alt="'Thumbnail ' + (index + 1)"
                                            class="w-full h-full object-cover">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Book Now Button - PROMINENT CTA -->
                        <div class="text-center mt-12">
                            <button class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-16 py-6 rounded-full text-xl font-bold transition-all hover:scale-105 shadow-2xl hover:shadow-blue-500/50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Book This Room Now
                                <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                            <p class="text-stone-500 mt-4 text-sm">✨ Best rates guaranteed • Free cancellation</p>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>
</section>