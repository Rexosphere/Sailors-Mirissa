<section class="hidden md:block">
    <!-- Image Slider -->
    <div class="order-2 lg:order-1">
        <div class="bg-black shadow-xl overflow-hidden h-dvh w-full relative">
            <!-- Slider Container -->
            <div id="imageSlider" class="w-full h-dvh relative overflow-hidden">
                <!-- Images -->
                <div class="slider-images w-full h-dvh relative">
                    <img src="/images/matara.avif" alt="Matara"
                        class="slider-image absolute inset-0 w-full h-full object-cover object-center opacity-0 transition-opacity duration-500"
                        data-index="0" loading="lazy" decoding="async">
                    <img src="/images/road.avif" alt="Road"
                        class="slider-image absolute inset-0 w-full h-full object-cover object-center opacity-100 transition-opacity duration-500"
                        data-index="1" loading="lazy" decoding="async">
                    <img src="/images/galle.avif" alt="Galle"
                        class="slider-image absolute inset-0 w-full h-full object-cover object-center opacity-0 transition-opacity duration-500"
                        data-index="2" loading="lazy" decoding="async">
                </div>

                <!-- Left Arrow -->
                <button id="prevBtn" type="button" aria-label="Previous photo"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full border-2 border-white/70 bg-black/50 flex items-center justify-center text-white hover:bg-white hover:text-black transition-all duration-300 z-20 cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Right Arrow -->
                <button id="nextBtn" type="button" aria-label="Next photo"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full border-2 border-white/70 bg-black/50 flex items-center justify-center text-white hover:bg-white hover:text-black transition-all duration-300 z-20 cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Dot Indicators: 12px visual, 44px hit area via padding -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center z-10" role="tablist"
                    aria-label="Choose photo">
                    @foreach (['Matara', 'Road', 'Galle'] as $i => $label)
                        <button type="button" role="tab" data-index="{{ $i }}"
                            aria-label="{{ $label }}"
                            aria-selected="{{ $i === 1 ? 'true' : 'false' }}"
                            class="slider-dot w-11 h-11 flex items-center justify-center cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                            <span aria-hidden="true"
                                class="slider-dot-mark block w-3 h-3 rounded-full border-2 border-gray-300 transition-all duration-300 {{ $i === 1 ? 'bg-gray-300' : 'bg-transparent' }}"></span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const images = document.querySelectorAll('.slider-image');
        const dots = document.querySelectorAll('.slider-dot');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 1; // Start with road.avif (middle image)
        const totalImages = images.length;

        function showImage(index) {
            // Update images
            images.forEach((img, i) => {
                img.style.opacity = i === index ? '1' : '0';
            });

            // Update dots
            dots.forEach((dot, i) => {
                const active = i === index;
                dot.setAttribute('aria-selected', String(active));
                const mark = dot.querySelector('.slider-dot-mark');
                if (mark) {
                    mark.style.backgroundColor = active ? 'rgb(209, 213, 219)' : 'transparent';
                }
            });

            currentIndex = index;
        }

        function nextImage() {
            const newIndex = (currentIndex + 1) % totalImages;
            showImage(newIndex);
        }

        function prevImage() {
            const newIndex = (currentIndex - 1 + totalImages) % totalImages;
            showImage(newIndex);
        }

        // Event listeners
        nextBtn.addEventListener('click', nextImage);
        prevBtn.addEventListener('click', prevImage);

        // Dot click handlers
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showImage(index));
        });
    });
</script>