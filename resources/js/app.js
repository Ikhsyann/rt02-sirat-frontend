
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

// Sorotan menu: rute dari server, lalu bagian halaman di halaman beranda
(() => {
    const links = [...document.querySelectorAll('[data-nav]')];
    if (!links.length) return;

    // Satu bagian bisa punya dua tautan (desktop & mobile); aktifkan semuanya.
    const sections = [...new Map(
        links
            .filter((link) => link.dataset.navSection)
            .map((link) => [link.dataset.navSection, document.getElementById(link.dataset.navSection)])
    ).entries()]
        .filter(([, el]) => el)
        // Urut posisi di halaman, bukan urutan menu: bagian paling bawah yang menang
        .sort((a, b) => a[1].getBoundingClientRect().top - b[1].getBoundingClientRect().top);

    // Sorotan bawaan dari rute yang sedang dibuka
    const routeActive = links.filter((link) => link.classList.contains('is-active'));

    const apply = (section) => {
        links.forEach((link) => {
            const isActive = section
                ? link.dataset.navSection === section
                : routeActive.includes(link);
            link.classList.toggle('is-active', isActive);
        });
    };

    // Bagian terakhir yang tepinya sudah melewati garis bawah navbar dianggap aktif
    const syncToScroll = () => {
        let current = null;
        sections.forEach(([id, el]) => {
            if (el.getBoundingClientRect().top <= 140) current = id;
        });
        apply(current);
    };

    links.forEach((link) => link.addEventListener('click', () => apply(link.dataset.navSection || null)));

    window.addEventListener('scroll', syncToScroll, { passive: true });
    window.addEventListener('hashchange', syncToScroll);
    syncToScroll();
})();
