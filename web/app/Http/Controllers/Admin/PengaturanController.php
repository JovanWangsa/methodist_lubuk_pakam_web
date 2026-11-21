<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Aktivitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

/** Pengaturan umum: identitas, kontak, nomor WhatsApp admin, katalog PDF, tautan, footer. */
class PengaturanController extends Controller
{
    public function edit(): View
    {
        return view('admin.pengaturan', [
            'kelompok' => config('admin.pengaturan'),
            'nilai' => Setting::semua(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $isian = collect(config('admin.pengaturan'))->collapse();

        $aturan = $isian->map(function (array $isi): array {
            $aturan = ['nullable', 'string', $isi['jenis'] === 'textarea' ? 'max:1000' : 'max:255'];

            return match ($isi['jenis']) {
                'email' => [...$aturan, 'email'],
                'url' => [...$aturan, 'url:http,https'],
                default => isset($isi['pola']) ? [...$aturan, 'regex:/'.$isi['pola'].'/'] : $aturan,
            };
        })->all();
        $aturan['katalog_pdf'] = ['nullable', 'file', 'mimes:pdf', 'max:10240'];

        $data = $request->validate($aturan, [
            'no_admin_wa.regex' => 'Nomor WhatsApp harus angka saja dan diawali 62, misalnya 6281264976447.',
        ], $isian->map(fn ($isi) => Str::lower(Str::before($isi['label'], ' (')))->all());

        if ($request->hasFile('katalog_pdf')) {
            $data['katalog_url'] = $this->simpanKatalog($request);
        }

        foreach ($isian->keys() as $kunci) {
            Setting::query()->updateOrCreate(['key' => $kunci], ['value' => $data[$kunci] ?? '']);
        }

        Aktivitas::catat(Aktivitas::UBAH, 'Pengaturan umum');

        return back()->with('status', 'Pengaturan tersimpan.');
    }

    private function simpanKatalog(Request $request): string
    {
        $lama = Setting::ambil('katalog_url');
        if ($lama && str_starts_with($lama, 'unggahan/dokumen/')) {
            File::delete(public_path($lama));
        }

        File::ensureDirectoryExists(public_path('unggahan/dokumen'));
        $nama = 'katalog-sekolah-'.now()->format('YmdHis').'.pdf';
        $request->file('katalog_pdf')->move(public_path('unggahan/dokumen'), $nama);

        return 'unggahan/dokumen/'.$nama;
    }
}
