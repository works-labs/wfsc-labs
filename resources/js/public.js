const navbar = document.getElementById('public-navbar');

if (navbar) {
    const updateNavbar = () => {
        navbar.classList.toggle('is-scrolled', window.scrollY > 40);
    };

    updateNavbar();

    window.addEventListener('scroll', updateNavbar, {
        passive: true,
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('[data-before-after-slider]');

    if (!slider) {
        return;
    }

    const slides = slider.querySelectorAll('[data-before-after-slide]');
    const dots = slider.querySelectorAll('[data-before-after-dot]');

    if (slides.length <= 1) {
        return;
    }

    let currentIndex = 0;
    let interval;

    const showSlide = (index) => {
        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('hidden', slideIndex !== index);
        });

        dots.forEach((dot, dotIndex) => {
            dot.classList.toggle('scale-125', dotIndex === index);
            dot.classList.toggle('bg-neutral-900', dotIndex === index);
            dot.classList.toggle('bg-neutral-300', dotIndex !== index);
        });

        currentIndex = index;
    };

    const nextSlide = () => {
        const nextIndex = (currentIndex + 1) % slides.length;

        showSlide(nextIndex);
    };

    const startAutoSlide = () => {
        interval = setInterval(nextSlide, 5000);
    };

    const stopAutoSlide = () => {
        clearInterval(interval);
    };

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);

            stopAutoSlide();
            startAutoSlide();
        });
    });

    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);

    showSlide(0);
    startAutoSlide();
});
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('[data-before-after-slider]');

    if (!slider) {
        return;
    }

    const slides = Array.from(
        slider.querySelectorAll('[data-before-after-slide]')
    );

    const dots = Array.from(
        slider.querySelectorAll('[data-before-after-dot]')
    );

    if (slides.length <= 1) {
        return;
    }

    let currentIndex = 0;
    let interval = null;

    const showSlide = (index) => {
        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle(
                'hidden',
                slideIndex !== index
            );
        });

        dots.forEach((dot, dotIndex) => {
            dot.classList.toggle(
                'bg-neutral-900',
                dotIndex === index
            );

            dot.classList.toggle(
                'bg-neutral-300',
                dotIndex !== index
            );

            dot.classList.toggle(
                'scale-125',
                dotIndex === index
            );
        });

        currentIndex = index;
    };

    const nextSlide = () => {
        showSlide(
            (currentIndex + 1) % slides.length
        );
    };

    const startAutoSlide = () => {
        clearInterval(interval);

        interval = setInterval(
            nextSlide,
            5000
        );
    };

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            startAutoSlide();
        });
    });

    showSlide(0);
    startAutoSlide();
});