/**
 * GIRNA GLOBAL - Official Interactive Client JavaScript Engine
 * Pure Vanilla ES6 JavaScript (No Frameworks, No Dependencies)
 */

function initGirnaGlobal() {
    // 1. Header Elevation On Scroll
    const header = document.getElementById('site-header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 30) {
                header.classList.add('shadow-md', 'bg-white/98');
                header.classList.remove('bg-white/95');
            } else {
                header.classList.remove('shadow-md', 'bg-white/98');
                header.classList.add('bg-white/95');
            }
        });
    }

    // 2. Mobile Drawer Navigation Toggle
    const mobileBtn = document.getElementById('mobile-menu-toggle');
    const mobileClose = document.getElementById('mobile-drawer-close');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    const mobileNavItems = document.querySelectorAll('.mobile-nav-item');

    function openMobileMenu() {
        if (mobileDrawer && mobileBackdrop) {
            mobileDrawer.classList.remove('translate-x-full');
            mobileDrawer.classList.add('drawer-open');
            mobileBackdrop.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeMobileMenu() {
        if (mobileDrawer && mobileBackdrop) {
            mobileDrawer.classList.remove('drawer-open');
            mobileDrawer.classList.add('translate-x-full');
            mobileBackdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    if (mobileBtn) mobileBtn.addEventListener('click', openMobileMenu);
    if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
    if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileMenu);

    mobileNavItems.forEach(item => {
        item.addEventListener('click', closeMobileMenu);
    });

    // 3. Smooth Scrolling for Navigation Links with Offset
    const navLinks = document.querySelectorAll('a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId && targetId !== '#') {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    const headerOffset = 78;
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // 4. Active Section Highlighting On Scroll
    const sections = document.querySelectorAll('section[id]');
    const desktopLinks = document.querySelectorAll('nav a[data-path]');
    
    if (sections.length > 0 && desktopLinks.length > 0) {
        window.addEventListener('scroll', () => {
            let current = 'home';
            const scrollY = window.pageYOffset;

            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.offsetHeight;
                if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });

            desktopLinks.forEach(link => {
                link.classList.remove('text-botanical', 'font-semibold', 'border-b-2', 'border-botanical');
                link.classList.add('text-forest-slate');
                const path = link.getAttribute('data-path');
                if (path === current || (current === 'home' && path === 'home' && scrollY < 500)) {
                    link.classList.remove('text-forest-slate');
                    link.classList.add('text-botanical', 'font-semibold', 'border-b-2', 'border-botanical');
                }
            });
        });
    }

    // 5. Live Metric Animated Counters
    const counters = document.querySelectorAll('.counter-val');
    if (counters.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'), 10) || 0;
                    const suffix = counter.getAttribute('data-suffix') || '';
                    const duration = 1600;
                    const startTime = performance.now();

                    function updateCounter(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        // Easing out cubic
                        const easeOut = 1 - Math.pow(1 - progress, 3);
                        const currentVal = Math.floor(easeOut * target);

                        counter.textContent = currentVal.toLocaleString() + suffix;

                        if (progress < 1) {
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target.toLocaleString() + suffix;
                        }
                    }

                    requestAnimationFrame(updateCounter);
                    obs.unobserve(counter);
                }
            });
        }, { threshold: 0.3 });

        counters.forEach(counter => observer.observe(counter));
    }

    // 6. Commercial Enquiry Form Submission
    const enquiryForm = document.getElementById('enquiry-form');
    if (enquiryForm) {
        enquiryForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const submitBtn = enquiryForm.querySelector('button[type="submit"]');
            const feedback = document.getElementById('form-feedback');
            
            const name = enquiryForm.querySelector('[name="name"]').value.trim();
            const phone = enquiryForm.querySelector('[name="phone"]').value.trim();
            const email = enquiryForm.querySelector('[name="email"]').value.trim();
            const serviceSelect = enquiryForm.querySelector('[name="service"]');
            const service = serviceSelect.options[serviceSelect.selectedIndex].text;
            const message = enquiryForm.querySelector('[name="message"]').value.trim();

            if (!name || !phone) {
                alert('Please enter your full name and phone number.');
                return;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Processing Enquiry...</span>';
            }

            setTimeout(() => {
                if (feedback) {
                    feedback.classList.remove('hidden');
                    feedback.innerHTML = `
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-botanical text-[24px] shrink-0 mt-0.5">check_circle</span>
                            <div>
                                <h4 class="font-manrope font-bold text-sm sm:text-base text-pine-heading">Enquiry Received Successfully!</h4>
                                <p class="text-xs sm:text-sm text-forest-slate mt-1">Thank you, <strong>${name}</strong>. A Girna Global agronomy specialist has been notified regarding your requirement for <em>${service}</em> and will connect with you at <strong>${phone}</strong> within 24 working hours.</p>
                                <div class="mt-3">
                                    <a href="https://wa.me/919100556355?text=Hello%20Girna%20Global,%20my%20name%20is%20${encodeURIComponent(name)}.%20I%20submitted%20an%20enquiry%20for%20${encodeURIComponent(service)}." target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 rounded bg-botanical text-white font-manrope font-bold text-xs uppercase tracking-wider hover:bg-botanical-dark transition-colors shadow">
                                        <span class="material-symbols-outlined text-[16px]">chat</span>
                                        <span>Continue to WhatsApp Desk</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                }
                enquiryForm.reset();
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span>Submit Commercial Enquiry</span><span class="material-symbols-outlined text-[20px]">send</span>';
                }
            }, 600);
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGirnaGlobal);
} else {
    initGirnaGlobal();
}
