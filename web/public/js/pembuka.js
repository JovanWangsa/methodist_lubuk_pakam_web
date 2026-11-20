// Slider Halaman 1. Logika disalin dari skrip desain Stitch "Hal. 1: Home Splash";
// judul slide diambil dari atribut data-judul (berasal dari database), bukan ditulis di kode.
(() => {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const numDisplay = document.getElementById('slide-num');
    const titleDisplay = document.getElementById('slide-title');
    const prevBtn = document.getElementById('prev-slide');
    const nextBtn = document.getElementById('next-slide');

    if (!slides.length) return;

    const titles = [...slides].map((s) => s.dataset.judul || '');

    let current = 0;
    const total = slides.length;
    let timer = null;

    function showSlide(index) {
        slides[current].classList.remove('opacity-100');
        slides[current].classList.add('opacity-0', 'pointer-events-none');
        dots[current].classList.remove('w-6', 'bg-secondary-fixed');
        dots[current].classList.add('w-2', 'bg-surface-container-lowest/30');

        current = (index + total) % total;

        slides[current].classList.remove('opacity-0', 'pointer-events-none');
        slides[current].classList.add('opacity-100');
        dots[current].classList.remove('w-2', 'bg-surface-container-lowest/30');
        dots[current].classList.add('w-6', 'bg-secondary-fixed');

        if (numDisplay) {
            numDisplay.textContent = String(current + 1).padStart(2, '0');
        }
        if (titleDisplay) {
            titleDisplay.textContent = titles[current] || '';
        }
    }

    function next() { showSlide(current + 1); }
    function prev() { showSlide(current - 1); }

    function resetTimer() {
        if (timer) clearInterval(timer);
        timer = setInterval(next, 5000);
    }

    if (nextBtn) nextBtn.addEventListener('click', () => { next(); resetTimer(); });
    if (prevBtn) prevBtn.addEventListener('click', () => { prev(); resetTimer(); });

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const idx = parseInt(dot.getAttribute('data-index') || '0', 10);
            showSlide(idx);
            resetTimer();
        });
    });

    resetTimer();
})();
