<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use App\Support\Aktivitas;
use App\Support\PengolahGambar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Slide Halaman 1 (pembuka) dan Homepage. Slide unit menyusul bersama halaman unit.
 */
class SlideController extends Controller
{
    /** @var array<string, string> */
    public const LOKASI = [
        Slide::LOKASI_PEMBUKA => 'Halaman 1 (Pembuka)',
        Slide::LOKASI_BERANDA => 'Homepage',
    ];

    public function index(Request $request): View
    {
        $lokasi = $request->query('lokasi', Slide::LOKASI_PEMBUKA);
        abort_unless(isset(self::LOKASI[$lokasi]), 404);

        return view('admin.slide.index', [
            'lokasi' => $lokasi,
            'slides' => Slide::query()->where('lokasi', $lokasi)->orderBy('urutan')->orderBy('id')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        $lokasi = $request->query('lokasi', Slide::LOKASI_PEMBUKA);
        abort_unless(isset(self::LOKASI[$lokasi]), 404);

        $urutan = (int) Slide::query()->where('lokasi', $lokasi)->max('urutan') + 1;

        return view('admin.slide.form', ['slide' => new Slide(['lokasi' => $lokasi, 'urutan' => $urutan, 'aktif' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $lokasi = $request->input('lokasi');
        abort_unless(isset(self::LOKASI[$lokasi]), 422);

        $slide = new Slide(['lokasi' => $lokasi]);

        // Slide Homepage baru meniru gaya (class Tailwind, tag judul) slide terakhir di lokasi yang sama.
        $contoh = Slide::query()->where('lokasi', $lokasi)->orderByDesc('urutan')->first();
        $atribut = $contoh?->atribut;
        if (is_array($atribut)) {
            $atribut['tag'] = 'h2';
        }
        $slide->atribut = $atribut;

        $this->simpan($request, $slide);
        Aktivitas::catat(Aktivitas::TAMBAH, 'Slide: '.$slide->judul, $slide->id);

        return redirect()->route('admin.slide.index', ['lokasi' => $lokasi])->with('status', 'Slide ditambahkan.');
    }

    public function edit(Slide $slide): View
    {
        abort_unless(isset(self::LOKASI[$slide->lokasi]), 404);

        return view('admin.slide.form', ['slide' => $slide]);
    }

    public function update(Request $request, Slide $slide): RedirectResponse
    {
        abort_unless(isset(self::LOKASI[$slide->lokasi]), 404);

        $this->simpan($request, $slide);
        Aktivitas::catat(Aktivitas::UBAH, 'Slide: '.$slide->judul, $slide->id);

        return redirect()->route('admin.slide.index', ['lokasi' => $slide->lokasi])->with('status', 'Slide tersimpan.');
    }

    public function destroy(Slide $slide): RedirectResponse
    {
        abort_unless(isset(self::LOKASI[$slide->lokasi]), 404);

        PengolahGambar::hapus($slide->gambar);
        Aktivitas::catat(Aktivitas::HAPUS, 'Slide: '.$slide->judul, $slide->id);
        $slide->delete();

        return redirect()->route('admin.slide.index', ['lokasi' => $slide->lokasi])->with('status', 'Slide dihapus.');
    }

    private function simpan(Request $request, Slide $slide): void
    {
        $beranda = $slide->lokasi === Slide::LOKASI_BERANDA;

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'alt' => ['nullable', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:0', 'max:999'],
            'gambar' => ['nullable', ...PengolahGambar::ATURAN],
            'lencana_teks' => [Rule::requiredIf($beranda), 'nullable', 'string', 'max:80'],
            'lencana_ikon' => ['nullable', 'string', 'max:40', 'regex:/^[a-z0-9_]+$/'],
            'deskripsi' => [Rule::requiredIf($beranda), 'nullable', 'string', 'max:300'],
        ], [], [
            'lencana_teks' => 'teks lencana',
            'lencana_ikon' => 'ikon lencana',
            'gambar' => 'foto',
        ]);

        $slide->fill([
            'judul' => $data['judul'],
            'alt' => ($data['alt'] ?? null) ?: $data['judul'],
            'urutan' => $data['urutan'],
            'aktif' => $request->boolean('aktif'),
        ]);

        if ($beranda) {
            $atribut = $slide->atribut ?? [];
            $atribut['lencana']['teks'] = $data['lencana_teks'];
            $atribut['lencana']['ikon'] = ($data['lencana_ikon'] ?? null) ?: ($atribut['lencana']['ikon'] ?? 'verified');
            $atribut['deskripsi'] = $data['deskripsi'];
            $slide->atribut = $atribut;
        }

        if ($request->hasFile('gambar')) {
            PengolahGambar::hapus($slide->gambar);
            $slide->gambar = PengolahGambar::simpan($request->file('gambar'), 'slide');
        } elseif ($request->boolean('hapus_gambar')) {
            PengolahGambar::hapus($slide->gambar);
            $slide->gambar = null;
        }

        $slide->save();
    }
}
