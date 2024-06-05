-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2024 at 11:27 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yonex`
--

-- --------------------------------------------------------

--
-- Table structure for table `bags`
--

CREATE TABLE `bags` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `size` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bags`
--

INSERT INTO `bags` (`id`, `name`, `price`, `priceNOTAX`, `img_url`, `size`, `type`, `quantity`, `category`, `description`) VALUES
(106032, 'Ruksak 1818, Ruksak, crni\r\n', 60, 49.10, './images/product-images/bags/rucksack/106032/106032.jpg', '/', '/', 5, 'rucksack', 'YONEX RUKSAK 1818.\r\n\r\n- ruksak za dva reketa i ostalu opremu\r\n- boja: crna\r\n- dimenzije: 34 cm x 21 cm x 48 cm'),
(112832, 'Torba 92231 PRO MEDIUM SIZE BOSTON, plava', 85, 69.59, './images/product-images/bags/bags/112832/112832.jpg', 'Ostale torbe', 'Pro serija', 5, 'bags', '92231 PRO Boston torba srednje veličine\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `balls`
--

CREATE TABLE `balls` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `type` varchar(50) NOT NULL,
  `speed` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `balls`
--

INSERT INTO `balls` (`id`, `name`, `price`, `priceNOTAX`, `img_url`, `type`, `speed`, `quantity`, `category`, `description`) VALUES
(106008, 'Lopta za badminton AS-10, brzina 3', '25.90', 21.23, './images/product-images/badminton/balls/106008/106008.jpg', 'Perje', 'Brzina 3', 5, 'badminton', 'AS-10Tehničke karakteristike: Badbinton loptica AS-10'),
(112484, 'Teniske loptice CHAMPIONSHIP 1/3\r\n', '5.99', 4.91, './images/product-images/tennis/balls/112484/112484.jpg', 'Turnir', '/', 5, 'tennis', 'Championship teniske loptice su tlačne loptice za svakodnevno vježbanje u teniskim klubovima, na svim podlogama, usmjerene na izdržljivost.\r\n\r\nSastav:\r\n- Vuna / najlon / poliester / guma\r\n- 3 loptice\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `basicinfo`
--

CREATE TABLE `basicinfo` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `basicinfo`
--

INSERT INTO `basicinfo` (`id`, `name`, `value`, `user_id`) VALUES
(1, 'totalCartPrice', '100', 18),
(2, 'totalCartPrice', '100', 19);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `checkboxfilters`
--

CREATE TABLE `checkboxfilters` (
  `id` int(11) NOT NULL,
  `content` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `filterName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkboxfilters`
--

INSERT INTO `checkboxfilters` (`id`, `content`, `category`, `filterName`) VALUES
(1, 'Dostupno', 'everything', 'availability'),
(2, 'Nedostupno', 'everything', 'availability'),
(3, 'Role [200m-500m]', 'tennis', 'cord_length'),
(4, '12 m ', 'tennis', 'cord_length'),
(5, '1.15 mm', 'tennis', 'cord_width'),
(6, '1.20 mm', 'tennis', 'cord_width'),
(7, '1.25 mm ', 'tennis', 'cord_width'),
(8, '1.30 mm', 'tennis', 'cord_width'),
(9, 'Muški', 'everything', 'gender'),
(10, 'G0', 'tennis', 'handle_type'),
(11, 'G1', 'tennis', 'handle_type'),
(12, 'G2', 'tennis', 'handle_type'),
(13, 'G3', 'tennis', 'handle_type'),
(14, 'G4', 'tennis', 'handle_type'),
(15, 'Ezoni', 'tennis', 'racket_type'),
(16, 'Percept', 'tennis', 'racket_type'),
(17, 'Vcore', 'tennis', 'racket_type'),
(18, 'Vcore Pro', 'tennis', 'racket_type'),
(19, '240g', 'tennis', 'racket_weight'),
(20, '250g', 'tennis', 'racket_weight'),
(21, '260g', 'tennis', 'racket_weight'),
(22, '270g', 'tennis', 'racket_weight'),
(23, '280g', 'tennis', 'racket_weight'),
(24, '290g', 'tennis', 'racket_weight'),
(25, '300g', 'tennis', 'racket_weight'),
(26, '310g', 'tennis', 'racket_weight'),
(29, '320g', 'tennis', 'racket_weight'),
(30, '340g', 'tennis', 'racket_weight'),
(31, '38', 'tennis', 'shoes_size'),
(32, '39', 'tennis', 'shoes_size'),
(33, '39.5', 'tennis', 'shoes_size'),
(34, '40', 'tennis', 'shoes_size'),
(35, '41', 'tennis', 'shoes_size'),
(36, '42.5', 'tennis', 'shoes_size'),
(37, 'Ženski', 'everything', 'gender'),
(38, 'Turnir', 'tennis', 'ball_type'),
(39, 'Trening', 'tennis', 'ball_type'),
(40, '2F = 68g', 'badminton', 'racket_weight'),
(41, '2U = 90-94.9g', 'badminton', 'racket_weight'),
(42, '3U = 85-89.9g', 'badminton', 'racket_weight'),
(43, '4U = 80-84.9g', 'badminton', 'racket_weight'),
(44, '5U = 75-79.9g', 'badminton', 'racket_weight'),
(45, 'Arcsaber', 'badminton', 'racket_type'),
(46, 'Astrox', 'badminton', 'racket_type'),
(47, 'B-seria', 'badminton', 'racket_type'),
(48, 'Duora', 'badminton', 'racket_type'),
(49, 'Muscle power', 'badminton', 'racket_type'),
(50, 'Nanoflare', 'badminton', 'racket_type'),
(51, 'Nanozraci', 'badminton', 'racket_type'),
(52, 'Dječji', 'badminton', 'racket_type'),
(53, 'Voltric', 'badminton', 'racket_type'),
(54, 'G4', 'badminton', 'handle_type'),
(55, 'G5', 'badminton', 'handle_type'),
(56, 'G7', 'badminton', 'handle_type'),
(57, '36', 'badminton', 'shoes_size'),
(58, '37', 'badminton', 'shoes_size'),
(59, '38', 'badminton', 'shoes_size'),
(60, '39', 'badminton', 'shoes_size'),
(61, '40', 'badminton', 'shoes_size'),
(62, '41', 'badminton', 'shoes_size'),
(63, '42', 'badminton', 'shoes_size'),
(64, '43', 'badminton', 'shoes_size'),
(65, '44', 'badminton', 'shoes_size'),
(66, '45', 'badminton', 'shoes_size'),
(67, '46', 'badminton', 'shoes_size'),
(68, '47', 'badminton', 'shoes_size'),
(69, 'Role [200m-500m]', 'badminton', 'cord_length'),
(70, '10m', 'badminton', 'cord_length'),
(71, 'Brze', 'badminton', 'ball_speed'),
(72, 'Brzina 3', 'badminton', 'ball_speed'),
(73, 'Srednje', 'badminton', 'ball_speed'),
(74, 'Spore', 'badminton', 'ball_speed'),
(75, 'Najlon', 'badminton', 'ball_type'),
(76, 'Perje', 'badminton', 'ball_type'),
(77, 'Aktivna', 'bags', 'bag_type'),
(78, 'Pro serija', 'bags', 'bag_type'),
(79, 'Timska serija', 'bags', 'bag_type'),
(80, '3 reketa', 'bags', 'bag_size'),
(81, '6 reketa', 'bags', 'bag_size'),
(82, '8-12 reketa', 'bags', 'bag_size'),
(83, 'Ostale torbe', 'bags', 'bag_size'),
(84, 'S', 'clothing', 'clothing_size'),
(85, 'M', 'clothing', 'clothing_size'),
(86, 'L', 'clothing', 'clothing_size'),
(87, 'XL', 'clothing', 'clothing_size'),
(88, 'XXL', 'clothing', 'clothing_size'),
(89, 'Unisex', 'everything', 'gender');

-- --------------------------------------------------------

--
-- Table structure for table `classicfilters`
--

CREATE TABLE `classicfilters` (
  `id` int(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(7,2) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classicfilters`
--

INSERT INTO `classicfilters` (`id`, `name`, `quantity`, `price`, `priceNOTAX`, `img_url`, `category`, `description`) VALUES
(106061, 'Prigušivač vibracija AC165, 2 kom, bijeli', 15, 8.95, 7.34, './images/product-images/tennis/vibrationDampers/106061.webp', 'vibrationDamper', 'Gumeni vibracijski umetak Yonex Vibration Stopper s troslojnom strukturom maksimalno suzbija neželjene vibracije.- 2 komada u paketu'),
(106062, 'Prigušivač vibracija AC165, 2 kom, bijeli', 0, 50.00, 7.34, './images/product-images/tennis/vibrationDampers/106061.webp', 'vibrationDamper', 'Gumeni vibracijski umetak Yonex Vibration Stopper s troslojnom strukturom maksimalno suzbija neželjene vibracije.- 2 komada u paketu'),
(106065, 'Boca za vodu AC588, plava', 5, 6.89, 5.65, './images/product-images/accessories/rest/106065/106065.jpg', 'rest', 'Yonex boca za piće AC 588.\r\n\r\n\r\n\r\nVeličina: 1 litra.\r\n\r\n\r\nIzrađen od polietilena otpornog na temperaturu.'),
(106470, 'boja žice AC 414, bijela', 5, 9.50, 7.79, './images/product-images/accessories/tints/106470/106470.jpg', 'tints', 'LOGOMARKER AC414 bijeli'),
(108910, 'Traka za glavu AC258, bijela', 5, 5.95, 4.88, './images/product-images/accessories/sweats/108910/108910.jpg', 'sweats', 'Yonex AC258E traka za glavu izrađena je od 100% pamuka. Vrlo gusta da upije više znoja. Izvezeni Yonex logo.\r\n'),
(109934, 'Drška AC102, 3 kom narančasta', 5, 9.89, 8.11, './images/product-images/accessories/gums/109934/109934.jpg', 'gums', 'Yonex Super Grap - paket od 3 gripa.\r\n\r\nTrajna kvaliteta YONEX grip trake demonstrirana je dugim životnim vijekom AC102EX gripa, koji je 2012. doživio svoju 25. obljetnicu. Od 1987. godine, kada je predstavljena traka AC102EX, prodano je dovoljno trake da se njome tri puta omota oko Zemlje!\r\n\r\n\r\nSvojstva:\r\n\r\n- Ljepljivost\r\n- Širina: 25 mm\r\n- Dužina: 3 × 40 cm trake\r\n- Debljina: 0,6 mm\r\n- Materijal: Poliuretan'),
(114797, 'Ručnik AC1110, crna/mint', 5, 22.00, 18.03, './images/product-images/accessories/towels/114797/114797.jpg', 'towels', 'Sportski ručnik\r\n\r\nVeličina 40x100cm\r\n\r\nSastav:\r\n100% pamuk');

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `priceNOTAX` decimal(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `size` varchar(5) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clothing`
--

INSERT INTO `clothing` (`id`, `name`, `price`, `priceNOTAX`, `img_url`, `size`, `sex`, `quantity`, `category`, `description`) VALUES
(109358, 'Jakna 75. 50107, L, zelena\r\n', '119.00', '97.54', './images/product-images/clothing/jackets/108358/108358.jpg', 'L', 'Unisex', 5, 'jackets', 'Muška jakna (75. obljetnica)\r\n\r\nSastav:\r\n100% poliester'),
(110613, 'Čarape 19120, L, crne', '15.90', '13.03', './images/product-images/clothing/socks/110613/110613.jpg', 'L', 'Unisex', 5, 'socks', 'Sportske čarape 19120 Sport Crew Socks\r\n\r\n- 3D ERGO\r\n- pravokutni dizajn\r\n- Polygiene (antibakterijski dezodorans)\r\n\r\nMaterijal:\r\n56% pamuk,\r\n24% akril,\r\n17% poliester,\r\n2% poliuretan,\r\n1% najlon'),
(111663, 'Ženski grudnjak 46043, L, crni', '44.90', '36.80', './images/product-images/clothing/rest/111663/111663.jpg', 'L', 'Ženski', 5, 'rest', 'Ženski sportski grudnjak\r\n\r\nSastav:\r\n72% poliester\r\n28% poliuretan\r\n\r\nVERYCOOL tehnologija\r\nUz pomoć rashladnog materijala xylitol YONEX VERYCOOL odjeća upija toplinu i znoj, što osigurava značajan učinak hlađenja tijekom vježbanja bez obzira na temperaturu okoline. VERYCOOL snižava tjelesnu temperaturu za 3°C.'),
(112443, 'Muške kratke hlače 15119, M, bijele', '49.90', '40.90', './images/product-images/clothing/shorts/112443/112443.jpg', 'M', 'Muški', 5, 'shorts', 'Muške kratke hlače\r\n\r\nSastav:\r\n90% poliester\r\n10% poliuretan\r\n\r\nVERYCOOL tehnologija\r\nKoristeći rashladni materijal ksilitol, odjeća VERYCOOL marke YONEX apsorbira toplinu i znoj, što osigurava značajan učinak hlađenja tijekom vježbanja bez obzira na temperaturu okoline. VERYCOOL snižava tjelesnu temperaturu za 3°C.'),
(113710, 'Majica kratkih rukava 16621, L, crna\r\n', '49.90', '40.90', './images/product-images/clothing/t-shirts/113710/113710.jpg', 'L', 'Unisex', 5, 't-shirts', 'Unisex majica\r\n\r\nSastav:\r\n100% poliester\r\n\r\nSmanjenje UV zraka\r\nIzvrsna zaštita od ultraljubičastog zračenja. Yonex odjeća hvata infracrveno zračenje i približno 92%* ultraljubičastog zračenja, smanjujući nakupljanje topline tijekom igre.\r\n\r\nAntistatički materijal, vodljiva vlakna impregnirana ugljikom ušivena u odjeću, uklanjaju nakupljanje statičkog elektriciteta.\r\n\r\nInovativni rastezljivi materijal omogućuje slobodno kretanje koje podržava vašu aktivnu igru.\r\n\r\nUpijajući i brzo sušeći materijal koji upija vlagu i održava vas suhima.'),
(113760, 'Hoodie 30081, L, boja aloe', '89.89', '73.68', './images/product-images/clothing/hoodies/113760/113760.jpg', 'L', 'Unisex', 5, 'pants', 'Unisex hoodie\r\n\r\nSastav:\r\n49% pamuk\r\n49% poliester\r\n2% poliuretan\r\n\r\nSmanjenje UV zraka\r\nIzvrsna zaštita od ultraljubičastog zračenja. Yonex odjeća hvata infracrveno zračenje i približno 92%* ultraljubičastog zračenja, smanjujući nakupljanje topline tijekom igre.'),
(114862, 'Ženska haljina 20700, L, boja aloe', '109.90', '90.08', './images/product-images/clothing/dress/114862/114862.jpg', 'L', 'Ženski', 5, 'dress', 'Ženska haljina s gaćama  Sastav haljine: 86% poliester 14% poliuretan Sastav gaća: 89% poliester 11% poliuretan  VERYCOOL tehnologija Uz pomoć rashladnog materijala xylitol, VERYCOOL odjeća marke YONEX upija toplinu i znoj, što osigurava značajan učinak hlađenja tijekom vježbanja bez obzira na temperaturu okoline. VERYCOOL snižava tjelesnu temperaturu za 3°C.');

-- --------------------------------------------------------

--
-- Table structure for table `cords`
--

CREATE TABLE `cords` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `thicknesses` varchar(10) NOT NULL,
  `length` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cords`
--

INSERT INTO `cords` (`id`, `name`, `price`, `priceNOTAX`, `img_url`, `thicknesses`, `length`, `quantity`, `category`, `description`) VALUES
(107569, 'Tenis struna ATG-850, bela, 12m', 18, 14.59, './images/product-images/tennis/cords/107569/107569.jpg', '1.30 mm', '12 m', 5, 'tennis', 'Inovativna nova struktura visoko elastičnega multifilamenta in Yonexovega ekskluzivnega premaza \"Power-Spin Coating\", ki omogoca vrhunski spin, hkrati pa ohranja odziv in občutek naravnega crevesja. Znacilna metoda \"Pre-Stretch\" v kombinaciji z dvojnim navijanjem ovojev pomaga ohranjati napetost strun in optimizira igranje.\r\n\r\nMaterial: Najlon z večvlaknenim jedrom, dvojnim ovojem najlona in premazom Yonex \"Power-Spin\"\r\n\r\nDebelina: 1,32 mm\r\nDolžina: 12 m\r\nObčutek: Rahlo trd'),
(111358, 'Žica za badminton AEROBITE, bijelo/zelena, 10m', 15, 12.21, './images/product-images/badminton/cords/111358/111358.jpg', '/', '10m', 5, 'badminton', 'AEROBITE\r\n\r\nYonex AEROBITE je hibridna kombinacija s izmjeničnim debljinama i premazima na glavnim žicama (0,67 mm) i poprečnim žicama (0,61 mm). Posebno dizajniran za hibridno vezivanje, AEROBITE pruža brzi odskok i visoku rotaciju za iznenađujuće udarce i udarce.\r\nDebljina: glavna struna - 0,67 mm; poprečna struna - 0,61 mm\r\nDužina: 10,5 m (34 stope) / 200 m (656 stope)\r\nJezgra: Multifilamentni najlon visokog intenziteta\r\nVanjski sloj: Posebna pletena kovana vlakna\r\nŠifra proizvoda: BGAB\r\nSnaga odbijanja: 10\r\nIzdržljivost: 6\r\nZvuk udara: 9\r\nApsorpcija udara: 8\r\nKontrola : 10');

-- --------------------------------------------------------

--
-- Table structure for table `rackets`
--

CREATE TABLE `rackets` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `racketType` varchar(100) NOT NULL,
  `racketWeigth` varchar(50) NOT NULL,
  `handlerSize` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rackets`
--

INSERT INTO `rackets` (`id`, `name`, `price`, `priceNOTAX`, `img_url`, `racketType`, `racketWeigth`, `handlerSize`, `quantity`, `category`, `description`) VALUES
(112070, 'Reket za badminton ARCSABER 11 PLAY, 4UG5, sivo/crveni', 60, 49.10, './images/product-images/badminton/rackets/112070/112070.jpg\n', 'Arcsaber', '4U = 80-84.9g', 'G5', 5, 'badminton', 'Novi ARC11 Play nadograđen je razvojnim konceptom odlučujuće kontrole. Analiza prethodnog modela pokazala je mogućnosti poboljšanja povećanjem stabilnosti okvira uz istovremeno povećanje vremena kontakta s loptom.\r\n\r\nStabilnost okvira poboljšana je novom strukturom okvira koja ima krutu strukturu na vrhu i dnu glave, smanjujući uvijanje i neželjenu deformaciju pri udaru. Napredak u novom modelu u odnosu na prethodni model ARCSABER 11 (testirao Yonex) omogućio je povećanje vremena kontakta s loptom od 6,6% i povećanje snage udarca od 3,7%.\r\n\r\n\r\nSpecifikacije:\r\n\r\nRazina: Početnik / Srednji\r\nTip: Svestrana\r\nKrutost: Srednja Fleksibilna\r\nglava: Kvadratna/izometrična\r\nTežina: 4U (~83 grama)\r\nPromjer: G5 (3 1/4 inča)\r\nB.Pt: 5 (ujednačena ravnoteža)\r\nNapon: 19- 27 funti\r\n===============\r\nGlava: grafitna\r\nosovina: grafitna\r\nnavlaka: Yonex navlaka za glavu\r\nŽica: Yonex prednapeta osnovna struna / dostupna nadogradnja'),
(112071, 'Reket za badminton ARCSABER 11 PLAY, 4UG5, sivo/crveni', 60, 49.10, './images/product-images/badminton/rackets/112070/112070.jpg\r\n', 'Arcsaber', '4U = 80-84.9g', 'G5', 5, 'badminton', 'Novi ARC11 Play nadograđen je razvojnim konceptom odlučujuće kontrole. Analiza prethodnog modela pokazala je mogućnosti poboljšanja povećanjem stabilnosti okvira uz istovremeno povećanje vremena kontakta s loptom.\r\n\r\nStabilnost okvira poboljšana je novom strukturom okvira koja ima krutu strukturu na vrhu i dnu glave, smanjujući uvijanje i neželjenu deformaciju pri udaru. Napredak u novom modelu u odnosu na prethodni model ARCSABER 11 (testirao Yonex) omogućio je povećanje vremena kontakta s loptom od 6,6% i povećanje snage udarca od 3,7%.\r\n\r\n\r\nSpecifikacije:\r\n\r\nRazina: Početnik / Srednji\r\nTip: Svestrana\r\nKrutost: Srednja Fleksibilna\r\nglava: Kvadratna/izometrična\r\nTežina: 4U (~83 grama)\r\nPromjer: G5 (3 1/4 inča)\r\nB.Pt: 5 (ujednačena ravnoteža)\r\nNapon: 19- 27 funti\r\n===============\r\nGlava: grafitna\r\nosovina: grafitna\r\nnavlaka: Yonex navlaka za glavu\r\nŽica: Yonex prednapeta osnovna struna / dostupna nadogradnja'),
(112072, 'Reket za badminton ARCSABER 11 PLAY, 4UG5, sivo/crveni', 60, 49.10, './images/product-images/badminton/rackets/112070/112070.jpg\r\n', 'Arcsaber', '4U = 80-84.9g', 'G5', 5, 'badminton', 'Novi ARC11 Play nadograđen je razvojnim konceptom odlučujuće kontrole. Analiza prethodnog modela pokazala je mogućnosti poboljšanja povećanjem stabilnosti okvira uz istovremeno povećanje vremena kontakta s loptom.\r\n\r\nStabilnost okvira poboljšana je novom strukturom okvira koja ima krutu strukturu na vrhu i dnu glave, smanjujući uvijanje i neželjenu deformaciju pri udaru. Napredak u novom modelu u odnosu na prethodni model ARCSABER 11 (testirao Yonex) omogućio je povećanje vremena kontakta s loptom od 6,6% i povećanje snage udarca od 3,7%.\r\n\r\n\r\nSpecifikacije:\r\n\r\nRazina: Početnik / Srednji\r\nTip: Svestrana\r\nKrutost: Srednja Fleksibilna\r\nglava: Kvadratna/izometrična\r\nTežina: 4U (~83 grama)\r\nPromjer: G5 (3 1/4 inča)\r\nB.Pt: 5 (ujednačena ravnoteža)\r\nNapon: 19- 27 funti\r\n===============\r\nGlava: grafitna\r\nosovina: grafitna\r\nnavlaka: Yonex navlaka za glavu\r\nŽica: Yonex prednapeta osnovna struna / dostupna nadogradnja'),
(112073, 'Reket za badminton ARCSABER 11 PLAY, 4UG5, sivo/crveni', 60, 49.10, './images/product-images/badminton/rackets/112070/112070.jpg\r\n', 'Arcsaber', '4U = 80-84.9g', 'G5', 5, 'badminton', 'Novi ARC11 Play nadograđen je razvojnim konceptom odlučujuće kontrole. Analiza prethodnog modela pokazala je mogućnosti poboljšanja povećanjem stabilnosti okvira uz istovremeno povećanje vremena kontakta s loptom.\r\n\r\nStabilnost okvira poboljšana je novom strukturom okvira koja ima krutu strukturu na vrhu i dnu glave, smanjujući uvijanje i neželjenu deformaciju pri udaru. Napredak u novom modelu u odnosu na prethodni model ARCSABER 11 (testirao Yonex) omogućio je povećanje vremena kontakta s loptom od 6,6% i povećanje snage udarca od 3,7%.\r\n\r\n\r\nSpecifikacije:\r\n\r\nRazina: Početnik / Srednji\r\nTip: Svestrana\r\nKrutost: Srednja Fleksibilna\r\nglava: Kvadratna/izometrična\r\nTežina: 4U (~83 grama)\r\nPromjer: G5 (3 1/4 inča)\r\nB.Pt: 5 (ujednačena ravnoteža)\r\nNapon: 19- 27 funti\r\n===============\r\nGlava: grafitna\r\nosovina: grafitna\r\nnavlaka: Yonex navlaka za glavu\r\nŽica: Yonex prednapeta osnovna struna / dostupna nadogradnja'),
(112074, 'Reket za badminton ARCSABER 11 PLAY, 4UG5, sivo/crveni', 60, 49.10, './images/product-images/badminton/rackets/112070/112070.jpg\r\n', 'Arcsaber', '4U = 80-84.9g', 'G5', 5, 'badminton', 'Novi ARC11 Play nadograđen je razvojnim konceptom odlučujuće kontrole. Analiza prethodnog modela pokazala je mogućnosti poboljšanja povećanjem stabilnosti okvira uz istovremeno povećanje vremena kontakta s loptom.\r\n\r\nStabilnost okvira poboljšana je novom strukturom okvira koja ima krutu strukturu na vrhu i dnu glave, smanjujući uvijanje i neželjenu deformaciju pri udaru. Napredak u novom modelu u odnosu na prethodni model ARCSABER 11 (testirao Yonex) omogućio je povećanje vremena kontakta s loptom od 6,6% i povećanje snage udarca od 3,7%.\r\n\r\n\r\nSpecifikacije:\r\n\r\nRazina: Početnik / Srednji\r\nTip: Svestrana\r\nKrutost: Srednja Fleksibilna\r\nglava: Kvadratna/izometrična\r\nTežina: 4U (~83 grama)\r\nPromjer: G5 (3 1/4 inča)\r\nB.Pt: 5 (ujednačena ravnoteža)\r\nNapon: 19- 27 funti\r\n===============\r\nGlava: grafitna\r\nosovina: grafitna\r\nnavlaka: Yonex navlaka za glavu\r\nŽica: Yonex prednapeta osnovna struna / dostupna nadogradnja'),
(112075, 'Reket za badminton ARCSABER 11 PLAY, 4UG5, sivo/crveni', 60, 49.10, './images/product-images/badminton/rackets/112070/112070.jpg\r\n', 'Arcsaber', '4U = 80-84.9g', 'G5', 5, 'badminton', 'Novi ARC11 Play nadograđen je razvojnim konceptom odlučujuće kontrole. Analiza prethodnog modela pokazala je mogućnosti poboljšanja povećanjem stabilnosti okvira uz istovremeno povećanje vremena kontakta s loptom.\r\n\r\nStabilnost okvira poboljšana je novom strukturom okvira koja ima krutu strukturu na vrhu i dnu glave, smanjujući uvijanje i neželjenu deformaciju pri udaru. Napredak u novom modelu u odnosu na prethodni model ARCSABER 11 (testirao Yonex) omogućio je povećanje vremena kontakta s loptom od 6,6% i povećanje snage udarca od 3,7%.\r\n\r\n\r\nSpecifikacije:\r\n\r\nRazina: Početnik / Srednji\r\nTip: Svestrana\r\nKrutost: Srednja Fleksibilna\r\nglava: Kvadratna/izometrična\r\nTežina: 4U (~83 grama)\r\nPromjer: G5 (3 1/4 inča)\r\nB.Pt: 5 (ujednačena ravnoteža)\r\nNapon: 19- 27 funti\r\n===============\r\nGlava: grafitna\r\nosovina: grafitna\r\nnavlaka: Yonex navlaka za glavu\r\nŽica: Yonex prednapeta osnovna struna / dostupna nadogradnja'),
(112076, 'Reket za badminton ARCSABER 11 PLAY, 4UG5, sivo/crveni', 60, 49.10, './images/product-images/badminton/rackets/112070/112070.jpg\r\n', 'Arcsaber', '4U = 80-84.9g', 'G5', 5, 'badminton', 'Novi ARC11 Play nadograđen je razvojnim konceptom odlučujuće kontrole. Analiza prethodnog modela pokazala je mogućnosti poboljšanja povećanjem stabilnosti okvira uz istovremeno povećanje vremena kontakta s loptom.\r\n\r\nStabilnost okvira poboljšana je novom strukturom okvira koja ima krutu strukturu na vrhu i dnu glave, smanjujući uvijanje i neželjenu deformaciju pri udaru. Napredak u novom modelu u odnosu na prethodni model ARCSABER 11 (testirao Yonex) omogućio je povećanje vremena kontakta s loptom od 6,6% i povećanje snage udarca od 3,7%.\r\n\r\n\r\nSpecifikacije:\r\n\r\nRazina: Početnik / Srednji\r\nTip: Svestrana\r\nKrutost: Srednja Fleksibilna\r\nglava: Kvadratna/izometrična\r\nTežina: 4U (~83 grama)\r\nPromjer: G5 (3 1/4 inča)\r\nB.Pt: 5 (ujednačena ravnoteža)\r\nNapon: 19- 27 funti\r\n===============\r\nGlava: grafitna\r\nosovina: grafitna\r\nnavlaka: Yonex navlaka za glavu\r\nŽica: Yonex prednapeta osnovna struna / dostupna nadogradnja'),
(112077, 'Reket za badminton ARCSABER 11 PLAY, 4UG5, sivo/crveni', 60, 49.10, './images/product-images/badminton/rackets/112070/112070.jpg\r\n', 'Arcsaber', '4U = 80-84.9g', 'G5', 0, 'badminton', 'Novi ARC11 Play nadograđen je razvojnim konceptom odlučujuće kontrole. Analiza prethodnog modela pokazala je mogućnosti poboljšanja povećanjem stabilnosti okvira uz istovremeno povećanje vremena kontakta s loptom.\r\n\r\nStabilnost okvira poboljšana je novom strukturom okvira koja ima krutu strukturu na vrhu i dnu glave, smanjujući uvijanje i neželjenu deformaciju pri udaru. Napredak u novom modelu u odnosu na prethodni model ARCSABER 11 (testirao Yonex) omogućio je povećanje vremena kontakta s loptom od 6,6% i povećanje snage udarca od 3,7%.\r\n\r\n\r\nSpecifikacije:\r\n\r\nRazina: Početnik / Srednji\r\nTip: Svestrana\r\nKrutost: Srednja Fleksibilna\r\nglava: Kvadratna/izometrična\r\nTežina: 4U (~83 grama)\r\nPromjer: G5 (3 1/4 inča)\r\nB.Pt: 5 (ujednačena ravnoteža)\r\nNapon: 19- 27 funti\r\n===============\r\nGlava: grafitna\r\nosovina: grafitna\r\nnavlaka: Yonex navlaka za glavu\r\nŽica: Yonex prednapeta osnovna struna / dostupna nadogradnja'),
(115140, 'Teniski reket EZONE 100 Aqua Night Black, crni, 300g, G1', 280, 229.42, './images/product-images/tennis/rackets/115140/115140.jpg\r\n', 'Ezoni', '300g', 'G1', 5, 'tennis', 'Veličina glave: 100 sq.in. / 645 cm2\nTežina: 300 g / 10,6 oz\nVeličina ručke: 1-5\nDuljina: 27 in. (68,6 cm)\nRaspon širine: 23,8 mm – 26,5 mm – 22,5 mm\nTočka ravnoteže: 320 mm\nMaterijal: HM GRAPHITE / 2G-Namd™ SPEED / VDM\nBoja(e): crna\nPreporučena žica: POLYTOUR PRO/ POLYTOUR STRYKE / REXIS SPEED\nžica Uzorak: 16 x 19\nSavjet strune: 45 – 60 lbs / 20,4-27,2 kg\nProizvedeno u Japanu\n\nZa igrače koji žele preuzeti kontrolu nad terenom s dodatnom snagom i udobnošću\n1. IZOMETRIJSKI - Povećana ugodna točka\nIZOMETRIJSKI dizajn povećava \"ugodnu točku\" \" za 7%*. U usporedbi s konvencionalnim okruglim okvirom, IZOMETRIČKI reket kvadratnog oblika stvara prednost optimiziranjem križanja glavne i poprečne žice\n2. OVALNA PREŠANA DRUŠTINA -\nPrvi put predstavljena 1969. s T-7000 - našim prvim aluminijskim teniskim reketom - je Ovalni reket Pressed Shaft (OPS) je i dan danas uključen u našu najpopularniju ponudu reketa.\nOvalna prešana osovina dizajnirana je kako bi igračima pružila više vr');

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

CREATE TABLE `shoes` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `shoes_num` int(11) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shoes`
--

INSERT INTO `shoes` (`id`, `name`, `price`, `priceNOTAX`, `img_url`, `shoes_num`, `sex`, `quantity`, `category`, `description`) VALUES
(107648, 'Muške tenisice 65R3, bijelo/narančaste, 39.5', 60, 49.18, './images/product-images/badminton/shoes/107648/107648.jpg', 40, 'Muški', 5, 'badminton', 'Power Cushion 65 R 3 pristupačna je ulazna točka za kolekciju čizama Yonex 2020.\r\n\r\n\r\nKoristi dokazanu tehnologiju Power Cushion u području pete.\r\n\r\n\r\nDupli Russel Mesh vanjski materijal.\r\nHexagrip potplat od prirodne gume.\r\n\r\n\r\nČizme su opremljene tehnologijom Power Cushion. Ovaj sustav osigurava bolje prigušivanje vibracija koje se oslobađaju tijekom kretanja i slijetanja. U usporedbi s poliuretanskim potplatima, amortizira do tri puta bolje. Dodatna prednost je što se ta energija pretvara u energiju penjanja.\r\n\r\n\r\nKarakteristike:\r\n\r\nSpol: muški\r\n\r\nBoja: bijela, narančasta\r\n\r\nGornji materijal: poliuretan\r\n\r\nMaterijal potplata: EVA, guma\r\n\r\nVeličina: 39.5'),
(112478, 'Moške suoerge ECLIPSION 2 rdeča/črna, 45.5', 97, 79.86, './images/product-images/tennis/shoes/112478/112478.jpg\r\n', 46, 'Muški', 5, 'tennis', 'Yonex Športni copati ECLIPSION2- 45,5');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `number`, `password`, `is_admin`, `created_at`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(18, 'Hrvoje', 'Čučković', 'cuckovichrvoje@gmail.com', '0957056320', '$2y$10$oGxga3iLlShPb90zn.U7Iui2cq51ZhzcEHdsQoWzDX1SD6txMWGAK', 0, '2024-02-26', '9f4e3b02f30c79c8a9a206952e4ccfcf82876e3146b6c2d5170eee8570957973', '2024-05-24 18:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `product_id`, `user_id`) VALUES
(41, 114797, 25),
(55, 107648, 18),
(56, 109358, 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bags`
--
ALTER TABLE `bags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balls`
--
ALTER TABLE `balls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basicinfo`
--
ALTER TABLE `basicinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkboxfilters`
--
ALTER TABLE `checkboxfilters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classicfilters`
--
ALTER TABLE `classicfilters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cords`
--
ALTER TABLE `cords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rackets`
--
ALTER TABLE `rackets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basicinfo`
--
ALTER TABLE `basicinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `checkboxfilters`
--
ALTER TABLE `checkboxfilters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
