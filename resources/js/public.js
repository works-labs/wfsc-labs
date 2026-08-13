const navbar = document.getElementById('public-navbar');

if (navbar) {
    const updateNavbar = () => {
        navbar.classList.toggle(
            'is-scrolled',
            window.scrollY > 40
        );
    };

    updateNavbar();

    window.addEventListener('scroll', updateNavbar, {
        passive: true,
    });
}


/*
|--------------------------------------------------------------------------
| Before After Slider
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    const slider = document.querySelector(
        '[data-before-after-slider]'
    );

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

        if (index < 0) {
            index = slides.length - 1;
        }

        if (index >= slides.length) {
            index = 0;
        }

        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle(
                'hidden',
                slideIndex !== index
            );
        });

        dots.forEach((dot, dotIndex) => {

            const active = dotIndex === index;

            dot.classList.toggle(
                'bg-neutral-900',
                active
            );

            dot.classList.toggle(
                'bg-neutral-300',
                !active
            );

            dot.classList.toggle(
                'scale-125',
                active
            );
        });

        currentIndex = index;
    };

    const nextSlide = () => {
        showSlide(currentIndex + 1);
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

    slider.addEventListener(
        'mouseenter',
        () => clearInterval(interval)
    );

    slider.addEventListener(
        'mouseleave',
        startAutoSlide
    );

    showSlide(0);
    startAutoSlide();
});


/*
|--------------------------------------------------------------------------
| Treatment Tabs
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    const tabs = document.querySelectorAll(
        '[data-treatment-tab]'
    );

    const panels = document.querySelectorAll(
        '[data-treatment-panel]'
    );

    if (!tabs.length || !panels.length) {
        return;
    }

    tabs.forEach((tab) => {

        tab.addEventListener('click', () => {

            const categoryId =
                tab.dataset.treatmentTab;

            tabs.forEach((item) => {

                const active =
                    item.dataset.treatmentTab === categoryId;

                item.classList.toggle(
                    'border-neutral-900',
                    active
                );

                item.classList.toggle(
                    'text-neutral-900',
                    active
                );

                item.classList.toggle(
                    'border-transparent',
                    !active
                );

                item.classList.toggle(
                    'text-neutral-400',
                    !active
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


/*
|--------------------------------------------------------------------------
| Doctor Slider
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    const slider = document.querySelector(
        '[data-doctor-slider]'
    );

    if (!slider) {
        return;
    }

    const slides = Array.from(
        slider.querySelectorAll('[data-doctor-slide]')
    );

    const dots = Array.from(
        slider.querySelectorAll('[data-doctor-dot]')
    );

    const prevButton = slider.querySelector(
        '[data-doctor-prev]'
    );

    const nextButton = slider.querySelector(
        '[data-doctor-next]'
    );

    if (slides.length <= 1) {
        return;
    }

    let currentIndex = 0;

    const showSlide = (index) => {

        if (index < 0) {
            index = slides.length - 1;
        }

        if (index >= slides.length) {
            index = 0;
        }

        slides.forEach((slide, slideIndex) => {

            slide.classList.toggle(
                'hidden',
                slideIndex !== index
            );

        });

        dots.forEach((dot, dotIndex) => {

            const active =
                dotIndex === index;

            dot.classList.toggle(
                'w-8',
                active
            );

            dot.classList.toggle(
                'w-2',
                !active
            );

            dot.classList.toggle(
                'bg-[#FF5252]',
                active
            );

            dot.classList.toggle(
                'bg-neutral-300',
                !active
            );

        });

        currentIndex = index;
    };

    if (prevButton) {
        prevButton.addEventListener('click', () => {
            showSlide(currentIndex - 1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', () => {
            showSlide(currentIndex + 1);
        });
    }

    dots.forEach((dot, index) => {

        dot.addEventListener('click', () => {
            showSlide(index);
        });

    });

    showSlide(0);
});


/*
|--------------------------------------------------------------------------
| News Slider
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    const slider = document.querySelector(
        '[data-news-slider]'
    );

    if (!slider) {
        return;
    }

    const slides = Array.from(
        slider.querySelectorAll('[data-news-slide]')
    );

    const dots = Array.from(
        slider.querySelectorAll('[data-news-dot]')
    );

    const prevButton = slider.querySelector(
        '[data-news-prev]'
    );

    const nextButton = slider.querySelector(
        '[data-news-next]'
    );

    if (slides.length <= 1) {
        return;
    }

    let currentIndex = 0;

    const showSlide = (index) => {

        if (index < 0) {
            index = slides.length - 1;
        }

        if (index >= slides.length) {
            index = 0;
        }

        slides.forEach((slide, slideIndex) => {

            slide.classList.toggle(
                'hidden',
                slideIndex !== index
            );

        });

        dots.forEach((dot, dotIndex) => {

            const active =
                dotIndex === index;

            dot.classList.toggle(
                'w-8',
                active
            );

            dot.classList.toggle(
                'w-2',
                !active
            );

            dot.classList.toggle(
                'bg-[#FF5252]',
                active
            );

            dot.classList.toggle(
                'bg-neutral-300',
                !active
            );

        });

        currentIndex = index;
    };

    if (prevButton) {
        prevButton.addEventListener('click', () => {
            showSlide(currentIndex - 1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', () => {
            showSlide(currentIndex + 1);
        });
    }

    dots.forEach((dot, index) => {

        dot.addEventListener('click', () => {
            showSlide(index);
        });

    });

    showSlide(0);
});