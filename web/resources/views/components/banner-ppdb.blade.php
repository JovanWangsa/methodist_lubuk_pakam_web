@php($b = \App\Support\KontenPublik::blok('global.banner_ppdb'))
{{-- Banner PPDB di akhir konten, persis desain Stitch Hal. 3 (bagian 7). --}}
<section class="w-full py-12 bg-surface">
<div class="max-w-7xl mx-auto px-6 lg:px-12">
<div class="bg-gradient-to-r from-primary-container via-primary to-primary text-on-primary rounded-2xl p-8 md:p-10 shadow-xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8">
<div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-secondary/20 blur-3xl pointer-events-none"></div>
<div class="space-y-3 max-w-2xl relative z-10 text-center lg:text-left">
<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-bold">
<span class="material-symbols-outlined text-[16px]">campaign</span>
            {{ $b['label'] ?? '' }}
          </div>
<h3 class="font-headline-lg text-headline-lg text-on-primary font-bold">
            {{ $b['judul'] ?? '' }}
          </h3>
<p class="font-body-md text-body-md text-primary-fixed">
            {{ $b['deskripsi'] ?? '' }}
          </p>
</div>
<div class="flex flex-wrap items-center justify-center gap-3 relative z-10 shrink-0">
<a class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-surface-container-lowest/15 backdrop-blur-md text-on-primary font-label-md text-label-md font-semibold hover:bg-surface-container-lowest/25 transition-all" href="{{ \App\Support\Tautan::whatsapp() }}" rel="noopener" target="_blank">
<span class="material-symbols-outlined text-[18px]">chat</span>
<span>{{ $b['tombol_wa'] ?? '' }}</span>
</a>
<a class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-surface-container-lowest text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-all" href="{{ \App\Support\Tautan::katalog() }}">
<span class="material-symbols-outlined text-[18px]">download</span>
<span>{{ $b['tombol_katalog'] ?? '' }}</span>
</a>
<a class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-secondary text-on-secondary font-label-md text-label-md font-bold shadow-md hover:bg-secondary-container hover:text-on-secondary-container transition-all" href="{{ route('ppdb.daftar') }}">
<span>{{ $b['tombol_daftar'] ?? '' }}</span>
<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</div>
</div>
</div>
</section>
