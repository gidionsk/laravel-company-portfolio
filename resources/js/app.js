import './bootstrap';

const header = document.querySelector('[data-header]');
const toggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const syncHeader = () => header?.classList.toggle('scrolled', window.scrollY > 16);
window.addEventListener('scroll', syncHeader, { passive: true });
syncHeader();

const closeMobileNav = () => {
    toggle?.setAttribute('aria-expanded', 'false');
    toggle?.classList.remove('active');
    mobileNav?.classList.remove('open');
};

toggle?.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!open));
    toggle.classList.toggle('active', !open);
    mobileNav?.classList.toggle('open', !open);
});

document.querySelectorAll('[data-mobile-nav] a').forEach((link) => link.addEventListener('click', closeMobileNav));

const setupMotion = () => {
    if (reduceMotion || !('IntersectionObserver' in window)) return;

    document.body.classList.add('motion-enabled');

    const revealGroups = [
        '.hero-copy',
        '.hero-visual-stage',
        '.implementation-ledger',
        '.section-heading',
        '.about-copy',
        '.capability-table > div',
        '.section-top > *',
        '.selected-screen',
        '.service-row',
        '.project-card',
        '.process-list article',
        '.contact-copy',
        '.contact-form',
        '.page-hero .container > *',
        '.case-title-grid > *',
        '.case-cover',
        '.case-story article',
        '.case-gallery figure',
    ];

    const revealItems = [...document.querySelectorAll(revealGroups.join(','))];
    revealItems.forEach((item, index) => {
        item.dataset.reveal = '';
        item.style.setProperty('--reveal-delay', `${Math.min(index % 4, 3) * 55}ms`);
    });

    document.querySelectorAll('.implementation-ledger .ledger-row').forEach((row, index) => {
        row.style.setProperty('--ledger-delay', `${120 + index * 55}ms`);
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -7% 0px',
    });

    revealItems.forEach((item) => observer.observe(item));
};

setupMotion();

const filterWrap = document.querySelector('[data-project-filters]');
if (filterWrap) {
    const filterButtons = [...filterWrap.querySelectorAll('[data-filter]')];
    const projectItems = [...document.querySelectorAll('[data-project-item]')];

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            filterButtons.forEach((item) => {
                const selected = item === button;
                item.classList.toggle('active', selected);
                item.setAttribute('aria-pressed', String(selected));
            });
            projectItems.forEach((item) => {
                const visible = filter === 'all' || item.dataset.category === filter;
                item.hidden = !visible;
                if (visible && !reduceMotion) {
                    item.classList.remove('filter-enter');
                    requestAnimationFrame(() => item.classList.add('filter-enter'));
                }
            });
        });
    });
}

const adminMenuButton = document.querySelector('[data-admin-menu]');
const adminSidebar = document.querySelector('.admin-sidebar');
adminMenuButton?.addEventListener('click', () => adminSidebar?.classList.toggle('open'));

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
