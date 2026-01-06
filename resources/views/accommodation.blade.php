<x-layout>
    <x-slot:title>Accommodation- Saylor's Mirissa</x-slot:title>

    <!-- Hero Section -->
    <section  id="featured_header" class="relative h-[50vh] bg-cover bg-center bg-fixed"
        style="background-image: url('{{ asset('images/home.png') }}');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Content at bottom-left -->
        <div class="absolute bottom-4 left-8 md:bottom-8 md:left-20 z-10 text-neutral-50 max-w-4xl ">
            <h1 class="text-5xl  md:text-6xl font-display leading-tight">
                Accommodation
            </h1>
        </div>
    </section>

    <!-- Rooms Section -->
    <section x-data="{ tab: 'single' }" class=" ">
        <div class="flex justify-center gap-80 border-b border-stone-300 mb-12 bg-[#EEE0CD] py-10">
            <button @click="tab = 'single'"
                :class="tab === 'single' ? 'text-stone-900 font-bold border-b-2 border-stone-900 pb-2' : 'text-stone-500 pb-2'"
                class="uppercase tracking-wide transition">
                Single
            </button>

            <button @click="tab = 'double'"
                :class="tab === 'double' ? 'text-stone-900 font-bold border-b-2 border-stone-900 pb-2' : 'text-stone-500 pb-2'"
                class="uppercase tracking-wide transition">
                Double
            </button>

            <button @click="tab = 'triple'"
                :class="tab === 'triple' ? 'text-stone-900 font-bold border-b-2 border-stone-900 pb-2' : 'text-stone-500 pb-2'"
                class="uppercase tracking-wide transition">
                Triple
            </button>

            <button @click="tab = 'family'"
                :class="tab === 'family' ? 'text-stone-900 font-bold border-b-2 border-stone-900 pb-2' : 'text-stone-500 pb-2'"
                class="uppercase tracking-wide transition">
                Family
            </button>
        </div>
        </div>
        <div class="max-w-screen-xl mx-auto px-8">

            <!-- Tabs -->


            <!-- Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <!-- Image -->
                <div>
                    <template x-if="tab === 'single'">
                        <img src="{{ asset('/images/rooms/single.png') }}" alt="Single Room"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-lg">
                    </template>
                    <template x-if="tab === 'double'">
                        <img src="{{ asset('images/rooms/double.jpg') }}" alt="Double Room"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-lg">
                    </template>
                    <template x-if="tab === 'triple'">
                        <img src="{{ asset('images/rooms/single.png') }}" alt="Triple Room"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-lg">
                    </template>
                    <template x-if="tab === 'family'">
                        <img src="{{ asset('images/rooms/family.jpg') }}" alt="Family Room"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-lg">
                    </template>
                </div>

                <!-- Content -->
                <div class="space-y-6">
                    <!-- Single -->
                    <template x-if="tab === 'single'">
                        <div>
                            <h2 class="text-3xl font-bold font-display mb-4">Single Rooms</h2>
                            <ul class="space-y-2 text-stone-700">
                                <li>👤 3 Guests</li>
                                <li>🛏 2 Beds - 1 Double, 1 Single</li>
                            </ul>
                            <p class="mt-4 text-stone-600 leading-relaxed">
                                Sailors Mirissa sits in the heart of town where everything cool happens – just a
                                2-minute walk to the beach, practically next door to Coconut Tree Hill, surrounded by
                                great restaurants, surf spots, and the whale watching harbor.
                            </p>
                            <div class="mt-6">
                                <a href="#" class="uppercase text-stone-700">Book Now</a>
                                <div class="w-24 h-px bg-stone-300 mt-1"></div>
                            </div>
                        </div>
                    </template>

                    <!-- Double -->
                    <template x-if="tab === 'double'">
                        <div>
                            <h2 class="text-3xl font-bold font-display mb-4">Double Rooms</h2>
                            <ul class="space-y-2 text-stone-700">
                                <li>👥 4 Guests</li>
                                <li>🛏 2 Double Beds</li>
                            </ul>
                            <p class="mt-4 text-stone-600 leading-relaxed">
                                Perfect for couples or friends traveling together, our Double Rooms combine comfort with
                                convenience, just steps from Mirissa beach.
                            </p>
                            <div class="mt-6">
                                <a href="#" class="uppercase text-stone-700">Book Now</a>
                                <div class="w-24 h-px bg-stone-300 mt-1"></div>
                            </div>
                        </div>
                    </template>

                    <!-- Triple -->
                    <template x-if="tab === 'triple'">
                        <div>
                            <h2 class="text-3xl font-bold font-display mb-4">Triple Rooms</h2>
                            <ul class="space-y-2 text-stone-700">
                                <li>👥 5 Guests</li>
                                <li>🛏 1 Double Bed, 2 Single Beds</li>
                            </ul>
                            <p class="mt-4 text-stone-600 leading-relaxed">
                                Ideal for small groups, our Triple Rooms offer extra space and comfort, with all modern
                                amenities close to the beach and local spots.
                            </p>
                            <div class="mt-6">
                                <a href="#" class="uppercase text-stone-700">Book Now</a>
                                <div class="w-24 h-px bg-stone-300 mt-1"></div>
                            </div>
                        </div>
                    </template>

                    <!-- Family -->
                    <template x-if="tab === 'family'">
                        <div>
                            <h2 class="text-3xl font-bold font-display mb-4">Family Rooms</h2>
                            <ul class="space-y-2 text-stone-700">
                                <li>👨‍👩‍👧‍👦 6 Guests</li>
                                <li>🛏 2 Double Beds, 2 Single Beds</li>
                            </ul>
                            <p class="mt-4 text-stone-600 leading-relaxed">
                                Spacious and welcoming, our Family Rooms are designed to keep everyone comfortable, with
                                quick access to Mirissa’s top attractions.
                            </p>
                            <div class="mt-6">
                                <a href="#" class="uppercase text-stone-700">Book Now</a>
                                <div class="w-24 h-px bg-stone-300 mt-1"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#FAF6F0] py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-display text-gray-800 mb-10">
                Gallery
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHwyfHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="Luxury hotel room interior with a large bed, a sitting area, and a large window."
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHwyfHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="A modern hotel room with a minimalist design, a comfortable bed, and clean lines."
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHwyfHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="A stylish hotel room featuring a large bed, a wooden headboard, and warm lighting."
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHw3fHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="An elegant hotel bedroom with a large window, providing a scenic view."
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHw3fHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="A clean and cozy hotel room with a comfortable bed and minimalistic decor."
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHw3fHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="A simple and comfortable hotel room with a large bed and a small desk."
                        class="w-full h-auto object-cover" />
                </div>
            </div>
        </div>
    </section>
</x-layout>
