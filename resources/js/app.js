import './bootstrap';

const header = document.querySelector('[data-header]');
const toggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const progress = document.querySelector('[data-scroll-progress]');

const handleScroll = () => {
    header?.classList.toggle('scrolled', window.scrollY > 24);
    if (progress) {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        progress.style.width = `${max > 0 ? (window.scrollY / max) * 100 : 0}%`;
    }
};

window.addEventListener('scroll', handleScroll, { passive: true });
handleScroll();

toggle?.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!open));
    toggle.classList.toggle('active');
    mobileNav?.classList.toggle('open');
});

document.querySelectorAll('[data-mobile-nav] a').forEach((link) => {
    link.addEventListener('click', () => {
        toggle?.setAttribute('aria-expanded', 'false');
        toggle?.classList.remove('active');
        mobileNav?.classList.remove('open');
    });
});

if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));
} else {
    document.querySelectorAll('.reveal').forEach((element) => element.classList.add('visible'));
}

// Subtle product-window tilt. Disabled for coarse pointers / reduced motion.
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const coarsePointer = window.matchMedia('(pointer: coarse)').matches;
if (!reducedMotion && !coarsePointer) {
    document.querySelectorAll('[data-tilt]').forEach((wrap) => {
        const card = wrap.querySelector('.product-window');
        if (!card) return;
        wrap.addEventListener('mousemove', (event) => {
            const rect = wrap.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width - 0.5;
            const y = (event.clientY - rect.top) / rect.height - 0.5;
            card.style.transform = `rotateY(${x * 8 - 4}deg) rotateX(${y * -6 + 2}deg) translateY(-2px)`;
        });
        wrap.addEventListener('mouseleave', () => {
            card.style.transform = 'rotateY(-4deg) rotateX(2deg)';
        });
    });
}

// Spotlight on service cards.
document.querySelectorAll('[data-spotlight]').forEach((card) => {
    card.addEventListener('pointermove', (event) => {
        const rect = card.getBoundingClientRect();
        card.style.setProperty('--spot-x', `${event.clientX - rect.left}px`);
        card.style.setProperty('--spot-y', `${event.clientY - rect.top}px`);
    });
});

// Project archive filters are intentionally client-side so pagination still works normally.
const filterWrap = document.querySelector('[data-project-filters]');
if (filterWrap) {
    const filterButtons = [...filterWrap.querySelectorAll('[data-filter]')];
    const projectItems = [...document.querySelectorAll('[data-project-item]')];
    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            filterButtons.forEach((item) => item.classList.toggle('active', item === button));
            projectItems.forEach((item) => {
                item.classList.toggle('hidden', filter !== 'all' && item.dataset.category !== filter);
            });
        });
    });
}

// Testimonial slider.
const testimonialSlider = document.querySelector('[data-testimonial-slider]');
if (testimonialSlider) {
    const slides = [...testimonialSlider.querySelectorAll('[data-testimonial-slide]')];
    const dots = [...testimonialSlider.querySelectorAll('[data-testimonial-dot]')];
    const prev = testimonialSlider.querySelector('[data-testimonial-prev]');
    const next = testimonialSlider.querySelector('[data-testimonial-next]');
    let index = 0;
    let timer;

    const show = (target) => {
        if (!slides.length) return;
        index = (target + slides.length) % slides.length;
        slides.forEach((slide, slideIndex) => slide.classList.toggle('active', slideIndex === index));
        dots.forEach((dot, dotIndex) => dot.classList.toggle('active', dotIndex === index));
    };
    const restart = () => {
        if (reducedMotion || slides.length < 2) return;
        window.clearInterval(timer);
        timer = window.setInterval(() => show(index + 1), 6500);
    };

    prev?.addEventListener('click', () => { show(index - 1); restart(); });
    next?.addEventListener('click', () => { show(index + 1); restart(); });
    dots.forEach((dot) => dot.addEventListener('click', () => { show(Number(dot.dataset.testimonialDot)); restart(); }));
    restart();
}

// Admin mobile menu.
const adminMenuButton = document.querySelector('[data-admin-menu]');
const adminSidebar = document.querySelector('.admin-sidebar');
adminMenuButton?.addEventListener('click', () => adminSidebar?.classList.toggle('open'));

// Keep text HEX input and color input in sync, and update theme preview live.
const colorPickers = [...document.querySelectorAll('[data-color-picker]')];
const colorTexts = [...document.querySelectorAll('[data-color-text]')];
const preview = document.querySelector('.theme-preview-card');

colorPickers.forEach((picker, index) => {
    const text = colorTexts[index];
    picker.addEventListener('input', () => {
        if (text) text.value = picker.value;
        if (preview) preview.style.setProperty(index === 0 ? '--preview-a' : '--preview-b', picker.value);
    });
});
colorTexts.forEach((text, index) => {
    text.addEventListener('input', () => {
        if (/^#[0-9A-Fa-f]{6}$/.test(text.value)) {
            if (colorPickers[index]) colorPickers[index].value = text.value;
            if (preview) preview.style.setProperty(index === 0 ? '--preview-a' : '--preview-b', text.value);
        }
    });
});
