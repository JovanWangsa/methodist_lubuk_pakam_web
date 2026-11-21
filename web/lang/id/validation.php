<?php

/*
| Pesan validasi Bahasa Indonesia untuk aturan yang dipakai website ini.
| Aturan lain yang tidak tercantum memakai pesan bawaan Laravel (Bahasa Inggris).
*/

return [
    'accepted' => ':Attribute harus disetujui.',
    'array' => ':Attribute harus berupa daftar.',
    'boolean' => ':Attribute harus bernilai ya atau tidak.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'current_password' => 'Password lama salah.',
    'date' => ':Attribute bukan tanggal yang valid.',
    'dimensions' => 'Ukuran gambar :attribute terlalu besar.',
    'email' => ':Attribute harus berupa alamat email yang valid.',
    'exists' => ':Attribute yang dipilih tidak ditemukan.',
    'file' => ':Attribute harus berupa file.',
    'image' => ':Attribute harus berupa gambar.',
    'in' => ':Attribute yang dipilih tidak valid.',
    'integer' => ':Attribute harus berupa bilangan bulat.',
    'max' => [
        'array' => ':Attribute maksimal berisi :max item.',
        'file' => ':Attribute maksimal :max kilobyte.',
        'numeric' => ':Attribute maksimal :max.',
        'string' => ':Attribute maksimal :max karakter.',
    ],
    'mimes' => ':Attribute harus berupa file bertipe: :values.',
    'min' => [
        'array' => ':Attribute minimal berisi :min item.',
        'file' => ':Attribute minimal :min kilobyte.',
        'numeric' => ':Attribute minimal :min.',
        'string' => ':Attribute minimal :min karakter.',
    ],
    'numeric' => ':Attribute harus berupa angka.',
    'password' => [
        'letters' => ':Attribute harus berisi minimal satu huruf.',
        'mixed' => ':Attribute harus berisi huruf besar dan huruf kecil.',
        'numbers' => ':Attribute harus berisi minimal satu angka.',
        'symbols' => ':Attribute harus berisi minimal satu simbol.',
        'uncompromised' => ':Attribute ini pernah bocor di internet. Pilih password lain.',
    ],
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':Attribute wajib diisi.',
    'required_if' => ':Attribute wajib diisi.',
    'required_with' => ':Attribute wajib diisi bila :values diisi.',
    'string' => ':Attribute harus berupa teks.',
    'unique' => ':Attribute sudah dipakai.',
    'uploaded' => ':Attribute gagal diunggah. Periksa ukuran file.',
    'url' => ':Attribute harus berupa alamat web yang valid (diawali http:// atau https://).',

    'attributes' => [
        'email' => 'email',
        'password' => 'password',
        'name' => 'nama',
        'judul' => 'judul',
        'urutan' => 'urutan',
        'alt' => 'teks alternatif',
        'deskripsi' => 'deskripsi',
        'gambar' => 'foto',
        'katalog_pdf' => 'file katalog',
    ],
];
