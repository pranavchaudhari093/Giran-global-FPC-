-- ============================================================
-- GIRNA GLOBAL WEBSITE & CMS DATABASE SCHEMA
-- Database: girna_global_db
-- Compatibility: MySQL 5.7+ / MySQL 8.0+ / MariaDB 10.2+
-- Default Admin Password: admin123 (hashed with PASSWORD_BCRYPT)
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `inquiries`;
DROP TABLE IF EXISTS `gallery`;
DROP TABLE IF EXISTS `testimonials`;
DROP TABLE IF EXISTS `clients`;
DROP TABLE IF EXISTS `product_images`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `admins`;

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- Table: admins
-- --------------------------------------------------------
CREATE TABLE `admins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `last_login` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default Admin Seed: username 'admin', password 'admin123'
INSERT INTO `admins` (`id`, `username`, `email`, `password`, `full_name`) VALUES
(1, 'admin', 'admin@girnaglobal.com', '$2y$10$wE0v2GgJpYQ5m8Fz50y95.FhV36V6z2l3.F8h0aG9bW3c4d5e6f7g', 'Girna Global Super Admin');

-- --------------------------------------------------------
-- Table: settings
-- --------------------------------------------------------
CREATE TABLE `settings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `site_name` VARCHAR(150) NOT NULL DEFAULT 'Girna Global',
  `tagline` VARCHAR(255) DEFAULT 'Premium Agricultural Produce, Fresh Banana Export & Global Agri-Trading',
  `logo` VARCHAR(255) DEFAULT '',
  `favicon` VARCHAR(255) DEFAULT '',
  `phone` VARCHAR(50) DEFAULT '+91 98765 43210',
  `whatsapp` VARCHAR(50) DEFAULT '+91 98765 43210',
  `email` VARCHAR(100) DEFAULT 'contact@girnaglobal.com',
  `address` TEXT DEFAULT 'Girna Valley Agri Hub, NH-6 Highway, Jalgaon District, Maharashtra - 425001, India',
  `google_maps` TEXT DEFAULT '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119294.63467645063!2d75.51733221379532!3d21.007659104033324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd90fa4a1e9447d%3A0x62955f1f91b402!2sJalgaon%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
  `hero_title` VARCHAR(255) DEFAULT 'Connecting Fertile Lands to Global Markets',
  `hero_subtitle` VARCHAR(255) DEFAULT 'Exporter of Premium G9 Cavendish Bananas, Organic Bio-Fertilizers & Cold-Chain Agricultural Produce.',
  `hero_image` VARCHAR(255) DEFAULT '',
  `about_title` VARCHAR(255) DEFAULT 'Pioneering Sustainable Agriculture & Fresh Exports Worldwide',
  `about_summary` TEXT DEFAULT 'Girna Global is a premier agricultural enterprise headquartered in the fertile Girna river basin. We specialize in contract farming, G9 Cavendish banana harvesting, cold-chain logistics, and premium bio-fertilizer supply for international markets.',
  `about_image` VARCHAR(255) DEFAULT '',
  `smtp_host` VARCHAR(150) DEFAULT 'smtp.gmail.com',
  `smtp_port` INT(11) DEFAULT 587,
  `smtp_user` VARCHAR(150) DEFAULT 'your-gmail@gmail.com',
  `smtp_pass` VARCHAR(255) DEFAULT '',
  `smtp_secure` VARCHAR(10) DEFAULT 'tls',
  `meta_title` VARCHAR(255) DEFAULT 'Girna Global | Premium Banana Exporter & Agricultural Trading',
  `meta_description` TEXT DEFAULT 'Girna Global is a leading exporter of premium Cavendish bananas, organic fertilizers, and fresh farm produce with end-to-end cold-chain packaging.',
  `footer_about` TEXT DEFAULT 'Girna Global delivers world-class agricultural products from our rich river basin farms directly to global markets with guaranteed quality, freshness, and sustainable farming ethics.',
  `facebook_url` VARCHAR(255) DEFAULT 'https://facebook.com',
  `linkedin_url` VARCHAR(255) DEFAULT 'https://linkedin.com',
  `instagram_url` VARCHAR(255) DEFAULT 'https://instagram.com',
  `twitter_url` VARCHAR(255) DEFAULT 'https://twitter.com',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`) VALUES (1);

-- --------------------------------------------------------
-- Table: services
-- --------------------------------------------------------
CREATE TABLE `services` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `icon_svg` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `short_description` TEXT NOT NULL,
  `full_description` LONGTEXT NOT NULL,
  `faqs_json` LONGTEXT DEFAULT NULL,
  `status` ENUM('published','hidden') NOT NULL DEFAULT 'published',
  `sort_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`, `title`, `slug`, `short_description`, `full_description`, `faqs_json`, `status`, `sort_order`) VALUES
(1, 'Contract Banana Farming & Harvesting', 'contract-banana-farming-harvesting', 
'Standardized, high-yield Cavendish G9 banana cultivation supported by agronomic monitoring and automated harvesting procedures.',
'Our contract banana farming division works hand-in-hand with over 500+ experienced farmers across the fertile Girna basin. We implement global GAP standards, tissue culture plantlets, drip irrigation, and zero-residue pest control. Harvesting is executed at precise maturity stages using padded field-trailers to prevent bruising.',
'[{"question":"What maturity grade is harvested for export?","answer":"We harvest at 75-80% maturity (38-44 mm calibration) based on transit duration."},{"question":"How do you prevent skin blemishes during harvest?","answer":"Bunches are sleeved with protective foam sleeves and transported via cable rails to field packing stations."}]',
'published', 1),

(2, 'Cold-Chain Processing & Export Packaging', 'cold-chain-processing-export-packaging',
'State-of-the-art washing, anti-fungal treatment, vacuum packing, and reefer container temperature regulation.',
'Equipped with automated pack-houses, our processing workflow includes de-handing, alum bath washing, crowns treatment, barcode tracking, vacuum polypack sealing, and pre-cooling to 13.5°C within 4 hours of harvest. This ensures a 35-45 day shelf life in reefer containers.',
'[{"question":"What temperature is maintained in reefer containers?","answer":"Reefer containers are set to precise +13.5°C with controlled atmosphere ventilation at 15%-20% RH."},{"question":"What box capacities do you offer?","answer":"Standard export boxes are 13.5 kg net weight (bottom handle) and 18.14 kg net weight corrugated export master boxes."}]',
'published', 2),

(3, 'Bio-Fertilizer & Soil Nutrition Solutions', 'bio-fertilizer-soil-nutrition-solutions',
'Custom organic composts, micronutrient blends, and bio-stimulants engineered for tropical crop enhancement.',
'Girna Agri-Nutrients produces high-potency organic fertilizers derived from press-mud, neem cake, and bio-active microbial inoculants. Designed to revitalize depleted soils, enhance root CEC (Cation Exchange Capacity), and maximize Brix sweetness in fruits.',
'[{"question":"Are your bio-fertilizers certified organic?","answer":"Yes, our products meet NPOP organic standards and are certified chemical-residue free."},{"question":"Can these be applied via fertigation?","answer":"We supply both granular soil application blends and 100% water-soluble fertigation formulas."}]',
'published', 3),

(4, 'Agronomic Drone Surveying & Precision Agri', 'agronomic-drone-surveying-precision-agri',
'Multispectral aerial crop health assessments, canopy analysis, and precision spraying services.',
'Utilizing high-resolution multispectral drones, we map crop stress, nitrogen deficiency, and early leaf-spot detection across farm clusters. This data enables variable-rate micro-nutrient application, reducing input costs by 25% while boosting farm yields.',
'[{"question":"How often are drone surveys performed?","answer":"Surveys are conducted bi-weekly during critical vegetative and flower initiation stages."}]',
'published', 4);

-- --------------------------------------------------------
-- Table: products
-- --------------------------------------------------------
CREATE TABLE `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `category` VARCHAR(100) NOT NULL DEFAULT 'Bananas',
  `main_image` VARCHAR(255) DEFAULT NULL,
  `price_unit` VARCHAR(100) DEFAULT 'On Request (FOB / CIF)',
  `specifications_json` LONGTEXT DEFAULT NULL,
  `description` LONGTEXT NOT NULL,
  `is_featured` TINYINT(1) DEFAULT 0,
  `status` ENUM('published','hidden') NOT NULL DEFAULT 'published',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `title`, `slug`, `category`, `main_image`, `price_unit`, `specifications_json`, `description`, `is_featured`, `status`) VALUES
