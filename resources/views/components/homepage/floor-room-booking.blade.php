<section x-data="{
    selectedFloor: null,
    selectedRoom: null,
    currentImageIndex: 0,
    floors: [
        {
            id: 1,
            name: 'Ground Floor',
            view: 'Garden View',
            image: '{{ asset('images/floors/floor1.jpg') }}',
            rooms: [
                { id: 101, name: 'Room 101', images: ['{{ asset('images/rooms/single.png') }}', '{{ asset('images/rooms/double.jpg') }}'] },
                { id: 102, name: 'Room 102', images: ['{{ asset('images/rooms/family.jpg') }}', '{{ asset('images/rooms/single.png') }}'] },
                { id: 103, name: 'Room 103', images: ['{{ asset('images/rooms/double.jpg') }}', '{{ asset('images/rooms/family.jpg') }}'] },
                { id: 104, name: 'Room 104', images: ['{{ asset('images/rooms/single.png') }}', '{{ asset('images/rooms/double.jpg') }}'] }
            ]
        },
        {
            id: 2,
            name: 'First Floor',
            view: 'Partial Ocean View',
            image: '{{ asset('images/floors/floor2.jpg') }}',
            rooms: [
                { id: 201, name: 'Room 201', images: ['{{ asset('images/rooms/double.jpg') }}', '{{ asset('images/rooms/single.png') }}'] },
                { id: 202, name: 'Room 202', images: ['{{ asset('images/rooms/family.jpg') }}', '{{ asset('images/rooms/double.jpg') }}'] },
                { id: 203, name: 'Room 203', images: ['{{ asset('images/rooms/single.png') }}', '{{ asset('images/rooms/family.jpg') }}'] },
                { id: 204, name: 'Room 204', images: ['{{ asset('images/rooms/double.jpg') }}', '{{ asset('images/rooms/single.png') }}'] }
            ]
        },
        {
            id: 3,
            name: 'Second Floor',
            view: 'Ocean View',
            image: '{{ asset('images/floors/floor3.jpg') }}',
            rooms: [
                { id: 301, name: 'Room 301', images: ['{{ asset('images/rooms/family.jpg') }}', '{{ asset('images/rooms/double.jpg') }}'] },
                { id: 302, name: 'Room 302', images: ['{{ asset('images/rooms/single.png') }}', '{{ asset('images/rooms/family.jpg') }}'] },
                { id: 303, name: 'Room 303', images: ['{{ asset('images/rooms/double.jpg') }}', '{{ asset('images/rooms/single.png') }}'] },
                { id: 304, name: 'Room 304', images: ['{{ asset('images/rooms/family.jpg') }}', '{{ asset('images/rooms/double.jpg') }}'] }
            ]
        },
        {
            id: 4,
            name: 'Top Floor',
            view: 'Panoramic Ocean View',
            image: '{{ asset('images/floors/floor4.jpg') }}',
            rooms: [
                { id: 401, name: 'Room 401', images: ['{{ asset('images/rooms/double.jpg') }}', '{{ asset('images/rooms/family.jpg') }}'] },
                { id: 402, name: 'Room 402', images: ['{{ asset('images/rooms/single.png') }}', '{{ asset('images/rooms/double.jpg') }}'] },
                { id: 403, name: 'Room 403', images: ['{{ asset('images/rooms/family.jpg') }}', '{{ asset('images/rooms/single.png') }}'] },
                { id: 404, name: 'Room 404', images: ['{{ asset('images/rooms/double.jpg') }}', '{{ asset('images/rooms/family.jpg') }}'] }
            ]
        }
    ]
}" class="py-20 bg-gradient-to-b from-[#FAF6F0] to-white">
    <div class="max-w-screen-xl mx-auto px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-['STIX_Two_Text'] text-stone-900 mb-4">
                Select Your Perfect Stay
            </h2>
            <p class="text-stone-600 text-lg max-w-2xl mx-auto">
                Choose your floor to enjoy stunning ocean views, then select your ideal room
            </p>
        </div>

        <!-- Floor Selection -->
        <div class="mb-16">
            <h3 class="text-2xl font-['STIX_Two_Text'] text-stone-800 mb-8 text-center">
                Step 1: Choose Your Floor
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="floor in floors" :key="floor.id">
                    <div @click="selectedFloor = floor.id; selectedRoom = null; currentImageIndex = 0"
                        :class="selectedFloor === floor.id ? 'ring-4 ring-stone-900 scale-105' : 'hover:scale-102'"
                        class="cursor-pointer transition-all duration-300 rounded-2xl overflow-hidden shadow-lg bg-white">
                        <div class="relative h-48 overflow-hidden">
                            <img :src="floor.image" :alt="floor.name"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <h4 class="text-xl font-bold" x-text="floor.name"></h4>
                                <p class="text-sm opacity-90" x-text="floor.view"></p>
                            </div>
                            <div x-show="selectedFloor === floor.id"
                                class="absolute top-4 right-4 bg-white rounded-full p-2">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Room Selection -->
        <div x-show="selectedFloor !== null" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <h3 class="text-2xl font-['STIX_Two_Text'] text-stone-800 mb-8 text-center">
                Step 2: Select Your Room
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="floor in floors.filter(f => f.id === selectedFloor)" :key="floor.id">
                    <template x-for="room in floor.rooms" :key="room.id">
                        <div @click="selectedRoom = room.id; currentImageIndex = 0"
                            :class="selectedRoom === room.id ? 'ring-4 ring-blue-600 scale-105' : 'hover:scale-102'"
                            class="cursor-pointer transition-all duration-300 rounded-2xl overflow-hidden shadow-lg bg-white">
                            <div class="relative h-40 overflow-hidden">
                                <img :src="room.images[0]" :alt="room.name" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                                <div class="absolute bottom-3 left-3 text-white">
                                    <h5 class="text-lg font-semibold" x-text="room.name"></h5>
                                </div>
                                <div x-show="selectedRoom === room.id"
                                    class="absolute top-3 right-3 bg-white rounded-full p-1.5">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </div>

        <!-- Room Image Gallery -->
        <div x-show="selectedRoom !== null" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-16">
            <template x-for="floor in floors.filter(f => f.id === selectedFloor)" :key="floor.id">
                <template x-for="room in floor.rooms.filter(r => r.id === selectedRoom)" :key="room.id">
                    <div class="max-w-4xl mx-auto">
                        <h3 class="text-2xl font-['STIX_Two_Text'] text-stone-800 mb-6 text-center">
                            <span x-text="room.name"></span> Gallery
                        </h3>
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <!-- Main Image -->
                            <div class="relative h-96 bg-stone-100">
                                <template x-for="(image, index) in room.images" :key="index">
                                    <img x-show="currentImageIndex === index" :src="image"
                                        :alt="room.name + ' - Image ' + (index + 1)"
                                        class="w-full h-full object-cover absolute inset-0 transition-opacity duration-500">
                                </template>

                                <!-- Navigation Arrows -->
                                <button
                                    @click="currentImageIndex = (currentImageIndex - 1 + room.images.length) % room.images.length"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded-full p-3 shadow-lg transition-all hover:scale-110">
                                    <svg class="w-6 h-6 text-stone-900" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="currentImageIndex = (currentImageIndex + 1) % room.images.length"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded-full p-3 shadow-lg transition-all hover:scale-110">
                                    <svg class="w-6 h-6 text-stone-900" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                <!-- Image Counter -->
                                <div
                                    class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/60 text-white px-4 py-2 rounded-full text-sm">
                                    <span x-text="currentImageIndex + 1"></span> / <span
                                        x-text="room.images.length"></span>
                                </div>
                            </div>

                            <!-- Thumbnail Strip -->
                            <div class="flex gap-2 p-4 bg-stone-50 overflow-x-auto">
                                <template x-for="(image, index) in room.images" :key="index">
                                    <button @click="currentImageIndex = index"
                                        :class="currentImageIndex === index ? 'ring-2 ring-blue-600' : 'opacity-60 hover:opacity-100'"
                                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden transition-all">
                                        <img :src="image" :alt="'Thumbnail ' + (index + 1)"
                                            class="w-full h-full object-cover">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Book Now Button -->
                        <div class="text-center mt-8">
                            <button
                                class="bg-stone-900 hover:bg-stone-800 text-white px-12 py-4 rounded-full text-lg font-semibold transition-all hover:scale-105 shadow-lg">
                                Book This Room
                            </button>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>
</section>