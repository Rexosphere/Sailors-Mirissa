<!-- Image Slider -->
<div class="order-2 lg:order-1">
    <div class="bg-black shadow-xl overflow-hidden h-screen w-screen relative">
        <!-- Slider Container -->
        <div id="imageSlider" class="w-screen h-screen relative overflow-hidden">
            <!-- Images -->
            <div class="slider-images w-screen h-screen relative">
                <img src="/images/matara.avif" alt="Matara" class="slider-image absolute inset-0 w-full h-full object-cover object-center opacity-0 transition-opacity duration-500" data-index="0">
                <img src="/images/road.avif" alt="Road" class="slider-image absolute inset-0 w-full h-full object-cover object-center opacity-100 transition-opacity duration-500" data-index="1">
                <img src="/images/galle.avif" alt="Galle" class="slider-image absolute inset-0 w-full h-full object-cover object-center opacity-0 transition-opacity duration-500" data-index="2">
            </div>

            <!-- Left Arrow -->
            <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full border-2 border-white/70 bg-black/50 flex items-center justify-center text-white hover:bg-white hover:text-black transition-all duration-300 z-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Arrow -->
            <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full border-2 border-white/70 bg-black/50 flex items-center justify-center text-white hover:bg-white hover:text-black transition-all duration-300 z-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Dot Indicators -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-3 z-10">
                <button class="slider-dot w-3 h-3 rounded-full border-2 border-gray-500 bg-transparent transition-all duration-300" data-index="0"></button>
                <button class="slider-dot w-3 h-3 rounded-full border-2 border-gray-500 bg-gray-500 transition-all duration-300" data-index="1"></button>
                <button class="slider-dot w-3 h-3 rounded-full border-2 border-gray-500 bg-transparent transition-all duration-300" data-index="2"></button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.slider-image');
        const dots = document.querySelectorAll('.slider-dot');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 1; // Start with road.avif (middle image)
        const totalImages = images.length;

        function showImage(index) {
            // Update images
            images.forEach((img, i) => {
                if (i === index) {
                    img.style.opacity = '1';
                } else {
                    img.style.opacity = '0';
                }
            });

            // Update dots
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.style.backgroundColor = 'rgb(107, 114, 128)'; // gray-500
                } else {
                    dot.style.backgroundColor = 'transparent';
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
