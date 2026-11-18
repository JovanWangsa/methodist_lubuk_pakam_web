{{-- Tombol gulir di sisi kanan layar, ada di semua halaman.
     Klik: pindah ke bagian berikutnya; di ujung bawah berubah menjadi "kembali ke atas".
     Disembunyikan otomatis bila halaman tidak bisa digulir. Logika di resources/js/app.js. --}}
<button aria-label="Gulir ke bagian berikutnya" class="fixed right-3 md:right-6 top-1/2 -translate-y-1/2 z-40 hidden w-11 h-11 rounded-full bg-primary text-on-primary shadow-lg ring-1 ring-on-primary/20 items-center justify-center hover:bg-primary-container transition-colors focus:outline-none focus-visible:ring-4 focus-visible:ring-secondary-container" data-tombol-gulir title="Gulir ke bawah" type="button">
<span aria-hidden="true" class="material-symbols-outlined text-[22px] transition-transform" data-ikon-gulir>arrow_downward</span>
</button>