(1, 'Premium Fresh G9 Cavendish Bananas', 'premium-fresh-g9-cavendish-bananas', 'Banana Export', '', 'FOB / CIF Competitive Pricing',
'[{"key":"Variety","value":"Grand Naine (G9) Cavendish"},{"key":"Finger Length","value":"18 cm to 25 cm min"},{"key":"Calibration","value":"39 mm to 46 mm"},{"key":"Hands per Box","value":"4, 5, 6, 7 Hands"},{"key":"Net Weight","value":"13.5 kg / 18.14 kg Export Box"},{"key":"Temperature","value":"13.5°C Controlled Reefer"},{"key":"Shelf Life","value":"45 Days Post Harvest"}]',
'Our flagship export product. Handpicked G9 Cavendish Bananas cultivated in the mineral-rich soils of the Girna river valley. Each hand is thoroughly washed, treated, vacuum poly-bagged with ethylene absorbers, and packed in heavy-duty 5-ply corrugated export cartons.', 1, 'published'),

(2, 'Girna Bio-Gro Organic Micro-Nutrient Fertilizer', 'girna-bio-gro-organic-fertilizer', 'Fertilizer & Soil', '', 'Per Metric Ton / Bulk Bag',
'[{"key":"Form","value":"Granular / Soluble Powder"},{"key":"Organic Matter","value":"65% Min"},{"key":"NPK Equivalent","value":"4:3:3 Natural Organic Blend"},{"key":"Micronutrients","value":"Zinc, Boron, Iron Chelate"},{"key":"Packaging","value":"50 kg HDPE Bags with inner liner"}]',
'Girna Bio-Gro is an enriched bio-fertilizer engineered specifically for commercial banana plantations, fruit orchards, and cash crops. It improves soil microbial activity, enhances moisture retention, and boosts fruit calibration.', 1, 'published'),

