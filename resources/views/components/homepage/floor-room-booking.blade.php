<section x-data="{
    selectedFloor: null,
    selectedRoom: null,
    currentImageIndex: 0,
    selectFloor(floorId) {
        this.selectedFloor = floorId;
        this.selectedRoom = null;
        this.currentImageIndex = 0;
    },
    selectRoom(roomId) {
        this.selectedRoom = roomId;
        this.currentImageIndex = 0;
    },
    floors: [
        {
            id: 5,
            name: 'Top Floor',
            view: 'Panoramic Ocean View',
            image: '{{ asset('book/Images/5.png') }}',
            rooms: [
                { id: 501, name: 'Room 501', images: ['{{ asset('images/rooms/top_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 502, name: 'Room 502', images: ['{{ asset('images/rooms/top_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 503, name: 'Room 503', images: ['{{ asset('images/rooms/top_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 504, name: 'Room 504', images: ['{{ asset('images/rooms/top_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] }
            ]
        },
        {
            id: 4,
            name: 'Fourth Floor',
            view: 'Ocean View',
            image: '{{ asset('book/Images/4.png') }}',
            rooms: [
                { id: 401, name: 'Room 401', images: ['{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 402, name: 'Room 402', images: ['{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 403, name: 'Room 403', images: ['{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 404, name: 'Room 404', images: ['{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/first_floor_1.png') }}'] }
            ]
        },
        {
            id: 3,
            name: 'Third Floor',
            view: 'Partial Ocean View',
            image: '{{ asset('book/Images/3.png') }}',
            rooms: [
                { id: 301, name: 'Room 301', images: ['{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 302, name: 'Room 302', images: ['{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 303, name: 'Room 303', images: ['{{ asset('images/rooms/first_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/first_floor_2.png') }}'] },
                { id: 304, name: 'Room 304', images: ['{{ asset('images/rooms/first_floor_2.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/first_floor_1.png') }}'] }
            ]
        },
        {
            id: 2,
            name: 'Second Floor',
            view: 'Garden View',
            image: '{{ asset('book/Images/2.png') }}',
            rooms: [
                { id: 201, name: 'Room 201', images: ['{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 202, name: 'Room 202', images: ['{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 203, name: 'Room 203', images: ['{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/ground_floor_2.png') }}'] },
                { id: 204, name: 'Room 204', images: ['{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/ground_floor_1.png') }}'] }
            ]
        },
        {
            id: 1,
            name: 'Ground Floor',
            view: 'Garden View',
            image: '{{ asset('book/Images/1.png') }}',
            rooms: [
                { id: 101, name: 'Room 101', images: ['{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}'] },
                { id: 102, name: 'Room 102', images: ['{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/balcony_1.png') }}'] },
                { id: 103, name: 'Room 103', images: ['{{ asset('images/rooms/ground_floor_1.png') }}', '{{ asset('images/rooms/bathroom_1.png') }}', '{{ asset('images/rooms/ground_floor_2.png') }}'] },
                { id: 104, name: 'Room 104', images: ['{{ asset('images/rooms/ground_floor_2.png') }}', '{{ asset('images/rooms/balcony_1.png') }}', '{{ asset('images/rooms/ground_floor_1.png') }}'] }
            ]
        }
    ]
}" class="relative py-20 bg-gradient-to-br from-blue-50 via-white to-amber-50 overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div
            class="absolute top-20 left-10 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl animate-pulse">
        </div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"
            style="animation-delay: 1s;"></div>
    </div>

    <div class="relative max-w-screen-2xl mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-7xl font-['STIX_Two_Text'] text-stone-900 mb-6 leading-tight">
                Find Your <span
                    class="bg-gradient-to-r from-blue-600 to-amber-600 bg-clip-text text-transparent">Perfect
                    Room</span>
            </h2>
            <p class="text-stone-600 text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed">
                Experience paradise with stunning ocean views. Choose your floor, select your sanctuary.
            </p>
        </div>

        <!-- Two Column Layout: Floor Selection (Left) + Room/Gallery (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            <!-- LEFT COLUMN: 3D Building Stack Visualization -->
            <div class="lg:sticky lg:top-24 lg:self-start">
                <div class="text-center mb-8">
                    <h3
                        class="text-3xl md:text-4xl font-['STIX_Two_Text'] text-stone-800 mb-3 flex items-center justify-center gap-3">
                        <span
                            class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full text-2xl font-bold">1</span>
                        Choose Your Floor
                    </h3>
                    <p class="text-stone-500 text-lg">Click on any floor to explore rooms</p>
                </div>

                <!-- 3D Building Container - Exact copy from book/floorSelection.html scaled down -->
                <div class="relative w-full flex items-center justify-center" style="height: 700px; overflow: visible;">
                    <style>
                        .building-wrapper {
                            position: relative;
                            width: 270px;
                            height: 675px;
                        }

                        .building-container {
                            position: relative;
                            width: 600px;
                            height: 1100px;
                            transform: scale(0.45);
                            transform-origin: top center;
                        }

                        .building-container a {
                            position: absolute;
                            display: block;
                            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
                            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
                            transform-origin: center center;
                        }

                        .building-container a:hover {
                            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.2)) drop-shadow(0 0 15px rgba(255, 255, 255, 0.3));
                        }

                        .building-container a.selected {
                            transform: scale(1.2) translateY(-8px);
                            z-index: 10;
                            filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.3)) drop-shadow(0 0 25px rgba(100, 150, 255, 0.4));
                            animation: pulse-glow 2s ease-in-out infinite;
                        }

                        @keyframes pulse-glow {

                            0%,
                            100% {
                                filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.3)) drop-shadow(0 0 25px rgba(100, 150, 255, 0.4));
                            }

                            50% {
                                filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.3)) drop-shadow(0 0 35px rgba(100, 150, 255, 0.6));
                            }
                        }

                        .building-container img {
                            display: block;
                            width: auto;
                            height: auto;
                        }

                        /* Floor positions - 0px gaps between floors */
                        .floor-5 {
                            top: 0;
                            left: 150px;
                            z-index: 5;
                        }

                        .floor-4 {
                            top: 140px;
                            left: 128.5px;
                            z-index: 4;
                        }

                        .floor-3 {
                            top: 280px;
                            left: 101.5px;
                            z-index: 3;
                        }

                        .floor-2 {
                            top: 420px;
                            left: 75px;
                            z-index: 2;
                        }

                        .floor-1 {
                            top: 560px;
                            left: 87px;
                            z-index: 1;
                        }

                        .base {
                            top: 700px;
                            left: -112px;
                            z-index: 0;
                            pointer-events: none;
                        }

                        /* Selected state adjustments */
                        .floor-5.selected {
                            top: -30px;
                            left: 30px;
                        }

                        .floor-4.selected {
                            top: 110px;
                            left: 6px;
                        }

                        .floor-3.selected {
                            top: 250px;
                            left: -30px;
                        }

                        .floor-2.selected {
                            top: 390px;
                            left: -60px;
                        }

                        .floor-1.selected {
                            top: 530px;
                            left: -60px;
                        }
                    </style>

                    <div class="building-wrapper">
                        <div class="building-container">
                            <a @click.prevent="selectFloor(5)" :class="selectedFloor === 5 ? 'selected' : ''"
                                class="floor-5">
                                <img src="{{ asset('book/Images/5.png') }}" alt="Floor 5">
                            </a>
                            <a @click.prevent="selectFloor(4)" :class="selectedFloor === 4 ? 'selected' : ''"
                                class="floor-4">
                                <img src="{{ asset('book/Images/4.png') }}" alt="Floor 4">
                            </a>
                            <a @click.prevent="selectFloor(3)" :class="selectedFloor === 3 ? 'selected' : ''"
                                class="floor-3">
                                <img src="{{ asset('book/Images/3.png') }}" alt="Floor 3">
                            </a>
                            <a @click.prevent="selectFloor(2)" :class="selectedFloor === 2 ? 'selected' : ''"
                                class="floor-2">
                                <img src="{{ asset('book/Images/2.png') }}" alt="Floor 2">
                            </a>
                            <a @click.prevent="selectFloor(1)" :class="selectedFloor === 1 ? 'selected' : ''"
                                class="floor-1">
                                <img src="{{ asset('book/Images/1.png') }}" alt="Floor 1">
                            </a>
                            <a href="#" class="base">
                                <img src="{{ asset('book/Images/Base.png') }}" alt="Base">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Selected Floor Info -->
                <div x-show="selectedFloor !== null" x-transition class="mt-8 text-center">
                    <template x-for="floor in floors.filter(f => f.id === selectedFloor)" :key="floor.id">
                        <div class="bg-white rounded-2xl p-6 shadow-xl max-w-md mx-auto">
                            <h4 class="text-2xl font-bold text-stone-800 mb-2" x-text="floor.name"></h4>
                            <p class="text-stone-600 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span x-text="floor.view"></span>
                            </p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- RIGHT COLUMN: Room Selection & Gallery -->
            <div class="space-y-12">
                <!-- Room Selection -->
                <div x-show="selectedFloor !== null" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-x-8"
                    x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="text-center mb-8">
                        <h3
                            class="text-3xl md:text-4xl font-['STIX_Two_Text'] text-stone-800 mb-3 flex items-center justify-center gap-3">
                            <span
                                class="inline-flex items-center justify-center w-12 h-12 bg-amber-600 text-white rounded-full text-2xl font-bold">2</span>
                            Select Your Room
                        </h3>
                        <p class="text-stone-500 text-lg">Your personal sanctuary awaits</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <template x-for="floor in floors.filter(f => f.id === selectedFloor)" :key="floor.id">
                            <template x-for="room in floor.rooms" :key="room.id">
                                <div @click="selectRoom(room.id)"
                                    :class="selectedRoom === room.id ? 'ring-4 ring-amber-500 scale-105 shadow-2xl' : 'hover:scale-105 hover:shadow-xl'"
                                    class="group cursor-pointer transition-all duration-500 rounded-2xl overflow-hidden bg-white">
                                    <div class="relative h-64 overflow-hidden">
                                        <img :src="room.images[0]" :alt="room.name"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                                        </div>

                                        <div class="absolute bottom-4 left-4 text-white">
                                            <h5 class="text-xl font-bold drop-shadow-lg" x-text="room.name"></h5>
                                            <p class="text-sm opacity-90 mt-1">Tap to explore</p>
                                        </div>

                                        <div x-show="selectedRoom === room.id" x-transition
                                            class="absolute top-4 right-4 bg-white rounded-full p-2.5 shadow-lg">
                                            <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>

                                        <div
                                            class="absolute inset-0 bg-amber-600/0 group-hover:bg-amber-600/10 transition-colors duration-300">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                </div>

                <!-- Room Image Gallery -->
                <div x-show="selectedRoom !== null" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0">
                    <template x-for="floor in floors.filter(f => f.id === selectedFloor)" :key="floor.id">
                        <template x-for="room in floor.rooms.filter(r => r.id === selectedRoom)" :key="room.id">
                            <div>
                                <div class="text-center mb-8">
                                    <h3 class="text-2xl md:text-3xl font-['STIX_Two_Text'] text-stone-800 mb-2">
                                        <span x-text="room.name"></span> Gallery
                                    </h3>
                                    <p class="text-stone-500">Explore every detail of your future stay</p>
                                </div>

                                <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-white p-2">
                                    <!-- Main Image -->
                                    <div class="relative h-[400px] bg-stone-100 rounded-xl overflow-hidden">
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
                                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/95 hover:bg-white rounded-full p-3 shadow-xl transition-all hover:scale-110 group">
                                            <svg class="w-6 h-6 text-stone-900 group-hover:text-blue-600 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button
                                            @click="currentImageIndex = (currentImageIndex + 1) % room.images.length"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/95 hover:bg-white rounded-full p-3 shadow-xl transition-all hover:scale-110 group">
                                            <svg class="w-6 h-6 text-stone-900 group-hover:text-blue-600 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>

                                        <!-- Image Counter -->
                                        <div
                                            class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/70 backdrop-blur-sm text-white px-5 py-2 rounded-full text-sm font-medium">
                                            <span x-text="currentImageIndex + 1"></span> / <span
                                                x-text="room.images.length"></span>
                                        </div>
                                    </div>

                                    <!-- Thumbnail Strip -->
                                    <div class="flex gap-2 p-4 bg-stone-50 overflow-x-auto rounded-b-xl">
                                        <template x-for="(image, index) in room.images" :key="index">
                                            <button @click="currentImageIndex = index"
                                                :class="currentImageIndex === index ? 'ring-3 ring-blue-600 scale-105' : 'opacity-60 hover:opacity-100'"
                                                class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden transition-all shadow-md hover:shadow-lg">
                                                <img :src="image" :alt="'Thumbnail ' + (index + 1)"
                                                    class="w-full h-full object-cover">
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <!-- Book Now Button -->
                                <div class="text-center mt-8">
                                    <button
                                        class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-12 py-5 rounded-full text-lg font-bold transition-all hover:scale-105 shadow-2xl hover:shadow-blue-500/50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Book This Room Now
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </button>
                                    <p class="text-stone-500 mt-3 text-sm">✨ Best rates guaranteed • Free cancellation
                                    </p>
                                </div>
                            </div>
                        </template>
                    </template>
                </div>

                <!-- Placeholder when no floor selected -->
                <div x-show="selectedFloor === null" x-transition class="text-center py-24">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-['STIX_Two_Text'] text-stone-800 mb-3">Select a Floor to Begin</h3>
                    <p class="text-stone-600 max-w-md mx-auto">
                        Click on any floor from the building on the left to view available rooms and start your booking
                        journey.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>