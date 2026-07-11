document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            const open = mobileMenu.classList.toggle('hidden') === false;
            menuToggle.setAttribute('aria-expanded', String(open));
            menuToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        });
    }

    initCollectionMega();
    initSearchOverlay();
    initHeroSlider();
});

function initSearchOverlay() {
    const overlay = document.querySelector('[data-search-overlay]');
    const openBtns = document.querySelectorAll('[data-search-open]');
    const closeEls = document.querySelectorAll('[data-search-close]');
    const input = document.querySelector('[data-search-input]');

    if (!overlay) return;

    const preventScroll = (e) => {
        e.preventDefault();
    };

    const open = () => {
        overlay.hidden = false;
        // Force reflow so slide-in animation runs
        void overlay.offsetHeight;
        overlay.classList.add('is-open');
        input?.focus({ preventScroll: true });
        overlay.addEventListener('wheel', preventScroll, { passive: false });
        overlay.addEventListener('touchmove', preventScroll, { passive: false });
    };

    const close = () => {
        overlay.classList.remove('is-open');
        overlay.removeEventListener('wheel', preventScroll);
        overlay.removeEventListener('touchmove', preventScroll);
        input?.blur();

        const onEnd = (e) => {
            if (e.target !== overlay.querySelector('.search-overlay-panel')) return;
            overlay.hidden = true;
            overlay.removeEventListener('transitionend', onEnd);
        };
        overlay.addEventListener('transitionend', onEnd);
        setTimeout(() => {
            if (!overlay.classList.contains('is-open')) overlay.hidden = true;
        }, 320);
    };

    openBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            open();
        });
    });

    closeEls.forEach((el) => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            close();
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) close();
    });
}

function initCollectionMega() {
    const nav = document.querySelector('[data-collection-nav]');
    const mega = document.querySelector('[data-collection-mega]');
    const toggle = document.querySelector('[data-collection-toggle]');

    if (!nav || !mega || !toggle) return;

    const open = () => {
        mega.hidden = false;
        nav.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
    };

    const close = () => {
        mega.hidden = true;
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (mega.hidden) open();
        else close();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });

    document.addEventListener('click', (e) => {
        if (!nav.contains(e.target) && !mega.contains(e.target)) close();
    });
}

function initHeroSlider() {
    const root = document.querySelector('[data-hero-slider]');
    if (!root) return;

    const slides = Array.from(document.querySelectorAll('[data-slide]'));
    const dots = Array.from(document.querySelectorAll('[data-hero-dot]'));
    const prevBtn = document.querySelector('[data-hero-prev]');
    const nextBtn = document.querySelector('[data-hero-next]');
    const playBtn = document.querySelector('[data-hero-play]');
    const playIcon = playBtn?.querySelector('.play-icon');
    const pauseIcon = playBtn?.querySelector('.pause-icon');

    let index = 0;
    let playing = true;
    let timer = null;

    const show = (next) => {
        index = (next + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            slide.classList.toggle('is-active', i === index);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('is-active', i === index);
        });
    };

    const stop = () => {
        playing = false;
        if (timer) clearInterval(timer);
        timer = null;
        playBtn?.setAttribute('aria-label', 'Play slideshow');
        playBtn?.setAttribute('aria-pressed', 'true');
        playIcon?.classList.remove('hidden');
        pauseIcon?.classList.add('hidden');
    };

    const start = () => {
        playing = true;
        if (timer) clearInterval(timer);
        timer = setInterval(() => show(index + 1), 5000);
        playBtn?.setAttribute('aria-label', 'Pause slideshow');
        playBtn?.setAttribute('aria-pressed', 'false');
        playIcon?.classList.add('hidden');
        pauseIcon?.classList.remove('hidden');
    };

    prevBtn?.addEventListener('click', () => {
        show(index - 1);
        if (playing) start();
    });

    nextBtn?.addEventListener('click', () => {
        show(index + 1);
        if (playing) start();
    });

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            show(Number(dot.dataset.heroDot));
            if (playing) start();
        });
    });

    playBtn?.addEventListener('click', () => {
        if (playing) stop();
        else start();
    });

    show(0);
    start();
}
