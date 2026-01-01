<!-- Map Section -->
<section class="py-30 bg-[#FAF6F0]" id= "location">
    <div class="max-w-screen-2xl mx-auto  border-2">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Map -->
            <div class="order-2 lg:order-1">
                <div class="bg-white shadow-xl overflow-hidden h-[60vh]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19999.073408649932!2d80.45743735909214!3d5.950709541236227!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae13fd2d1f6d6a9%3A0x456f17ab9ad29fa1!2sSailors%20Mirissa!5e0!3m2!1sen!2slk!4v1759254691896!5m2!1sen!2slk" class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- Content -->
            <div class="order-1 lg:order-2 space-y-8 ">
                <h2 class="text-4xl lg:text-5xl font-['STIX_Two_Text'] text-stone-700 leading-tight">
                    In the Heart of It All
                </h2>
                <p class="text-lg lg:text-xl text-stone-700 leading-relaxed mr-5">
                    Sailors Mirissa sits in the heart of town where everything cool happens - just a 2-minute walk
                    to the beach, practically next door to Coconut Tree Hill, surrounded by great restaurants, surf
                    spots, and the whale watching harbor. Also right on the main road for easy tuk-tuk rides to
                    Galle and other adventures. </p>
                <div class="pt-4">
                    <a href="#" class="text-stone-700 tracking-wide text-base uppercase">
                        GET DIRECTIONS
                    </a>
                    <div class="w-32 h-px bg-stone-300 mt-2"></div>
                </div>
            </div>
        </div>
    </div>
</section>

            <!-- 360 Viewer -->
            <div class="order-2 lg:order-1">
                <div class="bg-white shadow-xl overflow-hidden h-screen relative">
                    <div id="viewer360" class="w-full h-full"></div>
                    <div id="tooltip360" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/70 text-white px-6 py-3 rounded-lg text-lg pointer-events-none z-10 transition-opacity duration-300">
                        Drag to look around
                    </div>
                </div>
            </div>
            
<!-- Pannellum Library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltip = document.getElementById('tooltip360');
        const viewer360Element = document.getElementById('viewer360');

        pannellum.viewer('viewer360', {
            "type": "equirectangular",
            "panorama": "/images/photos/360-panaroma.avif",
            "autoLoad": true,
            "autoRotate": 0,
            "showControls": false,
            "mouseZoom": false,
            "draggable": true,
            "friction": 0.15,
            "hfov": 100,
            "minHfov": 60,
            "maxHfov": 120,
            "pitch": -73,
            "yaw": 0
        });

        // Hide tooltip on click
        viewer360Element.addEventListener('click', function() {
            tooltip.style.opacity = '0';
            setTimeout(() => {
                tooltip.style.display = 'none';
            }, 300);
        });
    });
</script>