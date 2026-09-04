document.addEventListener('DOMContentLoaded', () => {

    const initScrollReveal = () => {
        const revealElements = document.querySelectorAll('[data-reveal]');
        if (!revealElements.length) return;

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -50px 0px',
            threshold: 0.15
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const delay = el.dataset.delay || 0;
                    const animationType = el.dataset.reveal;

                    if (animationType === 'left') el.classList.add('reveal-left');
                    if (animationType === 'right') el.classList.add('reveal-right');
                    if (animationType === 'zoom') el.classList.add('reveal-zoom');

                    setTimeout(() => {
                        el.classList.add('reveal-show');
                    }, delay);

                    observer.unobserve(el);
                }
            });
        }, observerOptions);

        revealElements.forEach(el => observer.observe(el));
    };

    /*
    |--------------------------------------------------------------------------
    | 1. Navbar Scroll Effect
    |--------------------------------------------------------------------------
    */
    const navbar = document.getElementById('public-navbar');
    if (navbar) {
        const updateNavbar = () => navbar.classList.toggle('is-scrolled', window.scrollY > 40);
        updateNavbar();
        window.addEventListener('scroll', updateNavbar, { passive: true });
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Treatment Category Tabs
    |--------------------------------------------------------------------------
    */
    const tabs = document.querySelectorAll('[data-treatment-tab]');
    const panels = document.querySelectorAll('[data-treatment-panel]');
    
    if (tabs.length && panels.length) {
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const categoryId = tab.dataset.treatmentTab;
                tabs.forEach(item => {
                    const active = item.dataset.treatmentTab === categoryId;
                    item.classList.toggle('border-neutral-900', active);
                    item.classList.toggle('text-neutral-900', active);
                    item.classList.toggle('border-transparent', !active);
                    item.classList.toggle('text-neutral-400', !active);
                });
                panels.forEach(panel => {
                    panel.classList.toggle('hidden', panel.dataset.treatmentPanel !== categoryId);
                });
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Fade / Chunk Switcher Slider Class (Facility, dll)
    |--------------------------------------------------------------------------
    */
    class FadeSlider {
        constructor(prefix, options = {}) {
            this.slider = document.querySelector(`[data-${prefix}-slider]`);
            if (!this.slider) return;

            this.slides = Array.from(this.slider.querySelectorAll(`[data-${prefix}-slide]`));
            this.dots = Array.from(this.slider.querySelectorAll(`[data-${prefix}-dot]`));
            this.prevButton = this.slider.querySelector(`[data-${prefix}-prev]`);
            this.nextButton = this.slider.querySelector(`[data-${prefix}-next]`);
            
            this.autoSlide = options.autoSlide || false;
            this.activeDotClass = options.activeDotClass || 'bg-[#FF5252]';
            this.inactiveDotClass = options.inactiveDotClass || 'bg-neutral-300';
            
            if (this.slides.length <= 1) return;

            this.currentIndex = 0;
            this.interval = null;
            this.init();
        }

        showSlide(index) {
            if (index < 0) index = this.slides.length - 1;
            if (index >= this.slides.length) index = 0;

            this.slides.forEach((slide, i) => slide.classList.toggle('hidden', i !== index));

            this.dots.forEach((dot, i) => {
                const active = i === index;
                dot.classList.toggle('w-8', active && dot.dataset.dotType !== 'scale');
                dot.classList.toggle('w-2', !active && dot.dataset.dotType !== 'scale');
                dot.classList.toggle('scale-125', active && dot.dataset.dotType === 'scale');
                
                dot.classList.toggle(this.activeDotClass, active);
                dot.classList.toggle(this.inactiveDotClass, !active);
            });

            this.currentIndex = index;
        }

        startAutoSlide() {
            if (!this.autoSlide) return;
            clearInterval(this.interval);
            this.interval = setInterval(() => this.showSlide(this.currentIndex + 1), 5000);
        }

        init() {
            if (this.prevButton) {
                this.prevButton.addEventListener('click', () => {
                    this.showSlide(this.currentIndex - 1);
                    this.startAutoSlide();
                });
            }

            if (this.nextButton) {
                this.nextButton.addEventListener('click', () => {
                    this.showSlide(this.currentIndex + 1);
                    this.startAutoSlide();
                });
            }

            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    this.showSlide(index);
                    this.startAutoSlide();
                });
            });

            if (this.autoSlide) {
                this.slider.addEventListener('mouseenter', () => clearInterval(this.interval));
                this.slider.addEventListener('mouseleave', () => this.startAutoSlide());
            }

            this.showSlide(0);
            this.startAutoSlide();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 4. Track Carousel Slider Class (Dengan Fitur Center Scale Focus)
    |--------------------------------------------------------------------------
    */
    class TrackSlider {
        constructor(prefix, options = {}) {
            this.prefix = prefix;
            this.slider = document.querySelector(`[data-${prefix}-slider]`);
            if (!this.slider) return;

            this.track = this.slider.querySelector(`[data-${prefix}-track]`);
            this.slides = Array.from(this.slider.querySelectorAll(`[data-${prefix}-slide]`));
            
            this.prevButton = document.querySelector(`[data-${prefix}-prev]`);
            this.nextButton = document.querySelector(`[data-${prefix}-next]`);
            this.dotsContainer = document.querySelector(`[data-${prefix}-dots]`);
            
            this.breakpoints = options.breakpoints || { lg: 3, sm: 2, default: 1 };
            this.autoSlide = options.autoSlide || false;
            this.autoSlideInterval = options.interval || 3000;
            this.centerScale = options.centerScale || false; // Opsi untuk mengaktifkan efek menonjol di tengah

            if (!this.track || !this.slides.length) return;

            this.currentIndex = 0;
            this.interval = null;
            this.init();
        }

        getVisibleSlides() {
            if (window.innerWidth >= 1024) return this.breakpoints.lg;
            if (window.innerWidth >= 640) return this.breakpoints.sm;
            return this.breakpoints.default;
        }

        getMaxIndex() {
            return Math.max(this.slides.length - this.getVisibleSlides(), 0);
        }

        createDots() {
            if (!this.dotsContainer) return;
            this.dotsContainer.innerHTML = '';
            const maxIndex = this.getMaxIndex();

            for (let i = 0; i <= maxIndex; i++) {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'h-2 w-2 rounded-full bg-neutral-300 transition-all duration-300';
                dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                dot.addEventListener('click', () => {
                    this.currentIndex = i;
                    this.updateSlider();
                    this.startAutoSlide();
                });
                this.dotsContainer.appendChild(dot);
            }
        }

        updateCenterFocus() {
    if (!this.centerScale) return;
    const visible = this.getVisibleSlides();

    this.slides.forEach((slide, index) => {
        // Ambil elemen pembungkus kartu (.doctor-card-inner)
        const cardInner = slide.querySelector('.doctor-card-inner') || slide.firstElementChild;
        if (!cardInner) return;

        let isCenter = false;

        if (visible === 3) {
            isCenter = (index === this.currentIndex + 1); // Kartu tengah pada layar desktop
        } else if (visible === 1) {
            isCenter = (index === this.currentIndex); // Kartu utama pada layar mobile
        }

        if (isCenter) {
            // Kartu tengah membesar penuh
            cardInner.classList.remove('scale-90');
            cardInner.classList.add('scale-105');
        } else {
            // Kartu pinggir tetap 100% jelas (tanpa opacity), hanya ukurannya sedikit lebih kecil
            cardInner.classList.remove('scale-105');
            cardInner.classList.add('scale-90');
        }
    });
}

        updateSlider() {
            const visibleSlides = this.getVisibleSlides();
            const maxIndex = this.getMaxIndex();

            if (this.currentIndex > maxIndex) {
                this.currentIndex = 0;
            }
            if (this.currentIndex < 0) {
                this.currentIndex = maxIndex;
            }

            const slideWidth = 100 / visibleSlides;
            this.track.style.transform = `translateX(-${this.currentIndex * slideWidth}%)`;

            // Update status tombol prev/next
            if (this.prevButton) this.prevButton.disabled = (this.currentIndex === 0 && !this.autoSlide);
            if (this.nextButton) this.nextButton.disabled = (this.currentIndex >= maxIndex && !this.autoSlide);

            // Update status dot aktif
            if (this.dotsContainer) {
                Array.from(this.dotsContainer.children).forEach((dot, index) => {
                    const active = index === this.currentIndex;
                    dot.classList.toggle('w-8', active);
                    dot.classList.toggle('w-2', !active);
                    dot.classList.toggle('bg-[#FF5252]', active);
                    dot.classList.toggle('bg-neutral-300', !active);
                });
            }

            // Jalankan penyesuaian skala kartu tengah
            this.updateCenterFocus();
        }

        startAutoSlide() {
            if (!this.autoSlide) return;
            clearInterval(this.interval);
            this.interval = setInterval(() => {
                const maxIndex = this.getMaxIndex();
                if (this.currentIndex >= maxIndex) {
                    this.currentIndex = 0;
                } else {
                    this.currentIndex++;
                }
                this.updateSlider();
            }, this.autoSlideInterval);
        }

        stopAutoSlide() {
            if (this.interval) clearInterval(this.interval);
        }

        init() {
            if (this.prevButton) {
                this.prevButton.addEventListener('click', () => {
                    const maxIndex = this.getMaxIndex();
                    this.currentIndex = this.currentIndex <= 0 ? maxIndex : this.currentIndex - 1;
                    this.updateSlider();
                    this.startAutoSlide();
                });
            }

            if (this.nextButton) {
                this.nextButton.addEventListener('click', () => {
                    const maxIndex = this.getMaxIndex();
                    this.currentIndex = this.currentIndex >= maxIndex ? 0 : this.currentIndex + 1;
                    this.updateSlider();
                    this.startAutoSlide();
                });
            }

            if (this.autoSlide) {
                const wrapper = this.slider.parentElement || this.slider;
                wrapper.addEventListener('mouseenter', () => this.stopAutoSlide());
                wrapper.addEventListener('mouseleave', () => this.startAutoSlide());
            }

            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    this.createDots();
                    this.updateSlider();
                }, 150);
            });

            this.createDots();
            this.updateSlider();
            this.startAutoSlide();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Instansiasi Komponen
    |--------------------------------------------------------------------------
    */
    
    // Fade Sliders
    new FadeSlider('facility', { autoSlide: true });

    // Track Sliders
    new TrackSlider('before-after', { 
        breakpoints: { lg: 3, sm: 2, default: 1 },
        autoSlide: true,
        interval: 3500
    });

    new TrackSlider('treatment-list', { 
        breakpoints: { lg: 3, sm: 2, default: 1 },
        autoSlide: true,
        interval: 2500
    });

    // Slider Doctor dengan Efek Center Scale aktif
    new TrackSlider('doctor', { 
        breakpoints: { lg: 3, sm: 2, default: 1 },
        autoSlide: true,
        interval: 3000,
        centerScale: true // Mengaktifkan fokus kartu tengah lebih besar
    });

    new TrackSlider('news', { 
    breakpoints: { lg: 3, sm: 2, default: 1 },
    autoSlide: true,
    interval: 3000,
    centerScale: true // Mengaktifkan efek fokus kartu tengah
});

    new TrackSlider('promo', {
    breakpoints: { lg: 3, sm: 2, default: 1 },
    autoSlide: true,
    interval: 3000,
    centerScale: true // Mengaktifkan efek kartu tengah menonjol
});

    initScrollReveal();
});