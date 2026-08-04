<x-layout>
    <x-slot:pageKey>accommodation</x-slot:pageKey>
    <x-slot:title>Accommodation- Saylor's Mirissa</x-slot:title>

    <!-- Hero Section -->
    <section  id="featured_header" class="relative h-[50vh] bg-cover bg-center"
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
    <section x-data="{ tab: 'single', tabs: ['single', 'double', 'triple', 'family'] }" class="">
        <div class="border-b border-stone-300 mb-12 bg-sand py-6">
            <div role="tablist" aria-label="Room types"
                @keydown.right.prevent="tab = tabs[(tabs.indexOf(tab) + 1) % tabs.length]; $refs[tab].focus()"
                @keydown.left.prevent="tab = tabs[(tabs.indexOf(tab) - 1 + tabs.length) % tabs.length]; $refs[tab].focus()"
                class="flex justify-center gap-2 sm:gap-8 md:gap-16 lg:gap-32 px-4 overflow-x-auto">
                @foreach (['single' => 'Single', 'double' => 'Double', 'triple' => 'Triple', 'family' => 'Family'] as $key => $label)
                    <button type="button" role="tab" x-ref="{{ $key }}" @click="tab = '{{ $key }}'"
                        :aria-selected="tab === '{{ $key }}' ? 'true' : 'false'"
                        :tabindex="tab === '{{ $key }}' ? 0 : -1"
                        :class="tab === '{{ $key }}'
                            ? 'text-stone-900 font-bold border-b-2 border-stone-900'
                            : 'text-stone-700 border-b-2 border-transparent'"
                        class="uppercase tracking-wide transition min-h-11 px-3 cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
        <div class="max-w-screen-xl mx-auto px-8">

            <!-- Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <!-- Image -->
                <div>
                    <template x-if="tab === 'single'">
                        <img src="{{ asset('/images/rooms/single.png') }}" alt="Single Room"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-lg" loading="lazy" decoding="async">
                    </template>
                    <template x-if="tab === 'double'">
                        <img src="{{ asset('images/rooms/double.jpg') }}" alt="Double Room"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-lg" loading="lazy" decoding="async">
                    </template>
                    <template x-if="tab === 'triple'">
                        <img src="{{ asset('images/rooms/single.png') }}" alt="Triple Room"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-lg" loading="lazy" decoding="async">
                    </template>
                    <template x-if="tab === 'family'">
                        <img src="{{ asset('images/rooms/family.jpg') }}" alt="Family Room"
                            class="w-full h-[400px] object-cover rounded-3xl shadow-lg" loading="lazy" decoding="async">
                    </template>
                </div>

                <!-- Content -->
                <div class="space-y-6">
                    <!-- Single -->
                    <template x-if="tab === 'single'">
                        <div>
                            <h2 class="text-3xl font-bold font-display mb-4">Single Rooms</h2>
                            <ul class="space-y-2 text-stone-700">
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 shrink-0 text-stone-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg><span>3 Guests</span></li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 shrink-0 text-stone-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2 17v-5a2 2 0 0 1 2-2h11a3 3 0 0 1 3 3v4M2 17h20M2 17v3m20-3v3M6 10V8a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v2" /></svg><span>2 Beds - 1 Double, 1 Single</span></li>
                            </ul>
                            <p class="mt-4 text-stone-600 leading-relaxed">
                                Sailors Mirissa sits in the heart of town where everything cool happens – just a
                                2-minute walk to the beach, practically next door to Coconut Tree Hill, surrounded by
                                great restaurants, surf spots, and the whale watching harbor.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('home') }}#floor-booking"
                                   class="uppercase text-stone-700 hover:text-stone-900 inline-flex items-center min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900">Book Now</a>
                                <div class="w-24 h-px bg-stone-300 mt-1"></div>
                            </div>
                        </div>
                    </template>

                    <!-- Double -->
                    <template x-if="tab === 'double'">
                        <div>
                            <h2 class="text-3xl font-bold font-display mb-4">Double Rooms</h2>
                            <ul class="space-y-2 text-stone-700">
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 shrink-0 text-stone-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg><span>4 Guests</span></li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 shrink-0 text-stone-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2 17v-5a2 2 0 0 1 2-2h11a3 3 0 0 1 3 3v4M2 17h20M2 17v3m20-3v3M6 10V8a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v2" /></svg><span>2 Double Beds</span></li>
                            </ul>
                            <p class="mt-4 text-stone-600 leading-relaxed">
                                Perfect for couples or friends traveling together, our Double Rooms combine comfort with
                                convenience, just steps from Mirissa beach.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('home') }}#floor-booking"
                                   class="uppercase text-stone-700 hover:text-stone-900 inline-flex items-center min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900">Book Now</a>
                                <div class="w-24 h-px bg-stone-300 mt-1"></div>
                            </div>
                        </div>
                    </template>

                    <!-- Triple -->
                    <template x-if="tab === 'triple'">
                        <div>
                            <h2 class="text-3xl font-bold font-display mb-4">Triple Rooms</h2>
                            <ul class="space-y-2 text-stone-700">
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 shrink-0 text-stone-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg><span>5 Guests</span></li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 shrink-0 text-stone-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2 17v-5a2 2 0 0 1 2-2h11a3 3 0 0 1 3 3v4M2 17h20M2 17v3m20-3v3M6 10V8a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v2" /></svg><span>1 Double Bed, 2 Single Beds</span></li>
                            </ul>
                            <p class="mt-4 text-stone-600 leading-relaxed">
                                Ideal for small groups, our Triple Rooms offer extra space and comfort, with all modern
                                amenities close to the beach and local spots.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('home') }}#floor-booking"
                                   class="uppercase text-stone-700 hover:text-stone-900 inline-flex items-center min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900">Book Now</a>
                                <div class="w-24 h-px bg-stone-300 mt-1"></div>
                            </div>
                        </div>
                    </template>

                    <!-- Family -->
                    <template x-if="tab === 'family'">
                        <div>
                            <h2 class="text-3xl font-bold font-display mb-4">Family Rooms</h2>
                            <ul class="space-y-2 text-stone-700">
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 shrink-0 text-stone-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg><span>6 Guests</span></li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 shrink-0 text-stone-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2 17v-5a2 2 0 0 1 2-2h11a3 3 0 0 1 3 3v4M2 17h20M2 17v3m20-3v3M6 10V8a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v2" /></svg><span>2 Double Beds, 2 Single Beds</span></li>
                            </ul>
                            <p class="mt-4 text-stone-600 leading-relaxed">
                                Spacious and welcoming, our Family Rooms are designed to keep everyone comfortable, with
                                quick access to Mirissa’s top attractions.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('home') }}#floor-booking"
                                   class="uppercase text-stone-700 hover:text-stone-900 inline-flex items-center min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900">Book Now</a>
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
                        loading="lazy"
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHwyfHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="A modern hotel room with a minimalist design, a comfortable bed, and clean lines."
                        loading="lazy"
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHwyfHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="A stylish hotel room featuring a large bed, a wooden headboard, and warm lighting."
                        loading="lazy"
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHw3fHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="An elegant hotel bedroom with a large window, providing a scenic view."
                        loading="lazy"
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHw3fHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="A clean and cozy hotel room with a comfortable bed and minimalistic decor."
                        loading="lazy"
                        class="w-full h-auto object-cover" />
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQwMjJ8MHwxfHNlYXJjaHw3fHxob3RlbCUyMHJvb20lMjBpbnRlcmlvcnxlbnwwfHx8fDE2OTU3NjMxMzh8MA&ixlib=rb-4.0.3&q=80&w=1080"
                        alt="A simple and comfortable hotel room with a large bed and a small desk."
                        loading="lazy"
                        class="w-full h-auto object-cover" />
                </div>
            </div>
        </div>
    </section>
</x-layout>
