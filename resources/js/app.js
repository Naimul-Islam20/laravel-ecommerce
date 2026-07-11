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
    initProductDetail();
    initCollectionFilters();
});

function initCollectionFilters() {
    const form = document.querySelector('[data-collection-filters]');
    if (!form) return;

    const dropdowns = form.querySelectorAll('[data-filter-dropdown]');

    dropdowns.forEach((dropdown) => {
        const toggle = dropdown.querySelector('[data-filter-toggle]');
        const menu = dropdown.querySelector('[data-filter-menu]');
        if (!toggle || !menu) return;

        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const willOpen = !dropdown.classList.contains('is-open');

            dropdowns.forEach((item) => {
                item.classList.remove('is-open');
                item.querySelector('[data-filter-toggle]')?.setAttribute('aria-expanded', 'false');
                const itemMenu = item.querySelector('[data-filter-menu]');
                if (itemMenu) itemMenu.hidden = true;
            });

            if (willOpen) {
                dropdown.classList.add('is-open');
                toggle.setAttribute('aria-expanded', 'true');
                menu.hidden = false;
            }
        });
    });

    form.querySelectorAll('input[type="radio"]').forEach((input) => {
        input.addEventListener('change', () => form.submit());
    });

    document.addEventListener('click', (e) => {
        if (e.target.closest('[data-filter-dropdown]')) return;
        dropdowns.forEach((item) => {
            item.classList.remove('is-open');
            item.querySelector('[data-filter-toggle]')?.setAttribute('aria-expanded', 'false');
            const itemMenu = item.querySelector('[data-filter-menu]');
            if (itemMenu) itemMenu.hidden = true;
        });
    });
}

function initProductDetail() {
    const root = document.querySelector('[data-product-detail]');
    if (!root) return;

    const priceEl = root.querySelector('[data-product-price]');
    const packBtns = root.querySelectorAll('[data-product-pack]');
    const qtyInput = root.querySelector('[data-qty-input]');
    const minusBtn = root.querySelector('[data-qty-minus]');
    const plusBtn = root.querySelector('[data-qty-plus]');
    const mainImage = root.querySelector('[data-product-main-image]');
    const thumbs = root.querySelectorAll('[data-product-thumb]');

    const setQty = (value) => {
        const next = Math.max(1, Number(value) || 1);
        qtyInput.value = String(next);
    };

    minusBtn?.addEventListener('click', () => setQty(Number(qtyInput.value) - 1));
    plusBtn?.addEventListener('click', () => setQty(Number(qtyInput.value) + 1));
    qtyInput?.addEventListener('change', () => setQty(qtyInput.value));

    packBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            packBtns.forEach((item) => item.classList.remove('is-active'));
            btn.classList.add('is-active');
            if (priceEl && btn.dataset.priceLabel) {
                priceEl.textContent = btn.dataset.priceLabel;
            }
        });
    });

    thumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => {
            const src = thumb.dataset.image;
            if (!src || !mainImage || mainImage.tagName !== 'IMG') return;
            mainImage.src = src;
            thumbs.forEach((item) => item.classList.remove('is-active'));
            thumb.classList.add('is-active');
        });
    });

    const zoomBtn = root.querySelector('[data-product-zoom]');
    const lightbox = document.querySelector('[data-product-lightbox]');
    const lightboxImage = lightbox?.querySelector('[data-product-lightbox-image]');
    const lightboxPlaceholder = lightbox?.querySelector('[data-product-lightbox-placeholder]');
    const lightboxClose = lightbox?.querySelectorAll('[data-product-lightbox-close]');

    const openLightbox = () => {
        if (!lightbox) return;

        const hasImage = mainImage?.tagName === 'IMG' && mainImage.getAttribute('src');

        if (hasImage && lightboxImage) {
            lightboxImage.hidden = false;
            lightboxImage.src = mainImage.src;
            lightboxImage.alt = mainImage.alt || '';
            if (lightboxPlaceholder) lightboxPlaceholder.hidden = true;
        } else {
            if (lightboxImage) {
                lightboxImage.hidden = true;
                lightboxImage.removeAttribute('src');
            }
            if (lightboxPlaceholder) lightboxPlaceholder.hidden = false;
        }

        lightbox.hidden = false;
        document.body.classList.add('product-lightbox-open');
        requestAnimationFrame(() => lightbox.classList.add('is-open'));
    };

    const closeLightbox = () => {
        if (!lightbox) return;
        lightbox.classList.remove('is-open');
        document.body.classList.remove('product-lightbox-open');
        const onEnd = () => {
            lightbox.hidden = true;
            lightbox.removeEventListener('transitionend', onEnd);
        };
        lightbox.addEventListener('transitionend', onEnd);
        setTimeout(() => {
            if (!lightbox.classList.contains('is-open')) lightbox.hidden = true;
        }, 280);
    };

    zoomBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        openLightbox();
    });

    const galleryMain = root.querySelector('.product-gallery-main');
    galleryMain?.addEventListener('click', (e) => {
        if (e.target.closest('[data-product-zoom]')) return;
        openLightbox();
    });
    galleryMain?.style.setProperty('cursor', 'zoom-in');

    const accordion = root.querySelector('[data-product-accordion]');
    const accordionTrigger = accordion?.querySelector('[data-accordion-trigger]');
    const accordionPanel = accordion?.querySelector('[data-accordion-panel]');

    accordionTrigger?.addEventListener('click', () => {
        const isOpen = accordion.classList.toggle('is-open');
        accordionTrigger.setAttribute('aria-expanded', String(isOpen));
        accordionPanel.hidden = !isOpen;
    });

    lightboxClose?.forEach((el) => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            closeLightbox();
        });
    });

    lightbox?.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox?.classList.contains('is-open')) {
            closeLightbox();
        }
    });
}
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
