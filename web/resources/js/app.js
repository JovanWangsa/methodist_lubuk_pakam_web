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
