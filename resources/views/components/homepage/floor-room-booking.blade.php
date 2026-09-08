@php
    $bookingUrl = config('site.booking_url') ?: 'mailto:'.config('seo.business.contact.email');
    $bookingExternal = (bool) config('site.booking_url');
    $floors = \App\Models\Floor::with('rooms')->ordered()->get()->map(fn ($floor) => [
        'id' => $floor->slug,
        'name' => $floor->name,
        'view' => $floor->view,
        'band' => $floor->band(),
        'rooms' => $floor->rooms->map(fn ($room) => [
            'id' => $room->room_number,
            'name' => $room->room_name,
            'price' => $room->price,
            'image' => asset($room->image_url),
            'description' => $room->description,
        ])->values()->all(),
    ])->values()->all();
@endphp

<section id="floor-booking" class="fp-screen flex flex-col bg-[#FAF6F0]" data-fp-section data-header-theme="light" tabindex="-1" aria-label="Our rooms">
    <div class="mx-auto flex h-full w-full max-w-screen-2xl flex-col px-5 pb-16 pt-24 md:px-10 md:pt-28 lg:flex-row lg:items-stretch lg:gap-12">

        <!-- Left: heading, floor tabs, room panel -->
        <div class="flex min-h-0 flex-1 flex-col lg:w-[46%] lg:flex-none">
            <p class="fp-eyebrow">Accommodation</p>
            <h2 class="mt-1 font-serif text-3xl font-bold text-[#0a1628] sm:text-4xl md:text-5xl">Explore Our Rooms</h2>
            <p class="mt-2 text-sm text-stone-600 md:text-base">Pick a floor to see its rooms and the view they wake up to.</p>

            <div id="floor-tabs" role="tablist" aria-label="Floors" class="fp-carousel mt-5 flex gap-2 overflow-x-auto pb-1"></div>

            <!-- Desktop room panel -->
            <div id="floor-panel" class="mt-5 hidden min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border border-[#0a1628]/10 bg-white shadow-[0_30px_60px_-30px_rgba(10,22,40,0.35)] md:flex">
                <div id="room-carousel" class="fp-carousel flex h-28 shrink-0 snap-x overflow-x-auto bg-[#0a1628] lg:h-36" role="tablist" aria-label="Rooms on this floor"></div>
                <div class="flex min-h-0 flex-1 flex-col gap-3 p-5 lg:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p id="room-floor" class="fp-eyebrow"></p>
                            <h3 id="room-type" class="mt-1 font-serif text-2xl font-bold text-[#0a1628]"></h3>
                        </div>
                        <div class="text-right">
                            <span id="room-price" class="text-2xl font-bold tabular-nums text-[#3E8A8E]"></span>
                            <span class="block text-xs text-stone-500">per night</span>
                        </div>
                    </div>
                    <p id="room-description" class="line-clamp-3 leading-relaxed text-stone-600"></p>
                    <div class="flex flex-wrap gap-2" aria-label="Amenities">
                        @foreach (['Free Wi-Fi', 'Air conditioning', '24/7 room service', 'Premium amenities'] as $amenity)
                            <span class="amenity-chip">
                                <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                {{ $amenity }}
                            </span>
                        @endforeach
                    </div>
                    <div class="mt-auto flex items-center justify-between gap-3 pt-2">
                        <a href="{{ $bookingUrl }}" @if ($bookingExternal) target="_blank" rel="noopener" @endif class="btn-sea flex-1">
                            Check Availability &amp; Book
                        </a>
                        <div class="flex gap-2">
                            <button type="button" class="icon-btn" onclick="floorBookingNavigate(-1)" aria-label="Previous room" id="room-prev">
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                            </button>
                            <button type="button" class="icon-btn" onclick="floorBookingNavigate(1)" aria-label="Next room" id="room-next">
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile room cards -->
            <div class="mt-4 flex min-h-0 flex-1 flex-col md:hidden" data-carousel-group>
                <div id="mobile-rooms-container" data-carousel class="fp-carousel -mx-5 flex min-h-0 flex-1 snap-x snap-mandatory items-stretch gap-4 overflow-x-auto px-5 pb-1"></div>
                <div data-carousel-dots class="mt-2 flex justify-center text-[#3E8A8E]"></div>
            </div>
        </div>

        <!-- Right: the building with clickable floors -->
        <div class="relative hidden min-h-0 flex-1 items-center justify-center md:flex">
            <div id="building-box" class="relative aspect-square h-full max-h-[78dvh] w-auto max-w-full">
                <img src="{{ asset('images/building_transparent.png') }}" alt="Illustration of the Sailors Mirissa building" width="1024" height="1024" loading="lazy" decoding="async"
                    class="pointer-events-none absolute inset-0 h-full w-full select-none object-contain">
                <div id="floor-bands" class="absolute inset-0"></div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            'use strict';

            const floors = @json($floors);
            const bookingHref = @json($bookingUrl);
            const bookingExternal = @json($bookingExternal);

            const tabsEl = document.getElementById('floor-tabs');
            const bandsEl = document.getElementById('floor-bands');
            const carouselEl = document.getElementById('room-carousel');
            const roomFloorEl = document.getElementById('room-floor');
            const roomTypeEl = document.getElementById('room-type');
            const roomDescEl = document.getElementById('room-description');
            const roomPriceEl = document.getElementById('room-price');
            const prevBtn = document.getElementById('room-prev');
            const nextBtn = document.getElementById('room-next');
            const mobileRoomsEl = document.getElementById('mobile-rooms-container');

            let activeFloor = null;
            let activeRoomIndex = 0;

            const escape = (value) => String(value).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

            function renderTabs() {
                tabsEl.innerHTML = floors.map((floor) => `
                    <button type="button" role="tab" class="floor-tab" data-floor-id="${escape(floor.id)}" aria-selected="false">
                        <span class="text-sm font-semibold">${escape(floor.name)}</span>
                        <span class="floor-tab__view">${escape(floor.view)} · ${floor.rooms.length} room${floor.rooms.length === 1 ? '' : 's'}</span>
                    </button>
                `).join('');
                tabsEl.querySelectorAll('.floor-tab').forEach((tab) => {
                    tab.addEventListener('click', () => selectFloor(floors.find((f) => f.id === tab.dataset.floorId)));
                });
            }

            function renderBands() {
                if (!bandsEl) return;
                bandsEl.innerHTML = floors.filter((floor) => floor.band).map((floor) => `
                    <button type="button" class="floor-band" data-floor-id="${escape(floor.id)}" aria-selected="false" aria-label="${escape(floor.name)}: ${escape(floor.view)}"
                        style="left:${floor.band.x}%;top:${floor.band.y}%;width:${floor.band.w}%;height:${floor.band.h}%">
                        <span class="floor-band__label">${escape(floor.name)}</span>
                    </button>
                `).join('');
                bandsEl.querySelectorAll('.floor-band').forEach((band) => {
                    band.addEventListener('click', () => selectFloor(floors.find((f) => f.id === band.dataset.floorId)));
                    band.addEventListener('mouseenter', () => highlightTab(band.dataset.floorId, true));
                    band.addEventListener('mouseleave', () => highlightTab(band.dataset.floorId, false));
                });
            }

            function highlightTab(floorId, on) {
                const tab = tabsEl.querySelector(`.floor-tab[data-floor-id="${CSS.escape(floorId)}"]`);
                tab?.classList.toggle('ring-2', on);
                tab?.classList.toggle('ring-[#72B6B9]/50', on);
            }

            function selectFloor(floor) {
                if (!floor) return;
                activeFloor = floor;
                activeRoomIndex = 0;

                tabsEl.querySelectorAll('.floor-tab').forEach((tab) => tab.setAttribute('aria-selected', String(tab.dataset.floorId === floor.id)));
                bandsEl?.querySelectorAll('.floor-band').forEach((band) => band.setAttribute('aria-selected', String(band.dataset.floorId === floor.id)));

                renderRoomThumbs(floor);
                renderMobileCards(floor);
                selectRoom(0, false);
            }

            function renderRoomThumbs(floor) {
                if (!carouselEl) return;
                carouselEl.innerHTML = floor.rooms.map((room, index) => `
                    <button type="button" role="tab" class="room-thumb" data-index="${index}" aria-selected="false" aria-label="${escape(room.name)}">
                        <img src="${escape(room.image)}" alt="" loading="lazy" decoding="async">
                        <span class="room-thumb__name">${escape(room.name)}</span>
                    </button>
                `).join('');
                carouselEl.querySelectorAll('.room-thumb').forEach((thumb) => {
                    thumb.addEventListener('click', () => selectRoom(Number(thumb.dataset.index), true));
                });
            }

            function selectRoom(index, scroll) {
                if (!activeFloor || !activeFloor.rooms.length) return;
                index = Math.max(0, Math.min(activeFloor.rooms.length - 1, index));
                activeRoomIndex = index;
                const room = activeFloor.rooms[index];

                if (roomFloorEl) roomFloorEl.textContent = `${activeFloor.name} · ${activeFloor.view}`;
                if (roomTypeEl) roomTypeEl.textContent = room.name;
                if (roomDescEl) roomDescEl.textContent = room.description;
                if (roomPriceEl) roomPriceEl.textContent = room.price;
                if (prevBtn) prevBtn.disabled = index === 0;
                if (nextBtn) nextBtn.disabled = index === activeFloor.rooms.length - 1;

                carouselEl?.querySelectorAll('.room-thumb').forEach((thumb, i) => {
                    thumb.setAttribute('aria-selected', String(i === index));
                    if (i === index && scroll) thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                });
            }

            function navigateRoom(direction) {
                selectRoom(activeRoomIndex + direction, true);
            }

            const amenityChip = (label) => `<span class="amenity-chip"><svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>${escape(label)}</span>`;

            function renderMobileCards(floor) {
                if (!mobileRoomsEl) return;
                mobileRoomsEl.innerHTML = floor.rooms.map((room) => `
                    <article class="flex w-[82vw] max-w-sm shrink-0 snap-center flex-col overflow-hidden rounded-2xl border border-[#0a1628]/10 bg-white shadow-lg">
                        <div class="relative h-36 shrink-0 overflow-hidden sm:h-44">
                            <img src="${escape(room.image)}" alt="${escape(room.name)}" loading="lazy" decoding="async" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a1628]/40 to-transparent"></div>
                            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-[#0a1628]">${escape(floor.view)}</span>
                        </div>
                        <div class="flex min-h-0 flex-1 flex-col gap-2 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="font-serif text-lg font-bold text-[#0a1628]">${escape(room.name)}</h3>
                                <div class="shrink-0 text-right">
                                    <span class="text-xl font-bold tabular-nums text-[#3E8A8E]">${escape(room.price)}</span>
                                    <span class="block text-xs text-stone-500">per night</span>
                                </div>
                            </div>
                            <p class="line-clamp-3 text-sm leading-relaxed text-stone-600">${escape(room.description)}</p>
                            <div class="flex flex-wrap gap-1.5">${['Free Wi-Fi', 'Air conditioning', 'Room service'].map(amenityChip).join('')}</div>
                            <a href="${escape(bookingHref)}" ${bookingExternal ? 'target="_blank" rel="noopener"' : ''} class="btn-sea mt-auto w-full text-sm">Check Availability &amp; Book</a>
                        </div>
                    </article>
                `).join('');
                window.fpCarousel?.init(mobileRoomsEl);
                mobileRoomsEl.scrollTo({ left: 0 });
            }

            renderTabs();
            renderBands();
            if (floors.length) selectFloor(floors[0]);

            window.floorBookingNavigate = navigateRoom;
        })();
    </script>

    <x-scroll-next target="attractions" label="attractions" theme="light" />
</section>
