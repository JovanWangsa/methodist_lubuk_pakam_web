<?php

use App\Models\User;

$super = User::ROLE_SUPER_ADMIN;
$konten = User::ROLE_ADMIN_KONTEN;
$ppdb = User::ROLE_ADMIN_PPDB;

return [
    /*
    | Menu samping panel admin. 'peran' = siapa yang boleh melihat dan membuka.
    */
    'menu' => [
        ['label' => 'Dasbor', 'ikon' => 'dashboard', 'route' => 'admin.dasbor', 'aktif' => 'admin.dasbor', 'peran' => [$super, $konten, $ppdb]],
        ['judul' => 'Konten Website', 'peran' => [$super, $konten]],
        ['label' => 'Slide', 'ikon' => 'slideshow', 'route' => 'admin.slide.index', 'aktif' => 'admin.slide.*', 'peran' => [$super, $konten]],
        ['label' => 'Angka', 'ikon' => 'analytics', 'route' => 'admin.konten.index', 'param' => ['grup' => 'angka'], 'aktif' => 'admin.konten.*', 'grup' => 'angka', 'peran' => [$super, $konten]],
        ['label' => 'Konten Sekolah', 'ikon' => 'article', 'route' => 'admin.konten.index', 'param' => ['grup' => 'konten'], 'aktif' => 'admin.konten.*', 'grup' => 'konten', 'peran' => [$super, $konten]],
        ['label' => 'Partnership', 'ikon' => 'handshake', 'route' => 'admin.konten.edit', 'param' => ['kunci' => 'beranda.kemitraan'], 'aktif' => 'admin.konten.*', 'grup' => 'kemitraan', 'peran' => [$super, $konten]],
        ['label' => 'Pengaturan', 'ikon' => 'settings', 'route' => 'admin.pengaturan.edit', 'aktif' => 'admin.pengaturan.*', 'peran' => [$super, $konten]],
        ['judul' => 'Sistem', 'peran' => [$super]],
        ['label' => 'Pengguna', 'ikon' => 'groups', 'route' => 'admin.pengguna.index', 'aktif' => 'admin.pengguna.*', 'peran' => [$super]],
        ['label' => 'Log Aktivitas', 'ikon' => 'history', 'route' => 'admin.aktivitas', 'aktif' => 'admin.aktivitas', 'peran' => [$super]],
    ],

    /*
    | Grup blok konten di menu admin.
    */
    'grup' => [
        'angka' => ['judul' => 'Angka', 'keterangan' => 'Angka dan statistik yang tampil di Homepage dan halaman Sejarah.'],
        'konten' => ['judul' => 'Konten Sekolah', 'keterangan' => 'Teks, visi misi, sejarah, galeri, dan bagian yang tampil di beberapa halaman.'],
        'kemitraan' => ['judul' => 'Partnership', 'keterangan' => 'Daftar kemitraan strategis di Homepage.'],
    ],

    /*
    | Blok konten (tabel konten_blok) yang bisa diubah dari admin.
    | 'sembunyi' = bagian blok yang tidak ditampilkan di formulir (diatur sistem atau sprint lain).
    | 'foto' = nama kolom berisi foto, selain kolom bernama "foto".
    */
    'blok' => [
        'beranda.angka' => ['judul' => 'Angka Utama Homepage', 'grup' => 'angka', 'halaman' => 'beranda', 'keterangan' => 'Lima kotak angka tepat di bawah slideshow Homepage.'],
        'beranda.angka_sekolah' => ['judul' => 'School in Numbers', 'grup' => 'angka', 'halaman' => 'beranda', 'keterangan' => 'Bagian 4 Homepage: lulusan, medali, rasio guru, literasi. Tinggi batang grafik medali tetap mengikuti desain; ubah angkanya saja.'],
        'sejarah.hero' => ['judul' => 'Hero Halaman Sejarah', 'grup' => 'angka', 'halaman' => 'sejarah', 'keterangan' => 'Judul pembuka halaman Sejarah beserta 3 angka statistiknya.'],

        'beranda.kemitraan' => ['judul' => 'Kemitraan Strategis Pendidikan', 'grup' => 'kemitraan', 'halaman' => 'beranda', 'keterangan' => 'Bagian 6 Homepage. Tambah atau hapus mitra di daftar Item.'],

        'pembuka.hero' => ['judul' => 'Halaman 1 (Pembuka)', 'grup' => 'konten', 'halaman' => 'pembuka', 'keterangan' => 'Teks di atas slideshow pembuka dan menu bawahnya.'],
        'beranda.visi_misi' => ['judul' => 'Visi, Misi & 4 Pilar (Homepage)', 'grup' => 'konten', 'halaman' => 'beranda', 'keterangan' => 'Bagian 5 Homepage.'],
        'beranda.instagram' => ['judul' => 'Judul Bagian Instagram (Homepage)', 'grup' => 'konten', 'halaman' => 'beranda', 'keterangan' => 'Postingan diambil otomatis dari Instagram mulai Sprint 4; di sini hanya judul bagiannya.', 'sembunyi' => ['contoh']],
        'beranda.tombol_slide' => ['judul' => 'Tombol Slideshow Homepage', 'grup' => 'konten', 'halaman' => 'beranda', 'keterangan' => 'Tiga tombol yang sama di kelima slide Homepage.'],
        'sejarah.biografi' => ['judul' => 'Biografi Lembaga (Sejarah)', 'grup' => 'konten', 'halaman' => 'sejarah'],
        'sejarah.linimasa' => ['judul' => 'Linimasa (Sejarah)', 'grup' => 'konten', 'halaman' => 'sejarah'],
        'sejarah.visi_misi' => ['judul' => 'Visi, Misi & Tujuan (Sejarah)', 'grup' => 'konten', 'halaman' => 'sejarah'],
        'sejarah.galeri' => ['judul' => 'Galeri Pimpinan, Fasilitas & Kegiatan (Sejarah)', 'grup' => 'konten', 'halaman' => 'sejarah'],
        'sejarah.foto' => ['judul' => 'Foto Hero & Arsip (Sejarah)', 'grup' => 'konten', 'halaman' => 'sejarah', 'foto' => ['hero', 'arsip_1', 'arsip_2']],
        'global.banner_ppdb' => ['judul' => 'Banner PPDB (semua halaman)', 'grup' => 'konten', 'halaman' => 'beranda', 'keterangan' => 'Banner di akhir setiap halaman kecuali Halaman 1.'],
        'global.tombol_ppdb' => ['judul' => 'Tombol Banner PPDB', 'grup' => 'konten', 'halaman' => 'beranda'],
        'global.ppdb_mengambang' => ['judul' => 'Kotak PPDB Mengambang', 'grup' => 'konten', 'halaman' => 'beranda', 'keterangan' => 'Kotak kecil di kanan bawah setiap halaman.'],
        'global.footer' => ['judul' => 'Tautan Footer', 'grup' => 'konten', 'halaman' => 'beranda'],
    ],

    /*
    | Kolom teknis (class Tailwind, posisi grafik, nama rute) yang disembunyikan dari formulir
    | supaya tampilan tetap sama persis dengan desain Stitch. Nilainya dipertahankan saat menyimpan.
    */
    'kolom_teknis' => ['kelas', 'rute', 'sisi', 'tag', 'jenis', 'x', 'y', 'label_y', 'label_warna', 'label_ukuran', 'label_tebal', 'latar'],

    /*
    | Label ramah untuk nama kolom. Kolom lain ditampilkan dari namanya (garis bawah jadi spasi).
    */
    'label' => [
        'judul' => 'Judul', 'judul_1' => 'Judul baris 1', 'judul_2' => 'Judul baris 2', 'judul_aksen' => 'Judul (warna aksen)',
        'sub' => 'Subjudul', 'deskripsi' => 'Deskripsi', 'isi' => 'Isi', 'nilai' => 'Angka', 'label' => 'Label',
        'ikon' => 'Ikon', 'item' => 'Daftar item', 'poin' => 'Daftar poin', 'paragraf' => 'Paragraf', 'kutipan' => 'Kutipan',
        'kutipan_sumber' => 'Sumber kutipan', 'foto' => 'Foto', 'persen' => 'Persen', 'teks' => 'Teks', 'url' => 'Alamat tautan',
        'nama' => 'Nama', 'jabatan' => 'Jabatan', 'singkatan' => 'Singkatan (di lingkaran)', 'keterangan' => 'Keterangan',
        'tahun' => 'Tahun', 'meta' => 'Keterangan kecil', 'catatan' => 'Catatan', 'catatan_ikon' => 'Ikon catatan',
        'tahun_besar' => 'Tahun (angka besar)', 'penanda' => 'Penanda', 'kategori' => 'Kategori', 'lokasi' => 'Lokasi',
        'frekuensi' => 'Frekuensi', 'bar' => 'Batang persentase', 'batang' => 'Batang grafik', 'sumbu' => 'Angka sumbu grafik',
        'kartu_bawah' => 'Kartu bawah', 'tombol' => 'Tombol', 'menu' => 'Menu bawah', 'statistik' => 'Angka statistik',
        'tag' => 'Tag', 'tag_ikon' => 'Ikon tag', 'unit' => 'Tautan unit', 'layanan' => 'Tautan layanan', 'tautan_bawah' => 'Tautan paling bawah',
    ],

    /*
    | Isian formulir Pengaturan, per kelompok. Jenis: text, textarea, tel, email, url.
    */
    'pengaturan' => [
        'Identitas Sekolah' => [
            'nama_sekolah' => ['label' => 'Nama sekolah', 'jenis' => 'text'],
            'nama_singkat' => ['label' => 'Nama singkat', 'jenis' => 'text'],
            'header_judul' => ['label' => 'Judul di header', 'jenis' => 'text'],
            'header_sub' => ['label' => 'Subjudul di header', 'jenis' => 'text'],
            'lembaga_naungan' => ['label' => 'Lembaga naungan', 'jenis' => 'text'],
            'moto' => ['label' => 'Moto', 'jenis' => 'text'],
            'npsn' => ['label' => 'NPSN', 'jenis' => 'text'],
            'akreditasi' => ['label' => 'Akreditasi (header)', 'jenis' => 'text'],
            'akreditasi_footer' => ['label' => 'Akreditasi (footer)', 'jenis' => 'text'],
        ],
        'Kontak' => [
            'alamat_singkat' => ['label' => 'Alamat singkat (header)', 'jenis' => 'text'],
            'alamat_lengkap' => ['label' => 'Alamat lengkap (footer)', 'jenis' => 'textarea'],
            'telepon' => ['label' => 'Telepon', 'jenis' => 'text'],
            'email' => ['label' => 'Email', 'jenis' => 'email'],
            'no_admin_wa' => ['label' => 'Nomor WhatsApp admin (angka saja, diawali 62)', 'jenis' => 'tel', 'pola' => '^62[0-9]{8,13}$'],
            'no_admin_tampil' => ['label' => 'Nomor admin yang ditampilkan', 'jenis' => 'text'],
        ],
        'Tautan & Dokumen' => [
            'katalog_url' => ['label' => 'Katalog sekolah (alamat tautan, atau unggah PDF di bawah)', 'jenis' => 'text'],
            'panduan_daftar_url' => ['label' => 'Panduan daftar online (kosong = ke halaman Daftar)', 'jenis' => 'text'],
            'instagram_username' => ['label' => 'Username Instagram (tanpa @)', 'jenis' => 'text'],
            'instagram_url' => ['label' => 'Alamat profil Instagram', 'jenis' => 'url'],
            'lms_url' => ['label' => 'Alamat E-Learning (LMS)', 'jenis' => 'url'],
        ],
        'Footer' => [
            'footer_deskripsi' => ['label' => 'Deskripsi sekolah di footer', 'jenis' => 'textarea'],
        ],
    ],
];
