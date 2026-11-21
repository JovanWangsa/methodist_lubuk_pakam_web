{{--
    Satu isian formulir blok konten, dipanggil berulang untuk data bersarang.
    $nilai = nilai saat ini, $kolom = nama kolom (atau nomor item), $nama = jalur seperti [visi][judul].
--}}
@use('App\Support\EditorBlok')
@php
    $teksKolom = is_string($kolom) ? $kolom : '';
    $id = 'f'.substr(md5($nama), 0, 10);
    $label = EditorBlok::label($kolom);
@endphp

@if ($teksKolom !== '' && $editor->teknis($teksKolom, $nilai))
    {{-- kolom teknis: tidak ditampilkan, nilainya dipertahankan saat menyimpan --}}
@elseif ($teksKolom !== '' && $editor->foto($teksKolom))
    <div class="space-y-1">
        <span class="a-label">{{ $label }}</span>
        <div class="flex items-center gap-space-md">
            <div class="w-28 h-20 shrink-0 rounded-md overflow-hidden bg-gray-300">
                <img alt="" class="w-full h-full object-cover {{ $nilai ? '' : 'hidden' }}" data-pratinjau @if ($nilai) src="{{ asset(str_replace('-1920.webp', '-640.webp', $nilai)) }}" @endif>
            </div>
            <div class="flex-1 space-y-1">
                <input accept="image/jpeg,image/png,image/webp" class="a-input" data-pratinjau-input name="berkas{{ $nama }}" type="file">
                @if ($nilai)
                    <label class="flex items-center gap-2 font-body-sm text-body-sm">
                        <input class="rounded border-outline-variant text-error" name="hapus{{ $nama }}" type="checkbox" value="1"> Hapus foto
                    </label>
                @endif
            </div>
        </div>
    </div>
@elseif (is_array($nilai) && array_is_list($nilai))
    @php
        $penanda = '__'.substr(md5($nama), 0, 8).'__';
        $contoh = EditorBlok::templat($nilai === [] ? '' : end($nilai));
    @endphp
    <fieldset class="rounded-lg border border-surface-container p-space-sm md:p-space-md space-y-space-sm" data-daftar data-penanda="{{ $penanda }}">
        <legend class="px-1 font-label-lg text-label-lg text-primary">{{ $label }}</legend>
        <input name="data{{ $nama }}[{{ EditorBlok::PENANDA_DAFTAR }}]" type="hidden" value="1">
        <div class="space-y-space-sm" data-daftar-isi>
            @foreach ($nilai as $i => $item)
                @include('admin.konten._butir', ['item' => $item, 'i' => $i, 'nama' => $nama])
            @endforeach
        </div>
        <template data-templat>
            @include('admin.konten._butir', ['item' => $contoh, 'i' => $penanda, 'nama' => $nama])
        </template>
        <button class="a-tombol-kedua px-space-sm py-1" data-tambah type="button"><span aria-hidden="true" class="material-symbols-outlined text-[18px]">add</span> Tambah item</button>
    </fieldset>
@elseif (is_array($nilai))
    @if ($tingkat > 0)
        <fieldset class="rounded-lg border border-surface-container p-space-sm md:p-space-md space-y-space-md">
            <legend class="px-1 font-label-lg text-label-lg text-primary">{{ $label }}</legend>
    @endif
    @foreach ($nilai as $k => $v)
        @include('admin.konten._isian', ['nilai' => $v, 'kolom' => $k, 'nama' => $nama.'['.$k.']', 'tingkat' => $tingkat + 1])
    @endforeach
    @if ($tingkat > 0)
        </fieldset>
    @endif
@else
    <div>
        @if (is_string($kolom))<label class="a-label" for="{{ $id }}">{{ $label }}</label>@endif
        @if (is_int($nilai) || is_float($nilai))
            <input class="a-input" id="{{ $id }}" name="data{{ $nama }}" step="any" type="number" value="{{ $nilai }}">
        @elseif (EditorBlok::panjang($kolom, $nilai))
            <textarea class="a-input" id="{{ $id }}" name="data{{ $nama }}" rows="{{ mb_strlen((string) $nilai) > 300 ? 6 : 3 }}">{{ $nilai }}</textarea>
        @else
            <input class="a-input" id="{{ $id }}" name="data{{ $nama }}" type="text" value="{{ $nilai }}">
        @endif
        @if (is_string($kolom) && str_contains($kolom, 'ikon'))
            <p class="a-bantuan">Nama ikon Material Symbols (fonts.google.com/icons), misalnya school. Ikon baru perlu ditambahkan ke font oleh tim.</p>
        @endif
    </div>
@endif