(3, 'Fresh Tissue Culture Banana Plantlets', 'fresh-tissue-culture-banana-plantlets', 'Agri Inputs', '', 'Per 1000 Hardened Plantlets',
'[{"key":"Generation","value":"Secondary Hardened Stage"},{"key":"Genetic Purity","value":"100% True-to-Type G9"},{"key":"Virus Indexing","value":"Tested Virus-Free (BBTV, CMV)"},{"key":"Height","value":"25-30 cm with strong root ball"}]',
'Certified high-yielding tissue culture Cavendish banana plantlets developed in sterile laboratory conditions. Provides uniform crop maturity, high bunch weights (30-35 kg), and resistance to Panama disease.', 0, 'published'),

(4, 'Dehydrated Green Banana Powder (Gluten-Free)', 'dehydrated-green-banana-powder', 'Processed Food', '', 'Per Metric Ton (Bag/Drum)',
'[{"key":"Resistant Starch","value":"> 55%"},{"key":"Purity","value":"100% Pure Green Cavendish"},{"key":"Moisture","value":"< 6%"},{"key":"Mesh Size","value":"80-100 Mesh Fine Powder"}]',
'Premium quality raw green banana flour rich in resistant starch and prebiotic fiber. Ideal for gluten-free baking, health supplements, and baby food formulations.', 1, 'published');

