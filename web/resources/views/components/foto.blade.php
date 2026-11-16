@props(['src' => null, 'alt' => ''])

{{--
    Foto konten. Selama foto asli sekolah belum diunggah, yang tampil adalah kotak abu-abu polos
    dengan ukuran dan posisi yang sama (class yang sama dengan <img> di desain Stitch).
--}}
@if ($src)
    <img {{ $attributes }} src="{{ asset($src) }}" alt="{{ $alt }}" loading="lazy" decoding="async"/>
@else
    <div {{ $attributes->merge(['class' => 'bg-gray-300']) }} role="img" aria-label="{{ $alt ?: 'Foto belum tersedia' }}"></div>
@endif
