# Font

- `plus-jakarta-sans-*.woff2`, `inter-*.woff2`: dari paket `@fontsource-variable` (lisensi SIL OFL 1.1), hanya gaya normal seperti di desain Stitch.
- `material-symbols-outlined-subset.woff2`: Material Symbols Outlined (lisensi Apache 2.0) yang dipangkas hanya berisi ikon yang dipakai website, dari 4 MB menjadi sekitar 72 KB.

## Menambah ikon baru

1. Tambahkan nama ikon ke `ikon.txt` di folder ini.
2. Jalankan (butuh Python dengan `fonttools` dan `brotli`):

   ```bash
   pip install fonttools brotli
   python ../../../tools/subset-ikon.py ../../node_modules/material-symbols/material-symbols-outlined.woff2 ikon.txt material-symbols-outlined-subset.woff2
   ```

3. Jalankan `npm run build`.