-- --------------------------------------------------------
-- Table: product_images
-- --------------------------------------------------------
CREATE TABLE `product_images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_id` INT(11) NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `fk_product_images` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: clients
-- --------------------------------------------------------
CREATE TABLE `clients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `logo` VARCHAR(255) DEFAULT NULL,
  `location` VARCHAR(100) DEFAULT 'International Market',
  `website` VARCHAR(255) DEFAULT '',
  `description` TEXT DEFAULT NULL,
  `sort_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `clients` (`id`, `name`, `location`, `website`, `description`) VALUES
(1, 'Middle East Fruit Importers LLC', 'Dubai, UAE', 'https://example.com', 'Leading distributor of fresh tropical fruits across GCC supermarkets.'),
(2, 'EuroAgri Trade Sp. z o.o.', 'Warsaw, Poland', 'https://example.com', 'Major importer of certified G9 Cavendish bananas for Eastern & Central European markets.'),
(3, 'Persian Gulf Produce Co.', 'Tehran, Iran', 'https://example.com', 'Long-term reefer shipment partner for bulk fresh agricultural commodities.'),
(4, 'Asian Superfresh Marketing', 'Kuala Lumpur, Malaysia', 'https://example.com', 'Wholesale supplier of premium packaged fresh produce to retail chains.');

-- --------------------------------------------------------
-- Table: testimonials
-- --------------------------------------------------------
CREATE TABLE `testimonials` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `village` VARCHAR(100) NOT NULL,
  `rating` INT(1) NOT NULL DEFAULT 5,
  `review` TEXT NOT NULL,
  `video_url` VARCHAR(255) DEFAULT '',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `testimonials` (`id`, `name`, `village`, `rating`, `review`, `video_url`) VALUES
(1, 'Suresh Patil', 'Raver, Jalgaon', 5, 'Partnering with Girna Global transformed our banana harvest. Their agronomy team provided tissue culture advice and guaranteed export purchasing. Our average bunch weight reached 34 kg!', ''),
(2, 'Ahmed Al-Maktoum', 'Dubai, UAE (Importer)', 5, 'Girna Global delivers consistent quality reefer containers. The bananas arrive in perfect green condition with uniform finger lengths and flawless crown washing. Truly reliable partner.', ''),
(3, 'Rameshwar Chaudhari', 'Yawal, Maharashtra', 5, 'Using Girna Bio-Gro fertilizer resulted in zero soil salinity issues and incredible yield growth. They handle transport directly from the farmgate with instant payments.', '');

-- --------------------------------------------------------
-- Table: gallery
-- --------------------------------------------------------
CREATE TABLE `gallery` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `category` VARCHAR(100) NOT NULL DEFAULT 'Harvesting',
  `image_path` VARCHAR(255) NOT NULL,
  `caption` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gallery` (`id`, `title`, `category`, `image_path`, `caption`) VALUES
(1, 'Precision Banana Harvesting', 'Harvesting', '', 'Hand-selected G9 bunches brought to field packing stations via foam rail system.'),
(2, 'Modern Cold Pack-House', 'Processing', '', 'Automated washing, crowns treatment, and vacuum sealing lines.'),
(3, 'Reefer Container Loading', 'Export', '', 'Controlled temperature loading (+13.5°C) for international shipments.'),
(4, 'Bio-Fertilizer Production Plant', 'Fertilizer', '', 'Fermentation tanks and automated bagging facility for organic soil nutrients.'),
(5, 'Agronomic Drone Surveying', 'Technology', '', 'Multispectral drone mapping leaf health across 200-acre contract farm clusters.');

-- --------------------------------------------------------
-- Table: inquiries
-- --------------------------------------------------------
CREATE TABLE `inquiries` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `subject` VARCHAR(200) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`) VALUES
(1, 'John Smith', 'john.smith@globalfruit.com', '+1 408 555 0199', 'Inquiry for 5 Reefers G9 Bananas to Jebel Ali', 'Hello Girna Global Team, We are looking to import 5 reefer containers of G9 Cavendish Bananas weekly to Jebel Ali Port, Dubai. Please send your FOB and CIF quote.', 1);
