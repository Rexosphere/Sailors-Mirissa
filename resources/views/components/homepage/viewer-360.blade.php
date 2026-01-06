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
