<?php
/**
 * Girna Global - Institutional Homepage
 * Exact approved implementation of Google Stitch design
 * "Farm to Foreign" Agricultural Export Excellence
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/seo.php';
require_once __DIR__ . '/includes/mailer.php';

$settings = get_settings();

// Handle Direct Inquiry Form Submission
$inquirySuccess = false;
$inquiryError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_inquiry') {
    verify_csrf();
    
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $subject = "Commercial Enquiry: " . ($service ?: "General Agronomy");

    if (!empty($name) && !empty($phone)) {
        try {
            send_contact_email($name, $email, $phone, $subject, $message);
            $inquirySuccess = true;
            set_flash('success', 'Thank you! Your enquiry has been received. Our field advisory team will contact you within 24 working hours.');
        } catch (Exception $e) {
            $inquiryError = 'There was an issue processing your enquiry. Please contact us directly via WhatsApp or phone.';
        }
    } else {
        $inquiryError = 'Please provide your full name and valid phone number.';
    }
}

$pageTitle = "Farm to Foreign • Global Agricultural Export Excellence";
$pageDesc = "Girna Global bridges fertile Jalgaon banana farmland to international markets with certified G9 tissue-culture plants, scientific crop nutrition, and export harvesting.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="web_standard" name="shell-type">
    
    <!-- Dynamic SEO Tags -->
    <?php render_seo_tags($pageTitle, $pageDesc, SITE_URL . '/assets/images/estate-farm.jpg'); ?>

    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/assets/images/logo.png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CSS with Official Stitch Theme Configuration -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "forest-deep": "#123D2B",
            "forest-dark": "#0B261B",
            "botanical": "#267044",
            "botanical-dark": "#1d5835",
            "botanical-light": "#eaf5ed",
            "leaf-green": "#8BAF52",
            "earthy-gold": "#C3A46A",
            "earthy-gold-light": "#f4eedf",
            "cream-warm": "#F7F6EF",
            "canvas-soft": "#FCFBF7",
            "pine-charcoal": "#122B1E",
            "pine-heading": "#111E16",
            "forest-slate": "#334A3E",
            "surface-card": "#FFFFFF",
          },
          fontFamily: {
            manrope: ["Manrope", "sans-serif"],
            inter: ["Inter", "sans-serif"],
          }
        }
      }
    };
    </script>
    <style>
      @layer base {
        html, body {
          margin: 0;
          padding: 0;
          scroll-behavior: smooth;
        }
        main > :first-child { margin-top: 0 !important; }
        main > :last-child { margin-bottom: 0 !important; }
      }
      .fill-1 {
        font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
      @keyframes wa-pulse {
        0% { box-shadow: 0 0 0 0 rgba(38, 112, 68, 0.6); }
        70% { box-shadow: 0 0 0 14px rgba(38, 112, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(38, 112, 68, 0); }
      }
      .wa-pulse-btn {
        animation: wa-pulse 2.5s infinite;
      }
    </style>
</head>
<body class="bg-canvas-soft font-inter text-forest-slate antialiased selection:bg-earthy-gold selection:text-forest-dark">

    <!-- ============================================================
         HEADER & NAVIGATION (EXACT STITCH REFINED DESIGN)
         ============================================================ -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-[#C3A46A]/20 shadow-[0_2px_12px_rgba(18,61,43,0.04)]" id="site-header">
        <div class="h-20 max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between gap-4">
            
            <!-- Brand Logo & Identity -->
            <a href="<?= SITE_URL ?>/" class="flex items-center gap-3 shrink-0 group">
                <img alt="Girna Global Official Logo" class="h-10 w-10 object-contain rounded-full shadow-sm ring-1 ring-[#C3A46A]/30 group-hover:scale-105 transition-transform" src="<?= SITE_URL ?>/assets/images/logo.png">
                <div class="flex flex-col">
                    <span class="font-manrope font-extrabold text-lg uppercase tracking-wider text-forest-deep leading-none group-hover:text-botanical transition-colors">GIRNA GLOBAL</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-earthy-gold mt-0.5">FARM TO FOREIGN</span>
                </div>
            </a>

            <!-- Desktop Navigation Menu -->
            <nav class="hidden xl:flex items-center gap-8 font-inter text-sm font-medium">
                <a aria-current="page" class="transition-colors text-botanical font-semibold border-b-2 border-botanical pb-1" data-path="home" href="<?= SITE_URL ?>/">Home</a>
                <a class="text-forest-slate hover:text-botanical transition-colors pb-1" data-path="about-us" href="#about-us">About Us</a>
                <a class="text-forest-slate hover:text-botanical transition-colors pb-1" data-path="services" href="#services">Services</a>
                <a class="text-forest-slate hover:text-botanical transition-colors pb-1" data-path="our-farms" href="#our-farms">Our Farms</a>
                <a class="text-forest-slate hover:text-botanical transition-colors pb-1" data-path="testimonials" href="#testimonials">Testimonials</a>
                <a class="text-forest-slate hover:text-botanical transition-colors pb-1" data-path="contact" href="#contact">Contact</a>
            </nav>

            <!-- Header Quick Action CTAs (Desktop) -->
            <div class="hidden sm:flex items-center gap-3">
                <a href="https://wa.me/919100556355?text=Hello%20Girna%20Global,%20I%20have%20an%20export%20inquiry" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 rounded bg-cream-warm border border-earthy-gold/40 text-forest-deep hover:bg-botanical hover:text-white hover:border-botanical font-manrope font-bold text-xs uppercase tracking-wider transition-all duration-200 flex items-center gap-1.5 shadow-sm">
                    <span class="material-symbols-outlined text-[16px] text-leaf-green">chat</span>
                    <span>WhatsApp</span>
                </a>
                <a href="#contact" class="px-5 py-2 rounded bg-botanical text-white font-manrope font-bold text-xs uppercase tracking-wider transition-all duration-200 hover:bg-leaf-green hover:text-forest-dark shadow-md flex items-center gap-1.5">
                    <span>Enquire</span>
                    <span class="material-symbols-outlined text-[16px]">north_east</span>
                </a>
            </div>

            <!-- Mobile Hamburger Toggle Button -->
            <button type="button" class="xl:hidden p-2 rounded-lg text-forest-slate hover:text-botanical hover:bg-cream-warm focus:outline-none transition-colors" id="mobile-menu-toggle" aria-label="Toggle navigation menu">
                <span class="material-symbols-outlined text-[28px]" id="mobile-menu-icon">menu</span>
            </button>
        </div>

        <!-- Mobile Navigation Slide-Out Drawer -->
        <div class="fixed inset-0 top-20 bg-forest-dark/80 backdrop-blur-sm z-40 hidden transition-opacity duration-300 xl:hidden" id="mobile-backdrop"></div>
        <div class="fixed top-20 right-0 bottom-0 w-full max-w-sm bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out xl:hidden flex flex-col justify-between overflow-y-auto border-l border-[#C3A46A]/20" id="mobile-drawer">
            <div class="p-6 flex flex-col gap-5">
                <div class="flex items-center justify-between border-b border-[#C3A46A]/20 pb-4">
                    <div class="flex items-center gap-2">
                        <img src="<?= SITE_URL ?>/assets/images/logo.png" class="h-8 w-8 rounded-full" alt="Girna Global">
                        <span class="font-manrope font-bold text-sm uppercase tracking-wider text-forest-deep">GIRNA GLOBAL</span>
                    </div>
                    <button type="button" class="p-1 rounded text-forest-slate hover:text-botanical" id="mobile-drawer-close">
                        <span class="material-symbols-outlined text-[24px]">close</span>
                    </button>
                </div>
                <nav class="flex flex-col gap-1 font-manrope text-sm font-semibold text-pine-heading">
                    <a href="<?= SITE_URL ?>/" class="mobile-nav-item py-2.5 px-3 rounded text-botanical bg-cream-warm">Home</a>
                    <a href="#about-us" class="mobile-nav-item py-2.5 px-3 rounded hover:bg-botanical-light hover:text-botanical transition-colors">About Us</a>
                    <a href="#services" class="mobile-nav-item py-2.5 px-3 rounded hover:bg-botanical-light hover:text-botanical transition-colors">Services</a>
                    <a href="#our-farms" class="mobile-nav-item py-2.5 px-3 rounded hover:bg-botanical-light hover:text-botanical transition-colors">Our Farms</a>
                    <a href="#testimonials" class="mobile-nav-item py-2.5 px-3 rounded hover:bg-botanical-light hover:text-botanical transition-colors">Testimonials</a>
                    <a href="#location" class="mobile-nav-item py-2.5 px-3 rounded hover:bg-botanical-light hover:text-botanical transition-colors">Estate Location</a>
                    <a href="#contact" class="mobile-nav-item py-2.5 px-3 rounded hover:bg-botanical-light hover:text-botanical transition-colors">Contact</a>
                </nav>
                <div class="pt-4 border-t border-[#C3A46A]/20 flex flex-col gap-3">
                    <a href="tel:+919100556355" class="flex items-center gap-3 p-3 rounded-lg bg-cream-warm text-forest-deep font-inter text-xs font-semibold hover:bg-botanical-light transition-colors">
                        <span class="material-symbols-outlined text-botanical text-[18px]">phone</span>
                        <span>+91 9100556355</span>
                    </a>
                    <a href="https://wa.me/919100556355?text=Hello%20Girna%20Global" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 py-3 px-4 rounded bg-botanical text-white font-manrope font-bold text-xs uppercase tracking-wider hover:bg-botanical-dark transition-colors shadow-md">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                        <span>WhatsApp Export Desk</span>
                    </a>
                </div>
            </div>
            <div class="p-6 bg-canvas-soft border-t border-[#C3A46A]/20 text-xs text-forest-slate">
                <p class="font-bold text-pine-heading">Girna Global</p>
                <p class="text-[11px] text-forest-slate/80 mt-1">At post Wade, Tal. Bhadgaon, Dist. Jalgaon - 424201, Maharashtra</p>
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-canvas-soft min-h-[calc(100vh-80px)]">
        <div class="flex flex-col w-full">

            <!-- ============================================================
                 SECTION 2: HERO SECTION WITH DEEP FOREST GREEN OVERLAY
                 ============================================================ -->
            <section class="relative w-full min-h-[900px] flex flex-col justify-between -mt-20 pt-36 pb-12 overflow-hidden bg-forest-deep text-white">
                <!-- Background Plantation Image -->
                <div class="absolute inset-0 z-0 bg-cover bg-center transition-transform duration-1000 scale-105" data-alt="Panoramic view of banana plantation in Bhadgaon Jalgaon" style="background-image: url('<?= SITE_URL ?>/assets/images/hero-bg.jpg');">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-deep via-forest-deep/85 to-forest-dark/90"></div>
                    <div class="absolute inset-0 bg-radial from-transparent via-forest-deep/60 to-forest-dark/95"></div>
                </div>
                <!-- Subtle architectural drafting gridlines -->
                <div class="absolute inset-0 z-0 opacity-10 pointer-events-none bg-[radial-gradient(#C3A46A_1px,transparent_1px)] [background-size:32px_32px]"></div>

                <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 w-full my-auto py-12 flex flex-col items-start gap-8">

                    <!-- Main Headline -->
                    <div class="max-w-4xl flex flex-col gap-5">
                        <h1 class="font-manrope text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.15]">
                            Growing Together. <br class="hidden sm:block">
                            <span class="text-earthy-gold italic font-bold">Harvesting Better</span> Opportunities.
                        </h1>
                        <p class="font-inter text-lg sm:text-xl text-cream-warm/90 max-w-2xl font-normal leading-relaxed">
                            From trusted farming roots to agricultural solutions, Girna Global supports growers across the Jalgaon belt with certified tissue-culture banana plants, precision crop nutrition, and skilled export-standard harvesting services.
                        </p>
                    </div>

                    <!-- Action CTAs -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full sm:w-auto pt-2">
                        <a class="px-8 py-4 rounded bg-botanical text-white font-manrope font-bold text-sm uppercase tracking-wider flex items-center justify-center gap-3 transition-all duration-200 hover:bg-leaf-green hover:text-forest-dark shadow-xl" href="#services">
                            <span>Explore Our Services</span>
                            <span class="material-symbols-outlined text-[20px]">north_east</span>
                        </a>
                        <a class="px-8 py-4 rounded bg-white/10 hover:bg-white/20 border border-white/20 text-white font-manrope font-bold text-sm uppercase tracking-wider flex items-center justify-center gap-3 transition-all duration-200 backdrop-blur-md" href="https://wa.me/919100556355?text=Hello%20Girna%20Global,%20I%20have%20an%20enquiry" target="_blank" rel="noopener noreferrer">
                            <span class="material-symbols-outlined text-[20px] text-leaf-green">chat</span>
                            <span>WhatsApp Export Desk</span>
                        </a>
                    </div>
                </div>

                <!-- Live Metric Ribbon (Anchored Bottom) -->
                <div class="relative z-10 w-full bg-white/95 backdrop-blur-xl border-t border-[#C3A46A]/30 shadow-2xl text-forest-slate">
                    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-7">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8 divide-x divide-[#C3A46A]/20">
                            <div class="flex flex-col pl-2 sm:pl-4">
                                <span class="font-manrope text-3xl lg:text-4xl text-botanical font-extrabold tracking-tight">193,633+</span>
                                <span class="font-inter text-xs uppercase tracking-wider font-semibold text-forest-slate/80 mt-1">Products Delivered</span>
                            </div>
                            <div class="flex flex-col pl-4 lg:pl-8">
                                <span class="font-manrope text-3xl lg:text-4xl text-forest-deep font-extrabold tracking-tight">100+</span>
                                <span class="font-inter text-xs uppercase tracking-wider font-semibold text-forest-slate/80 mt-1">Happy Farmers in Belt</span>
                            </div>
                            <div class="flex flex-col pl-4 lg:pl-8">
                                <span class="font-manrope text-3xl lg:text-4xl text-leaf-green font-extrabold tracking-tight">20-Acre</span>
                                <span class="font-inter text-xs uppercase tracking-wider font-semibold text-forest-slate/80 mt-1">Cultivation Estate</span>
                            </div>
                            <div class="flex flex-col pl-4 lg:pl-8">
                                <span class="font-manrope text-3xl lg:text-4xl text-earthy-gold font-extrabold tracking-tight">25-Year</span>
                                <span class="font-inter text-xs uppercase tracking-wider font-semibold text-forest-slate/80 mt-1">Farming Legacy</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ============================================================
                 SECTION 3: COMPANY INTRODUCTION (EDITORIAL-STYLE ON WARM CREAM CANVAS)
                 ============================================================ -->
            <section class="w-full py-24 bg-cream-warm relative overflow-hidden border-b border-[#C3A46A]/20" id="about-us">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <!-- Section Tag -->
                    <div class="flex items-center gap-3 mb-6">
                        <span class="h-0.5 w-8 bg-earthy-gold"></span>
                        <span class="font-inter text-xs font-bold uppercase tracking-widest text-botanical">ABOUT GIRNA GLOBAL</span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                        <!-- Left: Image with floating highlight badge -->
                        <div class="lg:col-span-6 relative">
                            <div class="relative overflow-hidden rounded-lg bg-white shadow-xl border border-[#C3A46A]/30">
                                <img alt="Girna Global 30-Acre Estate in Bhadgaon Jalgaon" class="w-full h-[520px] object-cover transition-transform duration-700 hover:scale-105" data-alt="30-acre banana plantation estate in Wade Bhadgaon Jalgaon" src="<?= SITE_URL ?>/assets/images/about-farm.jpg?v=2">
                                <div class="absolute inset-0 bg-gradient-to-t from-forest-dark/60 via-transparent to-transparent"></div>
                            </div></div>

                        <!-- Right: Storytelling Editorial Column -->
                        <div class="lg:col-span-6 flex flex-col gap-6 lg:pl-4">
                            <h2 class="font-manrope text-3xl sm:text-4xl text-pine-heading font-extrabold leading-tight">
                                Rooted in Agriculture. <br>
                                <span class="text-botanical">Focused on Growth.</span>
                            </h2>
                            <p class="font-inter text-base text-forest-slate leading-relaxed">
                                Backed by a 25-year legacy of successful family farming, Girna Global bridges the gap between traditional agricultural heritage and global export standards. We are not external traders; we walk the same black-cotton soil as the cultivators we serve.
                            </p>
                            <p class="font-inter text-base text-forest-slate leading-relaxed">
                                Operating from our 20-acre cultivation estate in Bhadgaon, Jalgaon, we harvest export-grade G9 and Yelakki bananas while equipping regional growers with elite tissue-culture saplings, high-grade soil nutrition, and field harvesting support to maximize yield quality and international market value.
                            </p>
                            
                            <div class="space-y-4 pt-3 border-t border-[#C3A46A]/20">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center bg-botanical text-white shrink-0 mt-0.5 shadow-sm">
                                        <span class="material-symbols-outlined text-[15px]">check</span>
                                    </div>
                                    <div>
                                        <h4 class="font-manrope font-bold text-base text-pine-heading">Unbroken cold-chain &amp; export-grade packaging</h4>
                                        <p class="font-inter text-sm text-forest-slate/90 mt-0.5">Strict compliance with foreign phytosanitary benchmarks and dockside dispatch.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3.5">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center bg-botanical text-white shrink-0 mt-0.5 shadow-sm">
                                        <span class="material-symbols-outlined text-[15px]">check</span>
                                    </div>
                                    <div>
                                        <h4 class="font-manrope font-bold text-base text-pine-heading">Direct field advisory across the Girna River belt</h4>
                                        <p class="font-inter text-sm text-forest-slate/90 mt-0.5">Agronomic consultation on soil electroconductivity, moisture retention, and shoot care.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3.5">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center bg-botanical text-white shrink-0 mt-0.5 shadow-sm">
                                        <span class="material-symbols-outlined text-[15px]">check</span>
                                    </div>
                                    <div>
                                        <h4 class="font-manrope font-bold text-base text-pine-heading">End-to-end crop cycle partnership</h4>
                                        <p class="font-inter text-sm text-forest-slate/90 mt-0.5">Continuous stewardship from initial primary hardening sapling to harvest truck loading.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <a class="inline-flex items-center gap-2 font-manrope font-bold text-sm uppercase tracking-wider text-botanical hover:text-botanical-dark transition-colors" href="#services">
                                    <span>Learn More About Our Journey</span>
                                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ============================================================
                 SECTION 4: COMPANY HIGHLIGHTS (AUTHENTIC VERIFIED METRICS ON SOFT CANVAS)
                 ============================================================ -->
            <section class="w-full py-20 bg-canvas-soft relative border-b border-[#C3A46A]/20">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <span class="font-inter text-xs font-bold uppercase tracking-widest text-earthy-gold block mb-2">VERIFIED OPERATIONAL STRENGTH</span>
                        <h2 class="font-manrope text-3xl lg:text-4xl text-pine-heading font-extrabold">The Power of Ground-Level Agricultural Excellence</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        <!-- Metric Card 1 -->
                        <div class="bg-surface-card p-7 rounded-lg border border-[#C3A46A]/20 border-t-4 border-t-earthy-gold shadow-md flex flex-col justify-between hover:shadow-xl transition-all duration-200">
                            <div>
                                <span class="font-manrope text-4xl lg:text-5xl text-earthy-gold font-extrabold">25+</span>
                                <div class="w-8 h-1 bg-earthy-gold/40 my-3.5"></div>
                            </div>
                            <div>
                                <h3 class="font-manrope font-bold text-base text-pine-heading mb-1">Years Heritage</h3>
                                <p class="font-inter text-xs sm:text-sm text-forest-slate leading-relaxed">Generational family farming depth &amp; practical field knowledge in Maharashtra.</p>
                            </div>
                        </div>

                        <!-- Metric Card 2 -->
                        <div class="bg-surface-card p-7 rounded-lg border border-[#C3A46A]/20 border-t-4 border-t-botanical shadow-md flex flex-col justify-between hover:shadow-xl transition-all duration-200">
                            <div>
                                <span class="font-manrope text-4xl lg:text-5xl text-botanical font-extrabold">20</span>
                                <div class="w-8 h-1 bg-botanical/40 my-3.5"></div>
                            </div>
                            <div>
                                <h3 class="font-manrope font-bold text-base text-pine-heading mb-1">Acres Estate</h3>
                                <p class="font-inter text-xs sm:text-sm text-forest-slate leading-relaxed">Active demonstration cultivation acreage located at Wade, Bhadgaon.</p>
                            </div>
                        </div>

                        <!-- Metric Card 3 -->
                        <div class="bg-surface-card p-7 rounded-lg border border-[#C3A46A]/20 border-t-4 border-t-forest-deep shadow-md flex flex-col justify-between hover:shadow-xl transition-all duration-200">
                            <div>
                                <span class="font-manrope text-4xl lg:text-5xl text-forest-deep font-extrabold">193k+</span>
                                <div class="w-8 h-1 bg-forest-deep/40 my-3.5"></div>
                            </div>
                            <div>
                                <h3 class="font-manrope font-bold text-base text-pine-heading mb-1">Inputs Supplied</h3>
                                <p class="font-inter text-xs sm:text-sm text-forest-slate leading-relaxed">Verified saplings, soil fertilizers &amp; nutrition units dispatched.</p>
                            </div>
                        </div>

                        <!-- Metric Card 4 -->
                        <div class="bg-surface-card p-7 rounded-lg border border-[#C3A46A]/20 border-t-4 border-t-leaf-green shadow-md flex flex-col justify-between hover:shadow-xl transition-all duration-200">
                            <div>
                                <span class="font-manrope text-4xl lg:text-5xl text-leaf-green font-extrabold">100+</span>
                                <div class="w-8 h-1 bg-leaf-green/40 my-3.5"></div>
                            </div>
                            <div>
                                <h3 class="font-manrope font-bold text-base text-pine-heading mb-1">Cultivators</h3>
                                <p class="font-inter text-xs sm:text-sm text-forest-slate leading-relaxed">Active grower network partnering across the Jalgaon banana corridor.</p>
                            </div>
                        </div>

                        <!-- Metric Card 5 -->
                        <div class="bg-surface-card p-7 rounded-lg border border-[#C3A46A]/20 border-t-4 border-t-pine-charcoal shadow-md flex flex-col justify-between hover:shadow-xl transition-all duration-200 md:col-span-2 lg:col-span-1">
                            <div>
                                <span class="font-manrope text-4xl lg:text-5xl text-pine-charcoal font-extrabold">3</span>
                                <div class="w-8 h-1 bg-pine-charcoal/40 my-3.5"></div>
                            </div>
                            <div>
                                <h3 class="font-manrope font-bold text-base text-pine-heading mb-1">Core Pillars</h3>
                                <p class="font-inter text-xs sm:text-sm text-forest-slate leading-relaxed">Tissue plants, balanced crop nutrition &amp; trained harvest crews.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ============================================================
                 SECTION 5: OUR SERVICES (FOUR ELEVATED CRISP WHITE CARDS ON WARM CREAM)
                 ============================================================ -->
            <section class="w-full py-24 bg-cream-warm relative" id="services">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
                        <div>
                            <span class="font-inter text-xs font-bold uppercase tracking-widest text-botanical block mb-2">INTEGRATED AGRONOMY SOLUTIONS</span>
                            <h2 class="font-manrope text-3xl lg:text-4xl text-pine-heading font-extrabold">Complete Agricultural Support. <br><span class="text-botanical font-bold">From Planting to Harvesting.</span></h2>
                        </div>
                        <p class="font-inter text-base text-forest-slate max-w-md">Four dependable pillars empowering farmers from primary hardening nursery shoots to bunch protection and final domestic and foreign market consignments.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 items-stretch">
                        <!-- Service Card 1 -->
                        <div class="bg-surface-card rounded-xl overflow-hidden flex flex-col h-full border border-[#C3A46A]/25 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                            <div class="relative h-52 overflow-hidden bg-cream-warm">
                                <img alt="Banana tissue-culture saplings in nursery polyhouse" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= SITE_URL ?>/assets/images/service-tissue-culture.jpg">
                                <div class="absolute top-3.5 left-3.5">
                                    <span class="px-3 py-1 rounded bg-forest-dark/90 backdrop-blur-md text-leaf-green font-inter text-xs font-semibold uppercase tracking-wider border border-leaf-green/30">Primary Cultivation</span>
                                </div>
                            </div>
                            <div class="p-6 flex flex-col flex-grow justify-between gap-5 bg-white">
                                <div class="space-y-3">
                                    <h3 class="font-manrope text-xl text-pine-heading font-bold group-hover:text-botanical transition-colors leading-snug">Tissue-Culture Banana Plants</h3>
                                    <p class="font-inter text-sm text-forest-slate leading-relaxed">Certified virus-indexed G9 Grand Naine and Yelakki saplings cultivated under strict polyhouse hardening protocols.</p>
                                    <ul class="space-y-2 pt-2 border-t border-[#E9EFEA]">
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>High-yield disease-resistant stock</span>
                                        </li>
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Root-zone guidance &amp; hardening</span>
                                        </li>
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Government-accredited lab origin</span>
                                        </li>
                                    </ul>
                                </div>
                                <a class="inline-flex items-center justify-between w-full py-3 px-4 rounded bg-cream-warm border border-[#C3A46A]/30 text-botanical hover:bg-botanical hover:text-white font-manrope font-bold text-xs uppercase tracking-wider transition-all duration-200 mt-2 shadow-sm" href="#contact">
                                    <span>Inquire for Saplings</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>

                        <!-- Service Card 2 -->
                        <div class="bg-surface-card rounded-xl overflow-hidden flex flex-col h-full border border-[#C3A46A]/25 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                            <div class="relative h-52 overflow-hidden bg-cream-warm">
                                <img alt="Organic fertilizer and soil crop nutrition" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= SITE_URL ?>/assets/images/service-nutrition.jpg">
                                <div class="absolute top-3.5 left-3.5">
                                    <span class="px-3 py-1 rounded bg-forest-dark/90 backdrop-blur-md text-leaf-green font-inter text-xs font-semibold uppercase tracking-wider border border-leaf-green/30">Soil &amp; Nutrition</span>
                                </div>
                            </div>
                            <div class="p-6 flex flex-col flex-grow justify-between gap-5 bg-white">
                                <div class="space-y-3">
                                    <h3 class="font-manrope text-xl text-pine-heading font-bold group-hover:text-botanical transition-colors leading-snug">Specialized Crop Nutrition</h3>
                                    <p class="font-inter text-sm text-forest-slate leading-relaxed">Genuine macro and micronutrient regimens precision-matched to local soil chemistry and crop development stages.</p>
                                    <ul class="space-y-2 pt-2 border-t border-[#E9EFEA]">
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Authorised Yara &amp; MahaFeed distributor</span>
                                        </li>
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Mahadhan &amp; Bandhan nutrient lines</span>
                                        </li>
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Stage-wise precision fertigation charts</span>
                                        </li>
                                    </ul>
                                </div>
                                <a class="inline-flex items-center justify-between w-full py-3 px-4 rounded bg-cream-warm border border-[#C3A46A]/30 text-botanical hover:bg-botanical hover:text-white font-manrope font-bold text-xs uppercase tracking-wider transition-all duration-200 mt-2 shadow-sm" href="#contact">
                                    <span>View Nutrition Catalog</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>

                        <!-- Service Card 3 -->
                        <div class="bg-surface-card rounded-xl overflow-hidden flex flex-col h-full border border-[#C3A46A]/25 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                            <div class="relative h-52 overflow-hidden bg-cream-warm">
                                <img alt="Banana bunch bagging and fruit protection" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= SITE_URL ?>/assets/images/service-fruit-protection.jpg">
                                <div class="absolute top-3.5 left-3.5">
                                    <span class="px-3 py-1 rounded bg-forest-dark/90 backdrop-blur-md text-leaf-green font-inter text-xs font-semibold uppercase tracking-wider border border-leaf-green/30">Pre-Harvest Care</span>
                                </div>
                            </div>
                            <div class="p-6 flex flex-col flex-grow justify-between gap-5 bg-white">
                                <div class="space-y-3">
                                    <h3 class="font-manrope text-xl text-pine-heading font-bold group-hover:text-botanical transition-colors leading-snug">Fruit Care &amp; Bunch Protection</h3>
                                    <p class="font-inter text-sm text-forest-slate leading-relaxed">Specialized bunch bagging, foam separation, and sun-scorch shielding to deliver unblemished export-grade fruit.</p>
                                    <ul class="space-y-2 pt-2 border-t border-[#E9EFEA]">
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Zero-blemish export specification</span>
                                        </li>
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Sun-scorch &amp; thrips barrier bagging</span>
                                        </li>
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Breathable foam sleeve interleaving</span>
                                        </li>
                                    </ul>
                                </div>
                                <a class="inline-flex items-center justify-between w-full py-3 px-4 rounded bg-cream-warm border border-[#C3A46A]/30 text-botanical hover:bg-botanical hover:text-white font-manrope font-bold text-xs uppercase tracking-wider transition-all duration-200 mt-2 shadow-sm" href="#contact">
                                    <span>Explore Fruit Care</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>

                        <!-- Service Card 4 -->
                        <div class="bg-surface-card rounded-xl overflow-hidden flex flex-col h-full border border-[#C3A46A]/25 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                            <div class="relative h-52 overflow-hidden bg-cream-warm">
                                <img alt="Banana harvesting crew at farm" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= SITE_URL ?>/assets/images/service-harvesting.jpg">
                                <div class="absolute top-3.5 left-3.5">
                                    <span class="px-3 py-1 rounded bg-forest-dark/90 backdrop-blur-md text-earthy-gold font-inter text-xs font-semibold uppercase tracking-wider border border-earthy-gold/30">Post-Harvest Operations</span>
                                </div>
                            </div>
                            <div class="p-6 flex flex-col flex-grow justify-between gap-5 bg-white">
                                <div class="space-y-3">
                                    <h3 class="font-manrope text-xl text-pine-heading font-bold group-hover:text-botanical transition-colors leading-snug">Skilled Harvesting Services</h3>
                                    <p class="font-inter text-sm text-forest-slate leading-relaxed">Professionally trained field crews handling gentle bunch harvesting, careful de-handing, and dock-side foam padding.</p>
                                    <ul class="space-y-2 pt-2 border-t border-[#E9EFEA]">
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Calibrated export cutting windows</span>
                                        </li>
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Zero-bruising cushioned de-handing</span>
                                        </li>
                                        <li class="flex items-start gap-2 text-xs font-medium text-forest-slate">
                                            <span class="material-symbols-outlined text-[16px] text-botanical shrink-0 mt-0.5">check_circle</span>
                                            <span>Direct cold-chain transit dock loading</span>
                                        </li>
                                    </ul>
                                </div>
                                <a class="inline-flex items-center justify-between w-full py-3 px-4 rounded bg-cream-warm border border-[#C3A46A]/30 text-botanical hover:bg-botanical hover:text-white font-manrope font-bold text-xs uppercase tracking-wider transition-all duration-200 mt-2 shadow-sm" href="#contact">
                                    <span>Book Harvesting Crew</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ============================================================
                 SECTION 6: OUR FARMING & INFRASTRUCTURE (DEEP FOREST GREEN AUTHORITY SECTION)
                 ============================================================ -->
            <section class="w-full py-24 bg-forest-deep text-white relative border-y border-forest-dark" id="our-farms">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="max-w-3xl mb-12">
                        <span class="font-inter text-xs font-bold uppercase tracking-widest text-earthy-gold block mb-2">OUR 20-ACRE CULTIVATION ESTATE • BHADGAON, JALGAON</span>
                        <h2 class="font-manrope text-3xl lg:text-4xl text-white font-extrabold">Where Agricultural Experience Meets Modern Farming.</h2>
                    </div>

                    <!-- Main Visual Estate Showcase -->
                    <div class="relative w-full h-[450px] lg:h-[520px] rounded-lg overflow-hidden mb-12 shadow-2xl border border-white/10">
                        <img alt="Model banana farm in Jalgaon" class="w-full h-full object-cover" data-alt="Expansive wide landscape of model banana farm" src="<?= SITE_URL ?>/assets/images/estate-farm.jpg">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-dark/95 via-forest-deep/50 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 lg:bottom-10 lg:left-10 lg:right-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
                            <div class="max-w-xl">
                                <span class="px-3 py-1 rounded bg-botanical text-white font-inter text-xs font-bold uppercase tracking-wider border border-white/20">Active Demonstration Plot</span>
                                <h3 class="font-manrope text-2xl lg:text-3xl text-white font-bold mt-2">Bhadgaon Central Demonstration Acreage</h3>
                                <p class="font-inter text-sm text-cream-warm/85 mt-1 leading-relaxed">A real-world proving ground where precision fertilization regimens, irrigation frequencies, and disease management are tested before farmer rollout.</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="px-4 py-2 rounded bg-forest-dark/80 backdrop-blur-md border border-earthy-gold/40 text-cream-warm font-inter text-xs font-semibold">
                                    LAT: 20.67° N • LON: 75.22° E
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3 Supporting Infrastructure Detail Modules -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="p-6 rounded-lg bg-white/5 backdrop-blur-md border border-white/10 border-l-4 border-l-earthy-gold">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center bg-earthy-gold/20 text-earthy-gold mb-4">
                                <span class="material-symbols-outlined text-[24px]">water_drop</span>
                            </div>
                            <h4 class="font-manrope text-lg text-white font-bold mb-2">Micro-Drip &amp; Fertigation</h4>
                            <p class="font-inter text-sm text-cream-warm/80 leading-relaxed">
                                Ensuring optimal root aeration, uniform nutrient delivery directly to feeder roots, and 40% water conservation across all 20 acres.
                            </p>
                        </div>
                        <div class="p-6 rounded-lg bg-white/5 backdrop-blur-md border border-white/10 border-l-4 border-l-leaf-green">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center bg-leaf-green/20 text-leaf-green mb-4">
                                <span class="material-symbols-outlined text-[24px]">ac_unit</span>
                            </div>
                            <h4 class="font-manrope text-lg text-white font-bold mb-2">Cold-Chain Transit Readiness</h4>
                            <p class="font-inter text-sm text-cream-warm/80 leading-relaxed">
                                On-field shade structures, rapid foam wrapping, and synchronized logistics transfer to temperature-controlled reefers prevent heat stress.
                            </p>
                        </div>
                        <div class="p-6 rounded-lg bg-white/5 backdrop-blur-md border border-white/10 border-l-4 border-l-botanical">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center bg-botanical/30 text-white mb-4">
                                <span class="material-symbols-outlined text-[24px]">biotech</span>
                            </div>
                            <h4 class="font-manrope text-lg text-white font-bold mb-2">Field Soil Lab Diagnostics</h4>
                            <p class="font-inter text-sm text-cream-warm/80 leading-relaxed">
                                Routine testing of electrical conductivity, nitrogen leaching, and rhizosphere pH under scientific chemistry oversight to prevent salt crusting.
                            </p>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ============================================================
                 SECTION 7: WHY GIRNA GLOBAL? (WARM CREAM CANVAS WITH CRISP WHITE CARDS)
                 ============================================================ -->
            <section class="w-full py-24 bg-cream-warm relative">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-botanical-light border border-botanical/20 mb-3">
                            <span class="w-2 h-2 rounded-full bg-leaf-green animate-pulse"></span>
                            <span class="font-inter text-xs font-semibold uppercase tracking-widest text-botanical">THE GIRNA GLOBAL ADVANTAGE</span>
                        </div>
                        <h2 class="font-manrope text-3xl md:text-4xl lg:text-5xl font-extrabold text-forest-deep tracking-tight mt-3 mb-4">The Pillars of Girna Global</h2>
                        <p class="font-inter text-base md:text-lg text-forest-slate max-w-2xl mx-auto font-medium leading-relaxed">Built on farming roots. Focused on farmer growth.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 items-stretch divide-y md:divide-y-0 md:divide-x divide-[#C3A46A]/25">
                        <div class="flex flex-col items-center text-center px-6 py-8 group transition-all duration-300">
                            <div class="w-16 h-16 rounded-full border border-botanical/30 bg-white/80 shadow-sm flex items-center justify-center mx-auto mb-6 text-botanical group-hover:border-botanical group-hover:scale-110 group-hover:bg-botanical group-hover:text-white transition-all duration-300">
                                <span class="material-symbols-outlined text-[32px]">potted_plant</span>
                            </div>
                            <span class="font-inter text-xs font-bold text-earthy-gold tracking-widest uppercase mb-2">01</span>
                            <h3 class="font-manrope text-sm md:text-base font-bold text-forest-deep tracking-wide leading-snug mb-3 uppercase group-hover:text-botanical transition-colors">25 YEARS OF FARMING ROOTS</h3>
                            <p class="font-inter text-xs md:text-sm text-forest-slate leading-relaxed">A 25-year family farming legacy, backed by hands-on agricultural experience and our 20-acre cultivation estate.</p>
                        </div>

                        <div class="flex flex-col items-center text-center px-6 py-8 group transition-all duration-300">
                            <div class="w-16 h-16 rounded-full border border-botanical/30 bg-white/80 shadow-sm flex items-center justify-center mx-auto mb-6 text-botanical group-hover:border-botanical group-hover:scale-110 group-hover:bg-botanical group-hover:text-white transition-all duration-300">
                                <span class="material-symbols-outlined text-[32px]">science</span>
                            </div>
                            <span class="font-inter text-xs font-bold text-earthy-gold tracking-widest uppercase mb-2">02</span>
                            <h3 class="font-manrope text-sm md:text-base font-bold text-forest-deep tracking-wide leading-snug mb-3 uppercase group-hover:text-botanical transition-colors">SCIENCE-GUIDED CROP NUTRITION</h3>
                            <p class="font-inter text-xs md:text-sm text-forest-slate leading-relaxed">Combining scientific knowledge with carefully selected fertilizers and soil-nutrition solutions for crop needs.</p>
                        </div>

                        <div class="flex flex-col items-center text-center px-6 py-8 group transition-all duration-300">
                            <div class="w-16 h-16 rounded-full border border-botanical/30 bg-white/80 shadow-sm flex items-center justify-center mx-auto mb-6 text-botanical group-hover:border-botanical group-hover:scale-110 group-hover:bg-botanical group-hover:text-white transition-all duration-300">
                                <span class="material-symbols-outlined text-[32px]">all_inclusive</span>
                            </div>
                            <span class="font-inter text-xs font-bold text-earthy-gold tracking-widest uppercase mb-2">03</span>
                            <h3 class="font-manrope text-sm md:text-base font-bold text-forest-deep tracking-wide leading-snug mb-3 uppercase group-hover:text-botanical transition-colors">SUPPORT ACROSS THE CROP LIFECYCLE</h3>
                            <p class="font-inter text-xs md:text-sm text-forest-slate leading-relaxed">From tissue-culture banana plants and planting guidance to crop nutrition and G9 and Yelakki harvesting.</p>
                        </div>

                        <div class="flex flex-col items-center text-center px-6 py-8 group transition-all duration-300">
                            <div class="w-16 h-16 rounded-full border border-botanical/30 bg-white/80 shadow-sm flex items-center justify-center mx-auto mb-6 text-botanical group-hover:border-botanical group-hover:scale-110 group-hover:bg-botanical group-hover:text-white transition-all duration-300">
                                <span class="material-symbols-outlined text-[32px]">handshake</span>
                            </div>
                            <span class="font-inter text-xs font-bold text-earthy-gold tracking-widest uppercase mb-2">04</span>
                            <h3 class="font-manrope text-sm md:text-base font-bold text-forest-deep tracking-wide leading-snug mb-3 uppercase group-hover:text-botanical transition-colors">FARMER-FIRST PARTNERSHIPS</h3>
                            <p class="font-inter text-xs md:text-sm text-forest-slate leading-relaxed">Building dependable relationships through genuine agricultural inputs, fair pricing and practical farmer support.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ============================================================
                 SECTION 9: FARMER TESTIMONIALS (WARM CREAM CANVAS WITH CRISP WHITE CARDS)
                 ============================================================ -->
            <section class="w-full py-24 bg-cream-warm relative" id="testimonials">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="max-w-3xl mb-16">
                        <span class="font-inter text-xs font-bold uppercase tracking-widest text-botanical block mb-2">VOICES FROM THE GIRNA BELT</span>
                        <h2 class="font-manrope text-3xl lg:text-4xl text-pine-heading font-extrabold">Trusted Relationships. Real Experiences.</h2>
                        <p class="font-inter text-base text-forest-slate mt-2">Every testimonial represents a cultivator we stand beside through monsoons, heatwaves, and harvest markets.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Review 1 -->
                        <div class="bg-surface-card rounded-lg p-8 flex flex-col justify-between border border-[#C3A46A]/20 border-t-4 border-t-botanical shadow-lg relative">
                            <div>
                                <div class="flex items-center gap-1 text-earthy-gold mb-6">
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                </div>
                                <p class="font-inter text-sm sm:text-base text-pine-heading italic leading-relaxed mb-6 font-normal">
                                    “Girna Global sourced our tissue-culture saplings and stayed with us through the whole season. Their planting schedule and nutrition advice transformed our bunch sizes.”
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#C3A46A]/20">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-leaf-green"></span>
                                    <span class="font-inter text-xs uppercase tracking-wider text-botanical font-bold">Verified Banana Cultivator</span>
                                </div>
                                <h4 class="font-manrope font-bold text-base text-pine-heading">Bhuvanesh Chaudhari</h4>
                                <span class="font-inter text-xs text-forest-slate">Pachora, Jalgaon</span>
                            </div>
                        </div>

                        <!-- Review 2 -->
                        <div class="bg-surface-card rounded-lg p-8 flex flex-col justify-between border border-[#C3A46A]/20 border-t-4 border-t-leaf-green shadow-lg relative">
                            <div>
                                <div class="flex items-center gap-1 text-earthy-gold mb-6">
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                </div>
                                <p class="font-inter text-sm sm:text-base text-pine-heading italic leading-relaxed mb-6 font-normal">
                                    “Genuine fertilizer, fair pricing, and they actually pick up the phone during harvest season when timing is critical. Truly dependable partners in the Shirpur belt.”
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#C3A46A]/20">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-leaf-green"></span>
                                    <span class="font-inter text-xs uppercase tracking-wider text-botanical font-bold">Commercial Farm Owner</span>
                                </div>
                                <h4 class="font-manrope font-bold text-base text-pine-heading">Pranav Chaudhari</h4>
                                <span class="font-inter text-xs text-forest-slate">Farm Owner, Shirpur</span>
                            </div>
                        </div>

                        <!-- Review 3 -->
                        <div class="bg-surface-card rounded-lg p-8 flex flex-col justify-between border border-[#C3A46A]/20 border-t-4 border-t-earthy-gold shadow-lg relative">
                            <div>
                                <div class="flex items-center gap-1 text-earthy-gold mb-6">
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                    <span class="material-symbols-outlined text-[20px] fill-1">star</span>
                                </div>
                                <p class="font-inter text-sm sm:text-base text-pine-heading italic leading-relaxed mb-6 font-normal">
                                    “Their harvesting team knows G9 and Yelakki timing better than most local contractors. Zero bruising during cutting, careful foam wrapping, and quick dispatch.”
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#C3A46A]/20">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-leaf-green"></span>
                                    <span class="font-inter text-xs uppercase tracking-wider text-botanical font-bold">Field Operations Head</span>
                                </div>
                                <h4 class="font-manrope font-bold text-base text-pine-heading">Kiran Thakre</h4>
                                <span class="font-inter text-xs text-forest-slate">Farm Operations Manager, Bhadgaon</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ============================================================
                 SECTION 10: ESTATE LOCATION & LOGISTICS
                 ============================================================ -->
            <section class="w-full py-20 lg:py-24 bg-canvas-soft relative border-t border-[#C3A46A]/20" id="location">
                <div class="max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-botanical-light border border-botanical/20 mb-3">
                                <span class="w-2 h-2 rounded-full bg-leaf-green animate-pulse"></span>
                                <span class="font-inter text-xs font-bold uppercase tracking-widest text-botanical">ESTATE LOCATION &amp; LOGISTICS</span>
                            </div>
                            <h2 class="font-manrope text-3xl sm:text-4xl lg:text-5xl font-extrabold text-pine-heading tracking-tight leading-tight">
                                Visit Our Cultivation Estate <br class="hidden sm:block">
                                <span class="text-botanical font-bold">&amp; Registered Facility.</span>
                            </h2>
                        </div>
                        <div class="max-w-md">
                            <p class="font-inter text-sm sm:text-base text-forest-slate leading-relaxed">Strategically located in Maharashtra's fertile Jalgaon banana belt, our 20-acre hub integrates research nurseries, soil chemistry testing, and direct dock-side cold-chain dispatch.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">
                        <!-- Map Column -->
                        <div class="lg:col-span-7 flex flex-col justify-between rounded-xl overflow-hidden bg-white border border-[#C3A46A]/30 shadow-xl">
                            <div class="relative w-full h-[340px] sm:h-[400px] overflow-hidden bg-forest-deep">
                                <iframe title="Girna Global Farm Estate Map Location" src="https://www.google.com/maps?q=Bhadgaon,+Jalgaon,+Maharashtra,+India&amp;output=embed" class="w-full h-full border-0 filter saturate-150 contrast-105 opacity-90" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <div class="absolute top-4 left-4 bg-forest-dark/90 backdrop-blur-md px-3.5 py-2 rounded border border-earthy-gold/40 text-cream-warm shadow-lg">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-earthy-gold text-[18px]">pin_drop</span>
                                        <span class="font-inter text-xs font-semibold uppercase tracking-wider">Bhadgaon Demonstration Plot</span>
                                    </div>
                                    <p class="font-inter text-[11px] text-cream-warm/75 mt-0.5">LAT: 20.47° N • LON: 75.23° E</p>
                                </div>
                                <div class="absolute bottom-4 right-4">
                                    <a class="inline-flex items-center gap-2 px-4 py-2.5 rounded bg-botanical text-white font-manrope font-bold text-xs uppercase tracking-wider shadow-xl hover:bg-botanical-dark transition-colors border border-white/20" href="https://maps.app.goo.gl/cMD6xV6G1HW9pzSJA" rel="noopener noreferrer" target="_blank">
                                        <span>Open in Google Maps</span>
                                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                    </a>
                                </div>
                            </div>
                            <div class="p-6 sm:p-8 bg-white border-t border-[#C3A46A]/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-2 text-botanical mb-1">
                                        <span class="material-symbols-outlined text-[20px]">distance</span>
                                        <span class="font-inter text-xs uppercase tracking-wider font-bold text-pine-heading">Estate Postal Address</span>
                                    </div>
                                    <p class="font-inter text-sm font-semibold text-pine-heading">At post Wade, Tal. Bhadgaon, Dist. Jalgaon - 424201</p>
                                    <p class="font-inter text-xs text-forest-slate/80 mt-0.5">Maharashtra, India • Accessible via NH-753J &amp; Pachora Rail Junction</p>
                                </div>
                                <a class="px-5 py-3 rounded bg-cream-warm border border-[#C3A46A]/30 text-botanical hover:bg-botanical hover:text-white font-manrope font-bold text-xs uppercase tracking-wider transition-all duration-200 shrink-0 flex items-center gap-2 shadow-sm" href="https://maps.app.goo.gl/cMD6xV6G1HW9pzSJA" rel="noopener noreferrer" target="_blank">
                                    <span>Get Directions</span>
                                    <span class="material-symbols-outlined text-[16px]">turn_right</span>
                                </a>
                            </div>
                        </div>

                        <!-- Facilities & Visit Booking Column -->
                        <div class="lg:col-span-5 flex flex-col justify-between gap-6">
                            <div class="bg-surface-card rounded-xl p-6 sm:p-7 border border-[#C3A46A]/25 border-l-4 border-l-botanical shadow-md">
                                <h3 class="font-manrope text-lg font-bold text-pine-heading mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-botanical text-[22px]">domain</span>
                                    <span>On-Site Operational Facilities</span>
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-botanical-light text-botanical flex items-center justify-center shrink-0 mt-0.5">
                                            <span class="material-symbols-outlined text-[18px]">nature</span>
                                        </div>
                                        <div>
                                            <h4 class="font-manrope text-sm font-bold text-pine-heading">20-Acre Central Demonstration Acreage</h4>
                                            <p class="font-inter text-xs text-forest-slate mt-0.5">Field proving grounds for certified G9 &amp; Yelakki tissue culture planting regimens.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-botanical-light text-botanical flex items-center justify-center shrink-0 mt-0.5">
                                            <span class="material-symbols-outlined text-[18px]">shield</span>
                                        </div>
                                        <div>
                                            <h4 class="font-manrope text-sm font-bold text-pine-heading">Polyhouse Shade-Net Hardening Facility</h4>
                                            <p class="font-inter text-xs text-forest-slate mt-0.5">Climate-controlled secondary hardening sapling bays for virus-free stock distribution.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-botanical-light text-botanical flex items-center justify-center shrink-0 mt-0.5">
                                            <span class="material-symbols-outlined text-[18px]">ac_unit</span>
                                        </div>
                                        <div>
                                            <h4 class="font-manrope text-sm font-bold text-pine-heading">Cold-Chain Transit &amp; Export Dispatch Dock</h4>
                                            <p class="font-inter text-xs text-forest-slate mt-0.5">Cushioned fruit packaging, dockside sorting, and pre-cooling logistical access.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-botanical-light text-botanical flex items-center justify-center shrink-0 mt-0.5">
                                            <span class="material-symbols-outlined text-[18px]">biotech</span>
                                        </div>
                                        <div>
                                            <h4 class="font-manrope text-sm font-bold text-pine-heading">On-Site Agronomy &amp; Soil Testing Lab</h4>
                                            <p class="font-inter text-xs text-forest-slate mt-0.5">Equipped for precision rapid pH and EC diagnostics to optimize soil fertility.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-forest-deep rounded-xl p-6 sm:p-7 border border-[#C3A46A]/30 text-white shadow-xl flex flex-col justify-between gap-4">
                                <div>
                                    <span class="font-inter text-[11px] font-bold uppercase tracking-widest text-earthy-gold block mb-1">GROWER &amp; EXPORTER FIELD VISITS</span>
                                    <h4 class="font-manrope text-base sm:text-lg font-bold text-white leading-snug">Schedule an Estate Demonstration Walkthrough</h4>
                                    <p class="font-inter text-xs text-cream-warm/80 mt-1 leading-relaxed">Field visits are conducted Monday to Saturday (8:00 AM – 6:00 PM). Cultivator groups and export sourcing partners are welcome by appointment.</p>
                                </div>
                                <div class="flex items-center gap-3 pt-2">
                                    <a class="px-4 py-2.5 rounded bg-leaf-green hover:bg-earthy-gold text-forest-dark font-manrope font-bold text-xs uppercase tracking-wider transition-colors inline-flex items-center gap-2 shadow-md" href="tel:+919100556355">
                                        <span class="material-symbols-outlined text-[18px]">call</span>
                                        <span>Book Visit Call</span>
                                    </a>
                                    <a class="px-4 py-2.5 rounded bg-white/10 hover:bg-white/20 border border-white/20 text-white font-manrope font-bold text-xs uppercase tracking-wider transition-colors inline-flex items-center gap-2" href="https://wa.me/919100556355?text=Hello%20Girna%20Global,%20I%20would%20like%20to%20schedule%20a%20visit%20to%20the%20Bhadgaon%20farm%20estate" rel="noopener noreferrer" target="_blank">
                                        <span class="material-symbols-outlined text-[18px]">chat</span>
                                        <span>WhatsApp</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ============================================================
                 SECTION 11: COMMERCIAL DESK & FARM ADVISORY (CONTACT & ENQUIRY)
                 ============================================================ -->
            <section class="w-full py-24 bg-forest-deep text-white relative overflow-hidden border-t border-forest-dark" id="contact">
                <!-- Atmospheric plantation silhouette overlay -->
                <div class="absolute inset-0 z-0 bg-cover bg-center opacity-15" data-alt="Dense banana plantation farm landscape" style="background-image: url('<?= SITE_URL ?>/assets/images/hero-bg.jpg');"></div>
                <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                        
                        <!-- Left: Direct Communication & Brand Guarantee -->
                        <div class="lg:col-span-5 flex flex-col justify-between">
                            <div>
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-forest-dark/80 text-earthy-gold font-inter text-xs font-bold uppercase tracking-wider mb-4 border border-earthy-gold/30">
                                    COMMERCIAL DESK &amp; FARM ADVISORY
                                </div>
                                <h2 class="font-manrope text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4">
                                    Let's Grow <br><span class="text-earthy-gold">Together.</span>
                                </h2>
                                <p class="font-inter text-base text-cream-warm/85 leading-relaxed mb-8">
                                    Looking for certified banana plants, genuine fertilizer supply batches, or experienced harvesting teams? Connect with Girna Global and explore how we support your next harvest cycle.
                                </p>

                                <!-- Direct Contact Anchors -->
                                <div class="space-y-4">
                                    <a class="flex items-center gap-4 p-4 rounded-lg bg-white/10 hover:bg-white/15 border border-white/10 transition-colors group" href="tel:+919100556355">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-earthy-gold text-forest-dark font-bold shrink-0 group-hover:scale-105 transition-transform">
                                            <span class="material-symbols-outlined text-[20px]">phone</span>
                                        </div>
                                        <div>
                                            <span class="font-inter text-xs text-cream-warm/75 uppercase tracking-wider font-semibold">Direct Phone Support</span>
                                            <p class="font-manrope font-bold text-base text-white">+91 9100556355</p>
                                        </div>
                                    </a>

                                    <a class="flex items-center gap-4 p-4 rounded-lg bg-botanical hover:bg-botanical-dark border border-botanical transition-colors group shadow-lg" href="https://wa.me/919100556355?text=Hello%20Girna%20Global,%20I%20have%20an%20enquiry" rel="noopener noreferrer" target="_blank">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white text-botanical shrink-0 font-bold group-hover:scale-105 transition-transform">
                                            <span class="material-symbols-outlined text-[20px]">chat</span>
                                        </div>
                                        <div>
                                            <span class="font-inter text-xs text-cream-warm uppercase tracking-wider font-semibold">Instant Chat</span>
                                            <p class="font-manrope font-bold text-base text-white">WhatsApp Direct Link</p>
                                        </div>
                                    </a>

                                    <a class="flex items-center gap-4 p-4 rounded-lg bg-white/10 hover:bg-white/15 border border-white/10 transition-colors group" href="mailto:girnaglobal5@gmail.com">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-leaf-green text-forest-dark shrink-0 font-bold group-hover:scale-105 transition-transform">
                                            <span class="material-symbols-outlined text-[20px]">mail</span>
                                        </div>
                                        <div>
                                            <span class="font-inter text-xs text-cream-warm/75 uppercase tracking-wider font-semibold">Official Inquiries</span>
                                            <p class="font-manrope font-bold text-base text-white">girnaglobal5@gmail.com</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-white/15">
                                <span class="font-inter text-xs text-earthy-gold uppercase tracking-widest font-bold block mb-1">REGISTERED FARM ESTATE</span>
                                <p class="font-inter text-xs text-cream-warm/80">At post Wade, Tal. Bhadgaon, Dist. Jalgaon - 424201, Maharashtra, India.</p>
                            </div>
                        </div>

                        <!-- Right: Inquiry Form Card -->
                        <div class="lg:col-span-7 bg-white rounded-lg p-8 lg:p-10 border border-[#C3A46A]/40 shadow-2xl text-forest-slate">
                            <h3 class="font-manrope text-2xl text-pine-heading font-extrabold mb-1">Tell Us What Your Farm Needs</h3>
                            <p class="font-inter text-sm text-forest-slate/90 mb-8">Send an enquiry and our field team will contact you within 24 working hours.</p>

                            <?php if ($inquirySuccess): ?>
                                <div class="p-4 rounded-lg bg-botanical-light border border-botanical text-botanical font-medium mb-6 flex items-center gap-3">
                                    <span class="material-symbols-outlined text-botanical text-[24px]">check_circle</span>
                                    <span>Thank you! Your enquiry has been received. Our team will reach out within 24 working hours.</span>
                                </div>
                            <?php elseif ($inquiryError): ?>
                                <div class="p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm mb-6">
                                    <?= e($inquiryError) ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?= SITE_URL ?>/#contact" method="POST" class="space-y-6" id="enquiry-form">
                                <input type="hidden" name="action" value="submit_inquiry">
                                <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block font-inter text-xs uppercase tracking-wider text-pine-heading font-bold mb-2">Full Name *</label>
                                        <input class="w-full px-4 py-3 rounded bg-canvas-soft border border-[#C3A46A]/30 focus:border-botanical focus:ring-1 focus:ring-botanical text-pine-heading placeholder:text-forest-slate/40 font-inter text-sm focus:outline-none transition-colors" name="name" placeholder="e.g. Ramesh Patil" required="" type="text">
                                    </div>
                                    <div>
                                        <label class="block font-inter text-xs uppercase tracking-wider text-pine-heading font-bold mb-2">Phone Number *</label>
                                        <input class="w-full px-4 py-3 rounded bg-canvas-soft border border-[#C3A46A]/30 focus:border-botanical focus:ring-1 focus:ring-botanical text-pine-heading placeholder:text-forest-slate/40 font-inter text-sm focus:outline-none transition-colors" name="phone" placeholder="+91 9876543210" required="" type="tel">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block font-inter text-xs uppercase tracking-wider text-pine-heading font-bold mb-2">Email Address</label>
                                        <input class="w-full px-4 py-3 rounded bg-canvas-soft border border-[#C3A46A]/30 focus:border-botanical focus:ring-1 focus:ring-botanical text-pine-heading placeholder:text-forest-slate/40 font-inter text-sm focus:outline-none transition-colors" name="email" placeholder="ramesh@gmail.com" type="email">
                                    </div>
                                    <div>
                                        <label class="block font-inter text-xs uppercase tracking-wider text-pine-heading font-bold mb-2">Service Interested In *</label>
                                        <select class="w-full px-4 py-3 rounded bg-canvas-soft border border-[#C3A46A]/30 focus:border-botanical focus:ring-1 focus:ring-botanical text-pine-heading font-inter text-sm focus:outline-none transition-colors" name="service" required="">
                                            <option class="bg-white text-pine-heading" value="banana-plants">Tissue-Culture Banana Plants (G9 / Yelakki)</option>
                                            <option class="bg-white text-pine-heading" value="fertilizers">Fertilizer &amp; Soil Nutrition Supply</option>
                                            <option class="bg-white text-pine-heading" value="harvesting">Specialized Harvesting Crew Booking</option>
                                            <option class="bg-white text-pine-heading" value="export-advisory">Export Supply &amp; Consolidation Partnership</option>
                                            <option class="bg-white text-pine-heading" value="other">Other Farm Advisory Requirement</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-inter text-xs uppercase tracking-wider text-pine-heading font-bold mb-2">Requirements / Acreage Details</label>
                                    <textarea class="w-full px-4 py-3 rounded bg-canvas-soft border border-[#C3A46A]/30 focus:border-botanical focus:ring-1 focus:ring-botanical text-pine-heading placeholder:text-forest-slate/40 font-inter text-sm focus:outline-none transition-colors" name="message" placeholder="Mention your location, crop acreage, or specific fertilizer requirements..." rows="4"></textarea>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input class="w-4 h-4 rounded accent-botanical" id="consent" required="" type="checkbox">
                                    <label class="font-inter text-xs text-forest-slate" for="consent">I authorize Girna Global representative to call or message me regarding this agricultural enquiry.</label>
                                </div>

                                <button class="w-full py-4 rounded bg-botanical text-white font-manrope font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-botanical-dark transition-colors flex items-center justify-center gap-2 shadow-lg" type="submit">
                                    <span>Submit Commercial Enquiry</span>
                                    <span class="material-symbols-outlined text-[20px]">send</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>


    <!-- ============================================================
         SECTION 12: FOOTER (DEEP FOREST DARK WITH GOLD STROKES)
         ============================================================ -->
    <footer class="w-full bg-forest-dark text-white border-t border-forest-deep">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 pt-16 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12">
                
                <!-- Col 1: Brand Story & Leadership -->
                <div class="lg:col-span-4 flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <img alt="Girna Global Logo" class="h-9 w-9 object-contain rounded-full bg-white p-0.5 shadow-sm" src="<?= SITE_URL ?>/assets/images/logo.png">
                        <div class="flex flex-col">
                            <span class="font-manrope font-extrabold text-base uppercase tracking-wider text-white leading-none">GIRNA GLOBAL</span>
                            <span class="text-[10px] uppercase font-bold tracking-widest text-earthy-gold mt-0.5">FARM TO FOREIGN</span>
                        </div>
                    </div>
                    <p class="font-inter text-xs sm:text-sm text-cream-warm/80 max-w-sm leading-relaxed">
                        Backed by a 25-year family farming heritage in the Jalgaon banana belt, connecting authentic local agricultural excellence directly to foreign and domestic markets.
                    </p>
                    <div class="flex flex-col gap-1 mt-2">
                        <span class="font-inter text-xs uppercase tracking-wider text-earthy-gold font-bold">Proprietorship</span>
                        <span class="font-inter text-xs sm:text-sm text-white font-medium">Girna Global Leadership</span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="lg:col-span-2 flex flex-col gap-4">
                    <span class="font-manrope font-bold text-sm text-earthy-gold uppercase tracking-wider">Quick Links</span>
                    <ul class="flex flex-col gap-2.5">
                        <li class="list-none"><a class="font-inter text-xs sm:text-sm text-cream-warm/80 hover:text-white transition-colors" data-path="home" href="<?= SITE_URL ?>/">Home</a></li>
                        <li class="list-none"><a class="font-inter text-xs sm:text-sm text-cream-warm/80 hover:text-white transition-colors" data-path="about-us" href="#about-us">About Us</a></li>
                        <li class="list-none"><a class="font-inter text-xs sm:text-sm text-cream-warm/80 hover:text-white transition-colors" data-path="services" href="#services">Services</a></li>
                        <li class="list-none"><a class="font-inter text-xs sm:text-sm text-cream-warm/80 hover:text-white transition-colors" data-path="our-farms" href="#our-farms">Our Farms</a></li>
                        <li class="list-none"></li>
                        <li class="list-none"><a class="font-inter text-xs sm:text-sm text-cream-warm/80 hover:text-white transition-colors" data-path="testimonials" href="#testimonials">Testimonials</a></li>
                        <li class="list-none"><a class="font-inter text-xs sm:text-sm text-cream-warm/80 hover:text-white transition-colors" data-path="contact" href="#contact">Contact</a></li>
                    </ul>
                </div>

                <!-- Col 3: Core Services -->
                <div class="lg:col-span-3 flex flex-col gap-4">
                    <span class="font-manrope font-bold text-sm text-earthy-gold uppercase tracking-wider">Services</span>
                    <ul class="flex flex-col gap-2.5">
                        <li class="list-none font-inter text-xs sm:text-sm text-cream-warm/80 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-earthy-gold"></span>
                            <span>Banana Tissue-Culture Plants</span>
                        </li>
                        <li class="list-none font-inter text-xs sm:text-sm text-cream-warm/80 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-leaf-green"></span>
                            <span>Crop Nutrition &amp; Fertilizer</span>
                        </li>
                        <li class="list-none font-inter text-xs sm:text-sm text-cream-warm/80 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-botanical"></span>
                            <span>G9 &amp; Yelakki Harvesting Support</span>
                        </li>
                        <li class="list-none font-inter text-xs sm:text-sm text-cream-warm/80 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-earthy-gold"></span>
                            <span>Cold-Chain Transit Consolidation</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Direct Contact Info -->
                <div class="lg:col-span-3 flex flex-col gap-4">
                    <span class="font-manrope font-bold text-sm text-earthy-gold uppercase tracking-wider">Direct Contact Info</span>
                    <div class="flex flex-col gap-3 text-xs sm:text-sm font-inter text-cream-warm/80">
                        <div class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-earthy-gold text-[18px] mt-0.5 shrink-0">location_on</span>
                            <span>At post Wade, Tal. Bhadgaon, Dist. Jalgaon - 424201, Maharashtra, India.</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-earthy-gold text-[18px] shrink-0">phone</span>
                            <a class="hover:text-white transition-colors" href="tel:+919100556355">+91 9100556355</a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-earthy-gold text-[18px] shrink-0">mail</span>
                            <a class="hover:text-white transition-colors" href="mailto:girnaglobal5@gmail.com">girnaglobal5@gmail.com</a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-leaf-green text-[18px] shrink-0">chat</span>
                            <a class="text-leaf-green hover:text-white transition-colors font-semibold" href="https://wa.me/919100556355" rel="noopener noreferrer" target="_blank">WhatsApp Direct Chat</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Legal Bar -->
            <div class="mt-16 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-cream-warm/60 font-inter text-xs">
                <p>© 2026 Girna Global. All rights reserved.</p>
                <div class="flex items-center gap-4 flex-wrap justify-center">
                    <a class="hover:text-white transition-colors" data-path="privacy-policy" href="<?= SITE_URL ?>/privacy.php">Privacy Policy</a>
                    <span class="text-white/20">|</span>
                    <a class="hover:text-white transition-colors" data-path="terms-and-conditions" href="<?= SITE_URL ?>/terms.php">Terms &amp; Conditions</a>
                    <span class="text-white/20">|</span>
                    <a class="hover:text-white transition-colors" data-path="admin-login" href="<?= SITE_URL ?>/admin/login.php">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Action Button -->
    <a href="https://wa.me/919100556355?text=Hello%20Girna%20Global,%20I%20have%20an%20export%20inquiry" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 right-6 z-40 bg-botanical hover:bg-botanical-dark text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center wa-pulse-btn transition-transform hover:scale-110 border-2 border-earthy-gold/60" aria-label="Chat on WhatsApp with Girna Global">
        <span class="material-symbols-outlined text-[28px]">chat</span>
    </a>

    <!-- Interactive Scripts -->
    <script>
    // Header shadow on scroll
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            header.classList.add('shadow-md');
        } else {
            header.classList.remove('shadow-md');
        }
    });

    // Mobile Drawer Navigation Toggle
    const mobileBtn = document.getElementById('mobile-menu-toggle');
    const mobileClose = document.getElementById('mobile-drawer-close');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    const mobileNavItems = document.querySelectorAll('.mobile-nav-item');

    function openMobileMenu() {
        mobileDrawer.classList.remove('translate-x-full');
        mobileBackdrop.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMobileMenu() {
        mobileDrawer.classList.add('translate-x-full');
        mobileBackdrop.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    if (mobileBtn) mobileBtn.addEventListener('click', openMobileMenu);
    if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
    if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileMenu);

    mobileNavItems.forEach(item => {
        item.addEventListener('click', closeMobileMenu);
    });
    </script>
</body>
</html>
