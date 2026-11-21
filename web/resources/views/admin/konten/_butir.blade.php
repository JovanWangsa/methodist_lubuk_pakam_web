{{-- Satu item dalam daftar, dengan tombol hapus. --}}
<div class="relative rounded-lg bg-surface-container-low p-space-sm md:p-space-md space-y-space-sm" data-butir>
    <div class="flex items-center justify-between gap-space-sm">
        <span class="font-label-md text-label-md text-on-surface-variant" data-butir-nomor>Item</span>
        <button class="inline-flex items-center gap-1 rounded-md px-2 py-1 font-label-sm text-label-sm text-error hover:bg-error-container" data-hapus type="button">
            <span aria-hidden="true" class="material-symbols-outlined text-[16px]">delete</span> Hapus
        </button>
    </div>
    @if (is_array($item))
        @foreach ($item as $k => $v)
            @include('admin.konten._isian', ['nilai' => $v, 'kolom' => $k, 'nama' => $nama.'['.$i.']['.$k.']', 'tingkat' => 2])
        @endforeach
    @else
        @include('admin.konten._isian', ['nilai' => $item, 'kolom' => -1, 'nama' => $nama.'['.$i.']', 'tingkat' => 2])
    @endif
</div>
