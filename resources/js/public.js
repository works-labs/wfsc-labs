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

document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('[data-treatment-tab]');
    const panels = document.querySelectorAll('[data-treatment-panel]');

    if (!tabs.length || !panels.length) {
        return;
    }

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const categoryId = tab.dataset.treatmentTab;

            tabs.forEach((item) => {
                const isActive =
                    item.dataset.treatmentTab === categoryId;

                item.classList.toggle(
                    'border-neutral-900',
                    isActive
                );

                item.classList.toggle(
                    'text-neutral-900',
                    isActive
                );

                item.classList.toggle(
                    'border-transparent',
                    !isActive
                );

                item.classList.toggle(
                    'text-neutral-400',
                    !isActive
                );
            });

            panels.forEach((panel) => {
                panel.classList.toggle(
                    'hidden',
                    panel.dataset.treatmentPanel !== categoryId
                );
            });
        });
    });
});

// Contoh logika perpindahan class pada slider dot:
dots.forEach((dot, idx) => {
    if (idx === activeIndex) {
        dot.classList.add('w-8', 'bg-[#FF5252]');
        dot.classList.remove('w-2', 'bg-neutral-300');
    } else {
        dot.classList.remove('w-8', 'bg-[#FF5252]');
        dot.classList.add('w-2', 'bg-neutral-300');
    }
});