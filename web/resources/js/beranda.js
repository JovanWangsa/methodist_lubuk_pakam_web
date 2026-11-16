// Slider Homepage. Logika disalin dari skrip desain Stitch "Hal. 2: Homepage";
// tombol memakai atribut data-* sebagai pengganti onclick.
(() => {
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide-item');
    const dots = document.querySelectorAll('.slider-dot');
    let slideInterval;

    if (!slides.length) return;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('opacity-0', 'pointer-events-none', 'z-10');
                slide.classList.add('opacity-100', 'z-20');
            } else {
                slide.classList.remove('opacity-100', 'z-20');
                slide.classList.add('opacity-0', 'pointer-events-none', 'z-10');
            }
        });

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-surface-container-lowest/40');
                dot.classList.add('bg-secondary-container', 'w-8');
            } else {
                dot.classList.remove('bg-secondary-container', 'w-8');
                dot.classList.add('bg-surface-container-lowest/40', 'w-3');
            }
        });
        currentSlide = index;
    }

    function resetTimer() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 6000);
    }

    function nextSlide() {
        showSlide((currentSlide + 1) % slides.length);
        resetTimer();
    }

    function prevSlide() {
        showSlide((currentSlide - 1 + slides.length) % slides.length);
        resetTimer();
    }

    document.querySelector('[data-berikutnya]')?.addEventListener('click', nextSlide);
    document.querySelector('[data-sebelumnya]')?.addEventListener('click', prevSlide);
    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            showSlide(parseInt(dot.dataset.ke || '0', 10));
            resetTimer();
        });
    });

    showSlide(0);
    resetTimer();
})();
