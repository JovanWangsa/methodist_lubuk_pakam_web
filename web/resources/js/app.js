// Tombol menu di layar di bawah 1280 px (menu atas desain Stitch hanya tampil mulai 1280 px).
const tombolMenu = document.querySelector('[data-menu-toggle]');
const panelMenu = document.querySelector('[data-menu-panel]');

if (tombolMenu && panelMenu) {
    tombolMenu.addEventListener('click', () => {
        const terbuka = tombolMenu.getAttribute('aria-expanded') === 'true';
        tombolMenu.setAttribute('aria-expanded', String(!terbuka));
        panelMenu.hidden = terbuka;
    });
}

// Tombol gulir di sisi kanan: pindah ke bagian (section/footer) berikutnya, dan kembali ke atas di ujung halaman.
const tombolGulir = document.querySelector('[data-tombol-gulir]');

if (tombolGulir) {
    const ikonGulir = tombolGulir.querySelector('[data-ikon-gulir]');
    const geraknya = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
    const tinggiHeader = () => document.querySelector('header')?.offsetHeight ?? 0;
    const diUjungBawah = () => window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 8;

    const perbarui = () => {
        const bisaDigulir = document.documentElement.scrollHeight > window.innerHeight + 8;
        tombolGulir.classList.toggle('hidden', !bisaDigulir);
        tombolGulir.classList.toggle('flex', bisaDigulir);

        const keAtas = diUjungBawah();
        ikonGulir.classList.toggle('rotate-180', keAtas);
        tombolGulir.setAttribute('aria-label', keAtas ? 'Kembali ke atas' : 'Gulir ke bagian berikutnya');
        tombolGulir.title = keAtas ? 'Kembali ke atas' : 'Gulir ke bawah';
    };

    tombolGulir.addEventListener('click', () => {
        if (diUjungBawah()) {
            window.scrollTo({ top: 0, behavior: geraknya });
            return;
        }

        const batas = tinggiHeader() + 8;
        const berikutnya = [...document.querySelectorAll('main section, footer')]
            .find((el) => el.getBoundingClientRect().top > batas && el.offsetHeight > 0);
        const tujuan = berikutnya
            ? window.scrollY + berikutnya.getBoundingClientRect().top - tinggiHeader()
            : window.scrollY + window.innerHeight * 0.85;

        window.scrollTo({ top: tujuan, behavior: geraknya });
    });

    window.addEventListener('scroll', perbarui, { passive: true });
    window.addEventListener('resize', perbarui);
    window.addEventListener('load', perbarui);
    perbarui();
}