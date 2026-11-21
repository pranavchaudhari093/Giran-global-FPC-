# Girna Global FPC - Official Website & Digital Platform

A production-ready, ultra-premium corporate website and custom CMS engineered for **Girna Global** (banana exports, bio-fertilizers, and contract farming). 

Built specifically for standard shared hosting compatibility (Hostinger, cPanel, Bluehost) using **PHP 8+**, **MySQL**, **HTML5**, **Vanilla CSS3**, and **ES6 JavaScript**. 

Zero external heavy framework dependencies (No React, Node, Firebase, or Cloudinary required).

---

## Technical Stack & Architecture

- **Frontend**: HTML5, CSS3 with CSS custom properties (variables), Glassmorphic luxury cards, Responsive grid breakpoints (320px to 1920px), ES6 JavaScript.
- **Backend**: PHP 8+ (PDO Database singleton, CSRF tokens, Prepared statements, XSS escaping, Session security).
- **Database**: MySQL 5.7 / 8.0 / MariaDB 10.4+ InnoDB database.
- **Email Engine**: PHPMailer / Gmail SMTP & Hostinger native mailer fallback.
- **Storage**: Local server storage under `/uploads/` with automated file cleanup.

---

## Directory & File Architecture

```
GIRNA GLOBAL WEBSITE/
├── admin/
│   ├── includes/
│   │   ├── header.php
│   │   ├── sidebar.php
│   │   └── footer.php
│   ├── clients.php
│   ├── gallery.php
│   ├── index.php           (Dashboard KPIs & Activities)
│   ├── inquiries.php       (Message Center)
│   ├── login.php           (Admin Auth)
│   ├── logout.php
│   ├── products.php        (Products CRUD)
│   ├── services.php        (Services CRUD)
│   ├── settings.php        (Global Site Settings & Logo Upload)
│   └── testimonials.php    (Testimonials CRUD)
├── assets/
│   ├── css/
│   │   ├── admin.css
│   │   └── style.css
│   └── js/
│       ├── admin.js
│       └── main.js
├── config/
│   ├── config.php
│   └── database.php
├── includes/
│   ├── auth.php
│   ├── db.php
│   ├── footer.php
│   ├── functions.php
│   ├── header.php
│   ├── mailer.php
│   └── seo.php
├── uploads/
│   ├── clients/
│   ├── gallery/
│   ├── products/
│   ├── services/
│   ├── site/
│   └── testimonials/
├── .htaccess
├── 404.php
├── about.php
├── clients.php
├── contact.php
├── database.sql            (Complete DB Schema & Seed Data)
├── DEPLOYMENT.md           (Hostinger/cPanel Guide)
├── gallery.php
├── IMAGE_PROMPTS.md        (4K Commercial Photography Prompts)
├── index.php               (Homepage)
├── privacy.php
├── product-detail.php
├── products.php
├── README.md
├── robots.txt
├── service-detail.php
├── services.php
├── sitemap.php             (Dynamic XML Sitemap)
├── terms.php
└── testimonials.php
```

---

## Default Admin Credentials

- **Admin Login URL**: `http://your-domain.com/admin/login.php`
- **Username**: `admin`
- **Password**: `admin123`

*(Password can be updated anytime inside the database or settings)*.

---

## Key Features

1. **100% Dynamic Content Management**: Logo, Favicon, Hero, About text, Contact info, WhatsApp, Google Maps, Phone, Email, SEO tags, and Footer can be updated directly from the Admin Panel.
2. **Services Module**: Unlimited services, image uploads, descriptions, FAQs, status toggle (Publish/Hide), and sort order.
3. **Products Module**: Unlimited products, specifications table editor, multi-category tagging, main image upload, price/unit tag, and featured flag.
4. **Clients & Testimonials**: Client logos, website links, customer photos, star ratings, and YouTube video embeds.
5. **Photo Gallery**: Lightbox modal previewer, category filter tabs, and multi-file management.
6. **Customer Inquiries Center**: AJAX-powered contact form with CSRF validation, email notification, and admin message viewer.
7. **SEO & Schema.org**: Automatic OpenGraph, Twitter Cards, Organization JSON-LD Schema, robots.txt, and dynamic XML sitemap.
