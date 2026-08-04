<?php
$heading = $item['heading'];
$description = $item['description'];
?>

<x-layout>
    <x-slot:title>Location - Saylor's Mirissa</x-slot:title>

    <section class="py-16 mt-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <!-- Heading -->
            <h2 class="text-3xl md:text-4xl font-display text-gray-800 mb-10">
                {{ $heading }}
            </h2>

            <!-- Description -->
            <p class="text-gray-600 text-base md:text-lg leading-relaxed ">
                {{ $description }}
            </p>
        </div>
    </section>

    <!-- Photo Gallery Section -->
    <section class="relative overflow-hidden min-h-dvh" 
             x-data="photoGallery()" 
             x-init="init()">

        <!-- Main Gallery Container -->
        <div class="relative w-full px-2 py-4 md:w-[90vw] md:mx-auto md:px-4 md:py-8">
            <div class="relative h-[30vh] md:h-[600px] flex items-center justify-center w-full">
                
                <!-- Photo Container -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <template x-for="(photo, index) in infinitePhotos" :key="`${photo.id}-${index}`">
                        <div x-show="Math.abs(index - currentIndex) <= 3"
                             class="absolute transition-all duration-500 ease-out"
                             :style="`
                                transform: translateX(${(index - currentIndex) * 30}rem) 
                                          scale(${index === currentIndex ? 1 : 0.8 - Math.abs(index - currentIndex) * 0.1}) 
                                          rotateY(${(index - currentIndex) * 15}deg);
                                z-index: ${index === currentIndex ? 10 : 5 - Math.abs(index - currentIndex)};
                                opacity: ${Math.abs(index - currentIndex) > 1 ? 0 : (index === currentIndex ? 1 : 0.8 - Math.abs(index - currentIndex) * 0.1)};
                             `">
                            
                            <div class="relative w-auto h-60 md:w-auto md:h-[40rem] bg-white/10 backdrop-blur-sm rounded-3xl overflow-hidden border border-white/20 shadow-2xl group">
                                <img :src="photo.src" 
                                     :alt="photo.alt" 
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 aspect-video" loading="lazy" decoding="async">
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <script>
        function photoGallery() {
            return {
                photos: [
                    {
                        id: '1',
                        src: 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                        alt: 'Scuba Diving',
                        title: 'Underwater Adventure',
                        description: 'Exploring the depths of the ocean'
                    },
                    {
                        id: '2',
                        src: 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                        alt: 'Whale Watching',
                        title: 'Whale Encounter',
                        description: 'Majestic whales in their natural habitat'
                    },
                    {
                        id: '3',
                        src: 'https://images.unsplash.com/photo-1583212292454-1fe6229603b7?w=800',
                        alt: 'Coral Reef',
                        title: 'Vibrant Coral Reef',
                        description: 'Colorful marine life underwater'
                    },
                    {
                        id: '4',
                        src: 'https://images.unsplash.com/photo-1582967788606-a171c1080cb0?w=800',
                        alt: 'Ocean View',
                        title: 'Crystal Clear Waters',
                        description: 'Perfect visibility for diving'
                    },
                    {
                        id: '5',
                        src: 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                        alt: 'Marine Life',
                        title: 'Diverse Marine Life',
                        description: 'Rich biodiversity underwater'
                    }
                ],
                currentIndex: 0,
                infinitePhotos: [],
                autoPlayInterval: null,

                init() {
                    // Create infinite array by repeating photos multiple times
                    this.infinitePhotos = [
                        ...this.photos, 
                        ...this.photos, 
                        ...this.photos, 
                        ...this.photos, 
                        ...this.photos
                    ];
                    this.currentIndex = this.photos.length; // Start from center
                    this.startAutoPlay();
                },

                startAutoPlay() {
                    if (this.autoPlayInterval) {
                        clearInterval(this.autoPlayInterval);
                    }
                    
                    this.autoPlayInterval = setInterval(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.infinitePhotos.length;
                    }, 3000);
                },
            }
        }
    </script>

</x-layout>
