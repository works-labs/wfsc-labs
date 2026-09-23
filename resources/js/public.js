document.addEventListener('DOMContentLoaded', () => {

    /* ==========================================================================
       1. Scroll Reveal (IntersectionObserver)
       ========================================================================== */
    const initScrollReveal = () => {
        const elements = document.querySelectorAll('[data-reveal]');
        if (!elements.length) return;

        const revealClasses = {
            left: 'reveal-left',
            right: 'reveal-right',
            zoom: 'reveal-zoom'
        };

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;

                const el = entry.target;
                const { reveal, delay = 0 } = el.dataset;

                if (revealClasses[reveal]) {
                    el.classList.add(revealClasses[reveal]);
                }

                setTimeout(() => el.classList.add('reveal-show'), Number(delay));
                obs.unobserve(el);
            });
        }, { rootMargin: '0px 0px -50px 0px', threshold: 0.15 });

        elements.forEach(el => observer.observe(el));
    };


    /* ==========================================================================
       2. Navbar Scroll Effect
       ========================================================================== */
    const initNavbar = () => {
        const navbar = document.getElementById('public-navbar');
        if (!navbar) return;

        const updateNavbar = () => {
            navbar.classList.toggle('is-scrolled', window.scrollY > 40);
        };

        updateNavbar();
        window.addEventListener('scroll', updateNavbar, { passive: true });
    };


    /* ==========================================================================
       3. Treatment Category Tabs (Delegated Event)
       ========================================================================== */
    const initTreatmentTabs = () => {
        const tabs = document.querySelectorAll('[data-treatment-tab]');
        const panels = document.querySelectorAll('[data-treatment-panel]');
        if (!tabs.length || !panels.length) return;

        const activeClasses = ['bg-[#FF5252]', 'text-white', 'border-[#FF5252]', 'hover:text-white', 'hover:border-[#FF5252]'];
        const inactiveClasses = ['bg-white', 'text-neutral-600', 'border-neutral-200', 'hover:text-[#FF5252]', 'hover:border-[#FF5252]'];

        const switchTab = (categoryId, updateUrl = true) => {
            tabs.forEach(item => {
                const isActive = item.dataset.treatmentTab === String(categoryId);
                activeClasses.forEach(cls => item.classList.toggle(cls, isActive));
                inactiveClasses.forEach(cls => item.classList.toggle(cls, !isActive));
            });

            panels.forEach(panel => {
                panel.classList.toggle('hidden', panel.dataset.treatmentPanel !== String(categoryId));
            });

            if (updateUrl) {
                history.replaceState(null, '', `#category-${categoryId}`);
                sessionStorage.setItem('active_treatment_category', categoryId);
            }
        };

        document.addEventListener('click', (e) => {
            const tab = e.target.closest('[data-treatment-tab]');
            if (!tab) return;
            switchTab(tab.dataset.treatmentTab);
        });

        // Cek URL Hash (#category-X) atau SessionStorage saat halaman di-load
        const hashMatch = window.location.hash.match(/#category-(\d+)/);
        const storedCategory = sessionStorage.getItem('active_treatment_category');

        if (hashMatch && hashMatch[1]) {
            switchTab(hashMatch[1], false);
        } else if (storedCategory) {
            switchTab(storedCategory, false);
        }
    };


    /* ==========================================================================
       4. Fade / Chunk Switcher Slider
       ========================================================================== */
    class FadeSlider {
        constructor(prefix, options = {}) {
            this.slider = document.querySelector(`[data-${prefix}-slider]`);
            if (!this.slider) return;

            this.slides = Array.from(this.slider.querySelectorAll(`[data-${prefix}-slide]`));
            this.dots = Array.from(this.slider.querySelectorAll(`[data-${prefix}-dot]`));
            this.prevButton = document.querySelector(`[data-${prefix}-prev]`) || this.slider.querySelector(`[data-${prefix}-prev]`);
            this.nextButton = document.querySelector(`[data-${prefix}-next]`) || this.slider.querySelector(`[data-${prefix}-next]`);

            if (this.slides.length <= 1) return;

            this.autoSlide = options.autoSlide !== undefined ? options.autoSlide : true;
            this.autoSlideInterval = options.interval || 4000;
            this.activeDotClass = options.activeDotClass || 'bg-[#FF5252]';
            this.inactiveDotClass = options.inactiveDotClass || 'bg-neutral-300';

            this.currentIndex = 0;
            this.interval = null;

            // Touch Swipe Tracking
            this.startX = 0;
            this.currentX = 0;
            this.isDragging = false;

            this.init();
        }

        showSlide(index) {
            this.currentIndex = (index + this.slides.length) % this.slides.length;

            this.slides.forEach((slide, i) => {
                const active = i === this.currentIndex;

                if (active) {
                    slide.classList.remove('hidden');
                    requestAnimationFrame(() => {
                        slide.classList.add('opacity-100');
                        slide.classList.remove('opacity-0');
                    });
                } else {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0');
                    slide.classList.add('hidden');
                }

                slide.classList.toggle('pointer-events-auto', active);
                slide.classList.toggle('pointer-events-none', !active);
            });

            this.dots.forEach((dot, i) => {
                const active = i === this.currentIndex;
                const isScale = dot.dataset.dotType === 'scale';

                if (!isScale) {
                    dot.classList.toggle('w-8', active);
                    dot.classList.toggle('w-2', !active);
                } else {
                    dot.classList.toggle('scale-125', active);
                }

                dot.classList.toggle(this.activeDotClass, active);
                dot.classList.toggle(this.inactiveDotClass, !active);
            });
        }

        startAutoSlide() {
            if (!this.autoSlide || this.slides.length <= 1) return;
            this.stopAutoSlide();
            this.interval = setInterval(() => this.showSlide(this.currentIndex + 1), this.autoSlideInterval);
        }

        stopAutoSlide() {
            if (this.interval) clearInterval(this.interval);
        }

        initTouch() {
            const handleTouchStart = (e) => {
                this.isDragging = true;
                this.startX = e.touches ? e.touches[0].clientX : e.clientX;
                this.stopAutoSlide();
            };

            const handleTouchMove = (e) => {
                if (!this.isDragging) return;
                this.currentX = e.touches ? e.touches[0].clientX : e.clientX;
            };

            const handleTouchEnd = () => {
                if (!this.isDragging) return;
                this.isDragging = false;
                const diffX = this.startX - this.currentX;
                if (Math.abs(diffX) > 40 && this.currentX !== 0) {
                    if (diffX > 0) {
                        this.showSlide(this.currentIndex + 1);
                    } else {
                        this.showSlide(this.currentIndex - 1);
                    }
                }
                this.startX = 0;
                this.currentX = 0;
                this.startAutoSlide();
            };

            this.slider.addEventListener('touchstart', handleTouchStart, { passive: true });
            this.slider.addEventListener('touchmove', handleTouchMove, { passive: true });
            this.slider.addEventListener('touchend', handleTouchEnd);
        }

        init() {
            const handleAction = (action) => {
                action();
                this.startAutoSlide();
            };

            this.prevButton?.addEventListener('click', () => handleAction(() => this.showSlide(this.currentIndex - 1)));
            this.nextButton?.addEventListener('click', () => handleAction(() => this.showSlide(this.currentIndex + 1)));

            this.dots.forEach((dot, idx) => {
                dot.addEventListener('click', () => handleAction(() => this.showSlide(idx)));
            });

            if (this.autoSlide) {
                this.slider.addEventListener('mouseenter', () => this.stopAutoSlide());
                this.slider.addEventListener('mouseleave', () => this.startAutoSlide());
            }

            this.initTouch();
            this.showSlide(0);
            this.startAutoSlide();
        }
    }


    /* ==========================================================================
       5. Track Carousel Slider (Multi-card Slider with Touch Drag & Navigation)
       ========================================================================== */
    class TrackSlider {
        constructor(prefix, options = {}) {
            this.slider = document.querySelector(`[data-${prefix}-slider]`);
            if (!this.slider) return;

            this.track = this.slider.querySelector(`[data-${prefix}-track]`);
            this.slides = Array.from(this.slider.querySelectorAll(`[data-${prefix}-slide]`));
            this.prevButton = document.querySelector(`[data-${prefix}-prev]`) || this.slider.querySelector(`[data-${prefix}-prev]`);
            this.nextButton = document.querySelector(`[data-${prefix}-next]`) || this.slider.querySelector(`[data-${prefix}-next]`);
            this.dotsContainer = document.querySelector(`[data-${prefix}-dots]`) || this.slider.querySelector(`[data-${prefix}-dots]`);

            if (!this.track || !this.slides.length) return;

            this.breakpoints = options.breakpoints || { lg: 3, sm: 2, default: 1 };
            this.autoSlide = options.autoSlide !== undefined ? options.autoSlide : true;
            this.autoSlideInterval = options.interval || 3500;
            this.centerScale = options.centerScale || false;

            this.currentIndex = 0;
            this.interval = null;

            // Drag / Touch State
            this.isDragging = false;
            this.startPos = 0;
            this.currentTranslate = 0;
            this.prevTranslate = 0;
            this.animationID = 0;

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
            if (maxIndex <= 0) return;

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
                const cardInner = slide.querySelector('.doctor-card-inner') ||
                    slide.querySelector('.news-card-inner') ||
                    slide.querySelector('.promo-card-inner') ||
                    slide.querySelector('.before-after-card-inner') ||
                    slide.firstElementChild;
                if (!cardInner) return;

                let isCenter = false;
                if (visible === 3) isCenter = index === this.currentIndex + 1;
                if (visible === 1) isCenter = index === this.currentIndex;

                cardInner.classList.toggle('scale-105', isCenter);
                cardInner.classList.toggle('scale-95', !isCenter && visible > 1);
            });
        }

        updateSlider(withAnimation = true) {
            const maxIndex = this.getMaxIndex();
            if (this.currentIndex > maxIndex) this.currentIndex = 0;
            if (this.currentIndex < 0) this.currentIndex = maxIndex;

            const visible = this.getVisibleSlides();
            const slideWidthPercent = 100 / visible;
            this.currentTranslate = -this.currentIndex * slideWidthPercent;
            this.prevTranslate = this.currentTranslate;

            if (withAnimation) {
                this.track.style.transition = 'transform 0.5s ease-out';
            } else {
                this.track.style.transition = 'none';
            }
            this.track.style.transform = `translateX(${this.currentTranslate}%)`;

            // Update Navigation Button States
            if (this.prevButton) {
                this.prevButton.disabled = false;
            }
            if (this.nextButton) {
                this.nextButton.disabled = false;
            }

            // Update Dots
            if (this.dotsContainer && this.dotsContainer.children.length > 0) {
                Array.from(this.dotsContainer.children).forEach((dot, index) => {
                    const active = index === this.currentIndex;
                    dot.classList.toggle('w-8', active);
                    dot.classList.toggle('w-2', !active);
                    dot.classList.toggle('bg-[#FF5252]', active);
                    dot.classList.toggle('bg-neutral-300', !active);
                });
            }

            this.updateCenterFocus();
        }

        startAutoSlide() {
            if (!this.autoSlide || this.slides.length <= this.getVisibleSlides()) return;
            this.stopAutoSlide();
            this.interval = setInterval(() => {
                const maxIndex = this.getMaxIndex();
                this.currentIndex = this.currentIndex >= maxIndex ? 0 : this.currentIndex + 1;
                this.updateSlider();
            }, this.autoSlideInterval);
        }

        stopAutoSlide() {
            if (this.interval) clearInterval(this.interval);
        }

        getPositionX(event) {
            return event.type.includes('touch') ? event.touches[0].clientX : event.clientX;
        }

        initTouchDrag() {
            const touchStart = (event) => {
                this.isDragging = true;
                this.startPos = this.getPositionX(event);
                this.stopAutoSlide();
                this.track.style.transition = 'none';
            };

            const touchMove = (event) => {
                if (!this.isDragging) return;
                const currentPosition = this.getPositionX(event);
                const diffX = currentPosition - this.startPos;
                const sliderWidth = this.slider.clientWidth || 1;
                const diffPercent = (diffX / sliderWidth) * 100;

                this.currentTranslate = this.prevTranslate + diffPercent;
                this.track.style.transform = `translateX(${this.currentTranslate}%)`;
            };

            const touchEnd = () => {
                if (!this.isDragging) return;
                this.isDragging = false;
                const movedBy = this.currentTranslate - this.prevTranslate;

                if (movedBy < -5) {
                    this.currentIndex = Math.min(this.currentIndex + 1, this.getMaxIndex());
                } else if (movedBy > 5) {
                    this.currentIndex = Math.max(this.currentIndex - 1, 0);
                }

                this.updateSlider(true);
                this.startAutoSlide();
            };

            this.slider.addEventListener('touchstart', touchStart, { passive: true });
            this.slider.addEventListener('touchmove', touchMove, { passive: true });
            this.slider.addEventListener('touchend', touchEnd);

            this.slider.addEventListener('mousedown', touchStart);
            this.slider.addEventListener('mousemove', touchMove);
            this.slider.addEventListener('mouseup', touchEnd);
            this.slider.addEventListener('mouseleave', () => {
                if (this.isDragging) touchEnd();
            });
        }

        init() {
            const handleNav = (direction) => {
                const maxIndex = this.getMaxIndex();
                if (direction === 'prev') {
                    this.currentIndex = this.currentIndex <= 0 ? maxIndex : this.currentIndex - 1;
                } else {
                    this.currentIndex = this.currentIndex >= maxIndex ? 0 : this.currentIndex + 1;
                }
                this.updateSlider();
                this.startAutoSlide();
            };

            this.prevButton?.addEventListener('click', (e) => {
                e.preventDefault();
                handleNav('prev');
            });

            this.nextButton?.addEventListener('click', (e) => {
                e.preventDefault();
                handleNav('next');
            });

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
                    this.updateSlider(false);
                }, 150);
            });

            this.createDots();
            this.updateSlider(false);
            this.initTouchDrag();
            this.startAutoSlide();
        }
    }


    /* ==========================================================================
       6. Lightbox Helper (Reusable Modal Logic)
       ========================================================================== */
    const createModalController = (modalElement) => {
        if (!modalElement) return null;

        const open = (onOpened) => {
            if (typeof onOpened === 'function') onOpened();
            modalElement.classList.remove('hidden');
            requestAnimationFrame(() => {
                modalElement.classList.remove('opacity-0');
                modalElement.classList.add('opacity-100');
            });
            document.body.style.overflow = 'hidden';
        };

        const close = (onClosed) => {
            modalElement.classList.remove('opacity-100');
            modalElement.classList.add('opacity-0');
            setTimeout(() => {
                modalElement.classList.add('hidden');
                document.body.style.overflow = '';
                if (typeof onClosed === 'function') onClosed();
            }, 300);
        };

        return { open, close };
    };


    /* ==========================================================================
       7. Before & After Lightbox
       ========================================================================== */
    const initBeforeAfterLightbox = () => {
        const triggers = document.querySelectorAll('[data-lightbox-trigger]');
        const modal = document.getElementById('before-after-lightbox');
        if (!triggers.length || !modal) return;

        const modalCtrl = createModalController(modal);
        const closeBtn = document.getElementById('lightbox-close');
        const beforeContainer = document.getElementById('lightbox-before-container');
        const afterContainer = document.getElementById('lightbox-after-container');
        const captionContainer = document.getElementById('lightbox-caption-container');
        const captionText = document.getElementById('lightbox-caption');

        const renderMedia = (container, src, type, label) => {
            if (!container) return;

            const badge = container.querySelector('span');
            container.innerHTML = '';
            if (badge) container.appendChild(badge);

            if (!src) {
                container.classList.add('hidden');
                return;
            }
            container.classList.remove('hidden');

            const isVideo = type === 'video';
            const el = document.createElement(isVideo ? 'video' : 'img');
            el.src = src;
            el.className = 'h-full w-full object-contain';

            if (isVideo) {
                Object.assign(el, { autoplay: true, muted: true, loop: true, playsInline: true });
                el.play().catch(() => { });
            } else {
                el.alt = label;
            }

            container.appendChild(el);
        };

        const openModal = (card) => {
            modalCtrl.open(() => {
                const { beforeSrc, beforeType, afterSrc, afterType, caption } = card.dataset;
                renderMedia(beforeContainer, beforeSrc, beforeType, 'Before Result');
                renderMedia(afterContainer, afterSrc, afterType, 'After Result');

                const hasCaption = Boolean(caption && caption.trim());
                captionContainer.classList.toggle('hidden', !hasCaption);
                if (hasCaption) captionText.textContent = caption;
            });
        };

        const closeModal = () => {
            modalCtrl.close(() => {
                [beforeContainer, afterContainer].forEach(container => {
                    container?.querySelectorAll('video').forEach(video => video.pause());
                });
            });
        };

        triggers.forEach(trigger => trigger.addEventListener('click', () => openModal(trigger)));
        closeBtn?.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
        });
    };


    /* ==========================================================================
       8. Before & After Treatment Navigation
       ========================================================================== */
    const initBeforeAfterNavigation = () => {
        const filterBar = document.getElementById('before-after-filters');
        const chips = document.querySelectorAll('[data-treatment-chip]');
        const sections = Array.from(document.querySelectorAll('[data-treatment-section]'));

        if (!filterBar || !chips.length || !sections.length) return;

        let activeId = null;
        let ticking = false;

        const setActiveChip = (id) => {
            if (activeId === id) return;
            activeId = id;

            chips.forEach(chip => {
                const active = chip.dataset.treatmentChip === id;
                chip.classList.toggle('bg-wfsc-coral', active);
                chip.classList.toggle('text-white', active);
                chip.classList.toggle('border-wfsc-coral', active);
                chip.classList.toggle('bg-white', !active);
                chip.classList.toggle('text-neutral-600', !active);
                chip.classList.toggle('border-neutral-200', !active);
            });

            document.querySelector(`[data-treatment-chip="${id}"]`)
                ?.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        };

        const updateActiveSection = () => {
            ticking = false;
            const navbar = document.getElementById('public-navbar');
            const navbarHeight = navbar ? navbar.getBoundingClientRect().height : 0;
            const filterHeight = filterBar.getBoundingClientRect().height;
            const activationPoint = navbarHeight + filterHeight + 40;

            let currentSection = sections[0];
            sections.forEach(section => {
                if (section.getBoundingClientRect().top <= activationPoint) {
                    currentSection = section;
                }
            });

            setActiveChip(currentSection.dataset.treatmentSection);
        };

        const requestUpdate = () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(updateActiveSection);
        };

        window.addEventListener('scroll', requestUpdate, { passive: true });
        window.addEventListener('resize', requestUpdate);

        chips.forEach(chip => {
            chip.addEventListener('click', (e) => {
                e.preventDefault();
                const id = chip.dataset.treatmentChip;
                const section = document.querySelector(`[data-treatment-section="${id}"]`);
                if (!section) return;

                setActiveChip(id);

                const navbar = document.getElementById('public-navbar');
                const navbarHeight = navbar ? navbar.getBoundingClientRect().height : 0;
                const filterHeight = filterBar.getBoundingClientRect().height;
                const offset = navbarHeight + filterHeight + 20;

                const targetPosition = section.getBoundingClientRect().top + window.scrollY - offset;
                window.scrollTo({ top: targetPosition, behavior: 'smooth' });
            });
        });

        requestUpdate();
    };


    /* ==========================================================================
       9. Promo Lightbox
       ========================================================================== */
    const initPromoLightbox = () => {
        const triggers = document.querySelectorAll('[data-promo-lightbox-trigger]');
        const modal = document.getElementById('promo-lightbox');
        if (!triggers.length || !modal) return;

        const modalCtrl = createModalController(modal);
        const closeBtn = document.getElementById('promo-lightbox-close');
        const backdrop = document.getElementById('promo-lightbox-backdrop');
        const image = document.getElementById('promo-lightbox-image');
        const title = document.getElementById('promo-lightbox-title');
        const descriptionContainer = document.getElementById('promo-lightbox-description-container');
        const description = document.getElementById('promo-lightbox-description');

        const openModal = (card) => {
            const { promoImage, promoTitle, promoDescription } = card.dataset;

            modalCtrl.open(() => {
                if (promoImage) {
                    image.src = promoImage;
                    image.alt = promoTitle || 'Promo WFSC Clinic';
                    image.classList.remove('hidden');
                } else {
                    image.src = '';
                    image.alt = '';
                    image.classList.add('hidden');
                }

                title.textContent = promoTitle || 'Promo WFSC Clinic';

                const hasDesc = Boolean(promoDescription && promoDescription.trim());
                descriptionContainer.classList.toggle('hidden', !hasDesc);
                description.textContent = hasDesc ? promoDescription : '';
            });
        };

        const closeModal = () => modalCtrl.close();

        triggers.forEach(trigger => trigger.addEventListener('click', () => openModal(trigger)));
        closeBtn?.addEventListener('click', closeModal);
        backdrop?.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
        });
    };


    /* ==========================================================================
       10. Doctor Lightbox (Non-Founder)
       ========================================================================== */
    const initDoctorLightbox = () => {
        const triggers = document.querySelectorAll('[data-doctor-lightbox-trigger]');
        const modal = document.getElementById('doctor-lightbox');
        if (!triggers.length || !modal) return;

        const modalCtrl = createModalController(modal);
        const closeBtn = document.getElementById('doctor-lightbox-close');
        const backdrop = document.getElementById('doctor-lightbox-backdrop');
        const photo = document.getElementById('doctor-lightbox-photo');
        const name = document.getElementById('doctor-lightbox-name');
        const specialization = document.getElementById('doctor-lightbox-specialization');
        const bio = document.getElementById('doctor-lightbox-bio');
        const educationContainer = document.getElementById('doctor-lightbox-education-container');
        const education = document.getElementById('doctor-lightbox-education');
        const experienceContainer = document.getElementById('doctor-lightbox-experience-container');
        const experience = document.getElementById('doctor-lightbox-experience');

        const openModal = (card) => {
            const { doctorPhoto, doctorName, doctorSpecialization, doctorBio, doctorEducation, doctorExperience } = card.dataset;

            modalCtrl.open(() => {
                if (doctorPhoto) {
                    photo.src = doctorPhoto;
                    photo.alt = doctorName || 'Doctor';
                    photo.parentElement.classList.remove('hidden');
                } else {
                    photo.src = '';
                    photo.alt = '';
                    photo.parentElement.classList.add('hidden');
                }

                name.textContent = doctorName || 'Doctor Profile';
                specialization.textContent = doctorSpecialization || 'Specialist';
                bio.textContent = doctorBio || '';

                const hasEdu = Boolean(doctorEducation && doctorEducation.trim());
                educationContainer.classList.toggle('hidden', !hasEdu);
                if (hasEdu) education.textContent = doctorEducation;

                const hasExp = Boolean(doctorExperience && doctorExperience.trim());
                experienceContainer.classList.toggle('hidden', !hasExp);
                if (hasExp) experience.textContent = doctorExperience;
            });
        };

        const closeModal = () => modalCtrl.close();

        triggers.forEach(trigger => trigger.addEventListener('click', () => openModal(trigger)));
        closeBtn?.addEventListener('click', closeModal);
        backdrop?.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
        });
    };


    /* ==========================================================================
       11. Scrollable Chips Bar Sync with Indicator Dots
       ========================================================================== */
    const initScrollableChips = () => {
        const containers = document.querySelectorAll('[data-chip-scroll-container]');
        if (!containers.length) return;

        containers.forEach(container => {
            const track = container.querySelector('[data-chip-scroll-track]');
            const dots = container.querySelectorAll('[data-chip-dot]');
            if (!track || !dots.length) return;

            const updateDots = () => {
                const maxScroll = track.scrollWidth - track.clientWidth;
                if (maxScroll <= 0) {
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('bg-[#FF5252]', i === 0);
                        dot.classList.toggle('bg-neutral-300', i !== 0);
                    });
                    return;
                }

                const percentage = Math.min(Math.max(track.scrollLeft / maxScroll, 0), 1);
                const activeIndex = Math.min(
                    Math.floor(percentage * dots.length),
                    dots.length - 1
                );

                dots.forEach((dot, i) => {
                    const isActive = i === activeIndex;
                    dot.classList.toggle('bg-[#FF5252]', isActive);
                    dot.classList.toggle('bg-neutral-300', !isActive);
                });
            };

            // Click dot to scroll to section
            dots.forEach((dot, index) => {
                dot.style.cursor = 'pointer';
                dot.addEventListener('click', () => {
                    const maxScroll = track.scrollWidth - track.clientWidth;
                    const targetScroll = (index / (dots.length - 1)) * maxScroll;
                    track.scrollTo({ left: targetScroll, behavior: 'smooth' });
                });
            });

            track.addEventListener('scroll', updateDots, { passive: true });
            window.addEventListener('resize', updateDots, { passive: true });
            updateDots();
        });
    };


    /* ==========================================================================
       Execute Initializations
       ========================================================================== */
    initScrollReveal();
    initNavbar();
    initTreatmentTabs();
    initBeforeAfterLightbox();
    initBeforeAfterNavigation();
    initPromoLightbox();
    initDoctorLightbox();
    initScrollableChips();

    // 1. Hero Banner Slider
    new FadeSlider('hero', {
        autoSlide: true,
        interval: 2000,
        activeDotClass: 'bg-[#FF5252]',
        inactiveDotClass: 'bg-white/50'
    });

    // 2. Treatments Slider (Mobile & Desktop)
    new TrackSlider('treatments', {
        autoSlide: true,
        interval: 2000,
        breakpoints: { lg: 4, sm: 2, default: 1 }
    });

    // 3. Before & After Slider
    new TrackSlider('before-after', {
        autoSlide: true,
        interval: 2000,
        breakpoints: { lg: 3, sm: 2, default: 1 }
    });

    // 4. Why Choose / Facility Slider
    new FadeSlider('facility', {
        autoSlide: true,
        interval: 2000
    });

    // 5. Doctors Slider
    new TrackSlider('doctor', {
        autoSlide: true,
        interval: 2000,
        breakpoints: { lg: 3, sm: 2, default: 1 }
    });

    // 6. Promos Slider
    new TrackSlider('promo', {
        autoSlide: true,
        interval: 2500,
        breakpoints: { lg: 3, sm: 2, default: 1 }
    });

    // 7. News Slider
    new TrackSlider('news', {
        autoSlide: true,
        interval: 2000,
        breakpoints: { lg: 3, sm: 2, default: 1 }
    });

});
