import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import Swiper from 'swiper';
import { Autoplay, Pagination, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.start();

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function aosInit() {
    if (prefersReducedMotion) {
        document.querySelectorAll('[data-aos]').forEach(el => el.style.opacity = '1');
        return;
    }

    const isMobile = window.innerWidth < 768;
    const threshold = isMobile ? 0.1 : 0.2;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const aosType = el.dataset.aos || 'fade-up';
                const aosDelay = parseInt(el.dataset.aosDelay) || 0;
                const aosDuration = parseInt(el.dataset.aosDuration) || 700;

                el.style.animationDuration = aosDuration + 'ms';
                el.style.animationDelay = aosDelay + 'ms';
                el.style.animationFillMode = 'both';
                el.classList.add('aos-animate');

                switch (aosType) {
                    case 'fade-up':
                        el.style.animationName = 'aos-fade-up';
                        break;
                    case 'fade-down':
                        el.style.animationName = 'aos-fade-down';
                        break;
                    case 'fade-right':
                        el.style.animationName = 'aos-fade-right';
                        break;
                    case 'fade-left':
                        el.style.animationName = 'aos-fade-left';
                        break;
                    case 'zoom-in':
                        el.style.animationName = 'aos-zoom-in';
                        break;
                    default:
                        el.style.animationName = 'aos-fade-up';
                }

                observer.unobserve(el);
            }
        });
    }, { threshold, rootMargin: '0px 0px -60px 0px' });

    document.querySelectorAll('[data-aos]').forEach(el => observer.observe(el));
}

if (document.querySelector('.hero-swiper') && !prefersReducedMotion) {
    new Swiper('.hero-swiper', {
        modules: [Autoplay, Pagination, EffectFade],
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        pagination: { el: '.swiper-pagination', clickable: true },
    });
}

if (document.querySelector('.testimonial-swiper') && !prefersReducedMotion) {
    new Swiper('.testimonial-swiper', {
        modules: [Autoplay, Pagination],
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        slidesPerView: 1,
        spaceBetween: 24,
        breakpoints: {
            640:  { slidesPerView: 1 },
            768:  { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
        pagination: { el: '.testimonial-pagination', clickable: true },
    });
}

function animateCounter(el) {
    const target = parseInt(el.dataset.target, 10);
    const suffix = el.dataset.suffix || '';
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        el.textContent = Math.floor(current) + suffix;
    }, 16);
}

const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.dataset.counted) {
            entry.target.dataset.counted = '1';
            animateCounter(entry.target);
        }
    });
    if (entries.some(e => e.isIntersecting)) {
        const remaining = document.querySelectorAll('[data-counter]:not([data-counted])');
        if (!remaining.length) counterObserver.disconnect();
    }
}, { threshold: 0.5 });

if (!prefersReducedMotion) {
    document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));
}

document.querySelectorAll('[data-filter-btn]').forEach(btn => {
    btn.addEventListener('click', () => {
        const filter = btn.dataset.filterBtn;

        document.querySelectorAll('[data-filter-btn]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('[data-filter-item]').forEach(item => {
            if (filter === 'all' || item.dataset.filterItem === filter) {
                item.style.display = '';
                item.classList.remove('animate-fade-in-up');
                void item.offsetWidth;
                item.classList.add('animate-fade-in-up');
            } else {
                item.style.display = 'none';
            }
        });
    });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const href = this.getAttribute('href');
        if (!href || href === '#') return;
        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

const backToTop = document.getElementById('back-to-top');
if (backToTop) {
    window.addEventListener('scroll', () => {
        backToTop.classList.toggle('opacity-0', window.scrollY < 400);
        backToTop.classList.toggle('pointer-events-none', window.scrollY < 400);
    }, { passive: true });
    backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

if (!prefersReducedMotion) {
    const blobs = document.querySelectorAll('.hero-blob');
    const hero = document.querySelector('.hero-section');

    if (hero && blobs.length) {
        hero.addEventListener('mousemove', (e) => {
            requestAnimationFrame(() => {
                const rect = hero.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;

                blobs.forEach((blob, i) => {
                    const speed = 20 + i * 10;
                    blob.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
                });
            });
        }, { passive: true });

        hero.addEventListener('mouseleave', () => {
            blobs.forEach(blob => {
                blob.style.transform = '';
            });
        });
    }
}

if (!prefersReducedMotion) {
    const heroTitle = document.querySelector('.hero-title-animate');
    if (heroTitle) {
        const text = heroTitle.textContent.trim();
        heroTitle.textContent = '';
        const words = text.split(' ');

        words.forEach((word, i) => {
            const span = document.createElement('span');
            span.className = 'hero-word';
            span.style.animationDelay = `${0.3 + i * 0.12}s`;
            span.textContent = word;
            heroTitle.appendChild(span);
            if (i < words.length - 1) {
                heroTitle.appendChild(document.createTextNode('\u00A0'));
            }
        });
    }
}

if (!prefersReducedMotion) {
    document.querySelectorAll('[data-aos-stagger]').forEach((container) => {
        const delay = parseInt(container.dataset.aosStagger) || 100;
        container.querySelectorAll('[data-aos]').forEach((el, i) => {
            el.dataset.aosDelay = i * delay;
        });
    });
}

document.addEventListener('DOMContentLoaded', aosInit);
