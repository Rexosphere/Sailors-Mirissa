<!-- Rooms Section -->
<section x-data="{ tab: 'single' }" class=" max-width-2xl">
    <div class="flex justify-center gap-80 border-b border-stone-300 mb-12 bg-[#F5DFC6] py-10">
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
    <div class="max-w-screen-2xl mx-auto px-8">

        <!-- Tabs -->


        <!-- Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- Image -->
            <div>
                <template x-if="tab === 'single'">
                    <img src="{{ asset('/images/rooms/single.avif') }}" alt="Single Room"
                        class="w-full h-[400px] object-cover rounded-3xl shadow-lg">
                </template>
                <template x-if="tab === 'double'">
                    <img src="{{ asset('images/rooms/double.avif') }}" alt="Double Room"
                        class="w-full h-[400px] object-cover rounded-3xl shadow-lg">
                </template>
                <template x-if="tab === 'triple'">
                    <img src="{{ asset('images/rooms/single.avif') }}" alt="Triple Room"
                        class="w-full h-[400px] object-cover rounded-3xl shadow-lg">
                </template>
                <template x-if="tab === 'family'">
                    <img src="{{ asset('images/rooms/family.avif') }}" alt="Family Room"
                        class="w-full h-[400px] object-cover rounded-3xl shadow-lg">
                </template>
            </div>

            <!-- Content -->
            <div class="space-y-6">
                <!-- Single -->
                <template x-if="tab === 'single'">
                    <div>
                        <h2 class="text-3xl font-bold font-serif mb-4">Single Rooms</h2>
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
                        <h2 class="text-3xl font-bold font-serif mb-4">Double Rooms</h2>
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
                        <h2 class="text-3xl font-bold font-serif mb-4">Triple Rooms</h2>
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
                        <h2 class="text-3xl font-bold font-serif mb-4">Family Rooms</h2>
                        <ul class="space-y-2 text-stone-700">
                            <li>👨‍👩‍👧‍👦 6 Guests</li>
                            <li>🛏 2 Double Beds, 2 Single Beds</li>
                        </ul>
                        <p class="mt-4 text-stone-600 leading-relaxed">
                            Spacious and welcoming, our Family Rooms are designed to keep everyone comfortable, with
                            quick access to Mirissa's top attractions.
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