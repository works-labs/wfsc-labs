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

                    // Set jenis animasi berdasarkan attribute
                    if (animationType === 'left') el.classList.add('reveal-left');
                    if (animationType === 'right') el.classList.add('reveal-right');
                    if (animationType === 'zoom') el.classList.add('reveal-zoom');

                    setTimeout(() => {
                        el.classList.add('reveal-show');
                    }, delay);

                    observer.unobserve(el); // Hanya jalankan animasi 1 kali
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
    | 3. Fade / Chunk Switcher Slider Class (Doctor, News, Before-After, Facility)
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
                // Support toggle untuk dot lebar (w-8 vs w-2) atau dot scale
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
    | 4. Track Carousel Slider Class (Treatment List)
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | Track Carousel Slider Class (Treatment List, dll)
    |--------------------------------------------------------------------------
    */
    class TrackSlider {
        constructor(prefix, options = {}) {
            this.prefix = prefix;
            this.slider = document.querySelector(`[data-${prefix}-slider]`);
            if (!this.slider) return;

            this.track = this.slider.querySelector(`[data-${prefix}-track]`);
            this.slides = Array.from(this.slider.querySelectorAll(`[data-${prefix}-slide]`));
            
            // Cari tombol prev/next di dalam slider ATAU di seluruh document (karena tombol treatment ada di luar div slider)
            this.prevButton = document.querySelector(`[data-${prefix}-prev]`);
            this.nextButton = document.querySelector(`[data-${prefix}-next]`);
            this.dotsContainer = document.querySelector(`[data-${prefix}-dots]`);
            
            // Config Breakpoints & AutoSlide
            this.breakpoints = options.breakpoints || { lg: 4, sm: 2, default: 1 };
            this.autoSlide = options.autoSlide || false;
            this.autoSlideInterval = options.interval || 4000; // default 4 detik

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
                    this.startAutoSlide(); // Reset timer saat diklik manual
                });
                this.dotsContainer.appendChild(dot);
            }
        }

        updateSlider() {
            const visibleSlides = this.getVisibleSlides();
            const maxIndex = this.getMaxIndex();

            if (this.currentIndex > maxIndex) {
                this.currentIndex = 0; // Loop kembali ke awal jika melebih maxIndex (khusus autoslide)
            }
            if (this.currentIndex < 0) {
                this.currentIndex = maxIndex; // Loop ke paling akhir jika dari slide 0 dipencet Prev
            }

            const slideWidth = 100 / visibleSlides;
            this.track.style.transform = `translateX(-${this.currentIndex * slideWidth}%)`;

            // Update tombol state
            if (this.prevButton) this.prevButton.disabled = (this.currentIndex === 0 && !this.autoSlide);
            if (this.nextButton) this.nextButton.disabled = (this.currentIndex >= maxIndex && !this.autoSlide);

            // Update active dots
            if (this.dotsContainer) {
                Array.from(this.dotsContainer.children).forEach((dot, index) => {
                    const active = index === this.currentIndex;
                    dot.classList.toggle('w-8', active);
                    dot.classList.toggle('w-2', !active);
                    dot.classList.toggle('bg-[#FF5252]', active);
                    dot.classList.toggle('bg-neutral-300', !active);
                });
            }
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
            // Event tombol Prev & Next
            if (this.prevButton) {
                this.prevButton.addEventListener('click', () => {
                    const maxIndex = this.getMaxIndex();
                    this.currentIndex = this.currentIndex <= 0 ? maxIndex : this.currentIndex - 1;
                    this.updateSlider();
                    this.startAutoSlide(); // Reset timer autoslide
                });
            }

            if (this.nextButton) {
                this.nextButton.addEventListener('click', () => {
                    const maxIndex = this.getMaxIndex();
                    this.currentIndex = this.currentIndex >= maxIndex ? 0 : this.currentIndex + 1;
                    this.updateSlider();
                    this.startAutoSlide(); // Reset timer autoslide
                });
            }

            // Pause Auto-Slide saat kursor berada di atas Slider
            if (this.autoSlide) {
                const wrapper = this.slider.parentElement || this.slider;
                wrapper.addEventListener('mouseenter', () => this.stopAutoSlide());
                wrapper.addEventListener('mouseleave', () => this.startAutoSlide());
            }

            // Window resize event
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
    | Instansiasi Komponen (Hanya 1 Baris Per Section!)
    |--------------------------------------------------------------------------
    */
    
    // 1. Fade Sliders (Chunk Switcher / Simple Fade)
    new FadeSlider('before-after', { autoSlide: true, activeDotClass: 'bg-neutral-900' });
    new FadeSlider('facility', { autoSlide: true });
    //new FadeSlider('doctor');
    //new FadeSlider('news');
    new TrackSlider('treatment-list', { 
        breakpoints: { lg: 4, sm: 2, default: 1 },
        autoSlide: true,
        interval: 2000 // Berpindah setiap 4 detik
    });
    new TrackSlider('doctor', { 
        breakpoints: { lg: 3, sm: 2, default: 1 },
        autoSlide: true,
        interval: 3000
    });

    // 3. News List (Show 3 Desktop, 2 Tablet, 1 Mobile)
    new TrackSlider('news', { 
        breakpoints: { lg: 3, sm: 2, default: 1 },
        autoSlide: true,
        interval: 3000
    });
    initScrollReveal();

});