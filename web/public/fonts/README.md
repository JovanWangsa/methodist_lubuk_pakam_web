# Font

- `plus-jakarta-sans-*.woff2`, `inter-*.woff2`: dari paket `@fontsource-variable` (lisensi SIL OFL 1.1), hanya gaya normal seperti di desain Stitch.
- `material-symbols-outlined-subset.woff2`: Material Symbols Outlined (lisensi Apache 2.0) yang dipangkas hanya berisi ikon yang dipakai website, dari 4 MB menjadi sekitar 72 KB.

File di folder ini dipakai langsung oleh `public/css/situs.css`; tidak ada proses build.

## Menambah ikon baru

1. Tambahkan nama ikon ke `ikon.txt` di folder ini.
2. Unduh font lengkap dari repositori resmi Google:
   https://raw.githubusercontent.com/google/material-design-icons/master/variablefont/MaterialSymbolsOutlined%5BFILL%2CGRAD%2Copsz%2Cwght%5D.woff2
   lalu simpan sebagai `material-symbols-lengkap.woff2` di luar repo (misalnya folder Downloads).
3. Jalankan dari folder `web` (butuh Python dengan `fonttools` dan `brotli`):

   ```
   pip install fonttools brotli
   python ../tools/subset-ikon.py C:\Users\NAMA\Downloads\material-symbols-lengkap.woff2 public/fonts/ikon.txt public/fonts/material-symbols-outlined-subset.woff2
   ```

4. Muat ulang browser dengan Ctrl + F5. Nama ikon dipakai sebagai teks biasa, jadi CSS tidak perlu dibuat ulang.
