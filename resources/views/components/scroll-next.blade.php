@props([
    'target',
    'label' => 'next section',
    'theme' => 'dark',
    'up' => false,
])

@php
    $tone = $theme === 'light'
        ? 'border-black/15 bg-black/5 text-gray-800 hover:bg-black/10 focus-visible:ring-gray-800/40'
        : 'border-white/30 bg-white/10 text-white hover:bg-white/20 focus-visible:ring-white/60';
@endphp

<a href="#{{ $target }}"
   data-fp-next
   {{ $attributes->class(["fp-next absolute bottom-5 left-1/2 z-30 grid size-11 -translate-x-1/2 place-items-center rounded-full border backdrop-blur-sm transition-[background-color,transform,opacity] duration-200 ease-out active:scale-95 focus-visible:outline-none focus-visible:ring-2", $tone, 'rotate-180' => $up]) }}>
    <svg class="size-5 motion-safe:animate-[fp-nudge_2.4s_ease-in-out_infinite]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
    </svg>
    <span class="sr-only">Scroll to {{ $label }}</span>
</a>
