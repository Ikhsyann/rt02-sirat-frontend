@props([
    'media' => null,      // App\Models\Pengaturan (null = belum ada pengaturan)
    'fallback' => null,   // path gambar cadangan di public/images
    'overlay' => 'bg-cover bg-center mix-blend-overlay pointer-events-none opacity-75',
])

@php($url = $media?->heroUrl())
{{-- Hero global: media diunggah admin lewat Pengaturan Tampilan (backend). --}}
@if ($url && $media->heroIsVideo())
    <video class="absolute inset-0 w-full h-full object-cover pointer-events-none opacity-75" autoplay muted loop playsinline
           src="{{ $url }}"></video>
@elseif ($url)
    <div class="absolute inset-0 {{ $overlay }}" style="background-image: url(&quot;{{ $url }}&quot;);"></div>
@elseif ($fallback)
    <div class="absolute inset-0 {{ $overlay }}" style="background-image: url(&quot;{{ asset($fallback) }}&quot;);"></div>
@endif
