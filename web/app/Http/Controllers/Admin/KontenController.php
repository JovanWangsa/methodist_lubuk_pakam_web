<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontenBlok;
use App\Support\Aktivitas;
use App\Support\EditorBlok;
use App\Support\PengolahGambar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Modul Angka, Konten Sekolah, dan Partnership. Ketiganya mengubah blok konten JSON
 * (tabel konten_blok) dengan formulir yang sama; daftar bloknya ada di config/admin.php.
 */
class KontenController extends Controller
{
    public function index(string $grup): View
    {
        abort_unless(config("admin.grup.{$grup}"), 404);

        $blok = collect(config('admin.blok'))->where('grup', $grup);

        return view('admin.konten.index', [
            'grup' => $grup,
            'infoGrup' => config("admin.grup.{$grup}"),
            'blok' => $blok,
            'diubah' => KontenBlok::query()->whereIn('kunci', $blok->keys())->pluck('updated_at', 'kunci'),
        ]);
    }

    public function edit(string $kunci): View
    {
        $definisi = $this->definisi($kunci);

        return view('admin.konten.edit', [
            'kunci' => $kunci,
            'definisi' => $definisi,
            'data' => KontenBlok::query()->where('kunci', $kunci)->value('data') ?? [],
            'editor' => EditorBlok::untuk($kunci),
        ]);
    }

    public function update(Request $request, string $kunci): RedirectResponse
    {
        $definisi = $this->definisi($kunci);

        $request->validate([
            'data' => ['nullable', 'array'],
            'berkas' => ['nullable', 'array'],
            'berkas.*' => ['nullable'],
        ]);
        $this->validasiBerkas($request->file('berkas', []));

        $blok = KontenBlok::query()->firstOrNew(['kunci' => $kunci], ['data' => []]);
        $blok->data = EditorBlok::untuk($kunci)->gabung(
            $blok->data ?? [],
            $request->input('data', []),
            $request->file('berkas', []),
            $request->input('hapus', []),
        );
        $blok->save();

        Aktivitas::catat(Aktivitas::UBAH, 'Konten: '.$definisi['judul'], $blok->id);

        return redirect()->route('admin.konten.edit', $kunci)->with('status', $definisi['judul'].' tersimpan.');
    }

    /** @return array<string, mixed> */
    private function definisi(string $kunci): array
    {
        // Kunci blok berisi titik, jadi tidak bisa dibaca dengan config('admin.blok.'.$kunci).
        return config('admin.blok')[$kunci] ?? abort(404);
    }

    /** Semua file di formulir (bisa bersarang) harus gambar yang valid. */
    private function validasiBerkas(mixed $berkas, string $jalur = 'berkas'): void
    {
        foreach ((array) $berkas as $k => $isi) {
            if (is_array($isi)) {
                $this->validasiBerkas($isi, "{$jalur}.{$k}");

                continue;
            }

            validator(['gambar' => $isi], ['gambar' => ['nullable', ...PengolahGambar::ATURAN]], [], ['gambar' => 'foto'])->validate();
        }
    }
}
