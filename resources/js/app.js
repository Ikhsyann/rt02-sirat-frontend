
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Tombol hamburger: toggle menu mobile, tutup otomatis saat link di klik
document.addEventListener('click', (e) => {
    const toggle = e.target.closest('#nav-toggle');
    if (toggle) {
        document.querySelectorAll('[data-menu]').forEach((menu) => menu.classList.toggle('hidden'));
        return;
    }
    if (e.target.closest('[data-menu] a')) {
        document.querySelectorAll('[data-menu]').forEach((menu) => menu.classList.add('hidden'));
        return;
    }

    // Tombol carousel: geser kontainer scroll (snap) satu halaman kartu
    const slide = e.target.closest('[data-scroll-left], [data-scroll-right]');
    if (slide) {
        const box = document.querySelector(slide.dataset.scrollTarget);
        if (box) box.scrollBy({ left: slide.hasAttribute('data-scroll-left') ? -340 : 340, behavior: 'smooth' });
        return;
    }

    // Kartu arsip utuh klik-able; tautan di dalamnya tetap diutamakan
    const card = e.target.closest('[data-card-link]');
    if (card && !e.target.closest('a')) window.location.href = card.dataset.cardLink;
});
