// Skrip panel admin (/admin). Tanpa library, tanpa build.

// Menu samping di layar kecil.
const tombolMenuAdmin = document.querySelectorAll('[data-admin-menu-toggle]');
const menuAdmin = document.querySelector('[data-admin-menu]');

if (menuAdmin) {
    const kelasTerbuka = ['flex', 'flex-col', 'fixed', 'inset-y-0', 'left-0', 'z-40', 'w-72', 'shadow-xl'];

    tombolMenuAdmin.forEach((tombol) => tombol.addEventListener('click', () => {
        const buka = menuAdmin.classList.contains('hidden');
        menuAdmin.classList.toggle('hidden', !buka);
        kelasTerbuka.forEach((k) => menuAdmin.classList.toggle(k, buka));
        tombolMenuAdmin.forEach((t) => t.setAttribute('aria-expanded', String(buka)));
    }));
}

// Konfirmasi sebelum menghapus.
document.querySelectorAll('form[data-konfirmasi]').forEach((form) => {
    form.addEventListener('submit', (e) => {
        if (!window.confirm(form.dataset.konfirmasi)) {
            e.preventDefault();
        }
    });
});

// Pratinjau foto sebelum diunggah.
document.addEventListener('change', (e) => {
    const input = e.target.closest('[data-pratinjau-input]');
    if (!input || !input.files || !input.files[0]) {
        return;
    }

    const wadah = input.closest('.a-kartu, .space-y-1, [data-butir]') || document;
    const img = wadah.querySelector('[data-pratinjau]');
    if (img) {
        img.src = URL.createObjectURL(input.files[0]);
        img.classList.remove('hidden');
    }
});

// Daftar di formulir konten: tambah dan hapus item.
let nomorBaru = Date.now();

const nomori = (daftar) => {
    daftar.querySelectorAll(':scope > [data-daftar-isi] > [data-butir]').forEach((butir, i) => {
        const nomor = butir.querySelector(':scope > div > [data-butir-nomor]');
        if (nomor) {
            nomor.textContent = 'Item ' + (i + 1);
        }
    });
};

document.querySelectorAll('[data-daftar]').forEach(nomori);

document.addEventListener('click', (e) => {
    const tambah = e.target.closest('[data-tambah]');
    if (tambah) {
        const daftar = tambah.closest('[data-daftar]');
        const templat = daftar.querySelector(':scope > [data-templat]');
        const html = templat.innerHTML.split(daftar.dataset.penanda).join(String(nomorBaru++));
        daftar.querySelector(':scope > [data-daftar-isi]').insertAdjacentHTML('beforeend', html);
        nomori(daftar);
        return;
    }

    const hapus = e.target.closest('[data-hapus]');
    if (hapus) {
        const butir = hapus.closest('[data-butir]');
        const daftar = butir.closest('[data-daftar]');
        butir.remove();
        nomori(daftar);
    }
});
