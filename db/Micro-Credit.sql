-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 10, 2018 at 03:26 PM
-- Server version: 5.7.22-0ubuntu18.04.1
-- PHP Version: 7.2.5-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Micro-Credit`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `DateTime`, `Name`, `Password`, `isActive`) VALUES
(1, '2018-06-01 00:00:00', 'Admin', '12345678', 1);

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `AreaName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `AreaCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LastPrintedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `DateTime`, `AreaName`, `AreaCode`, `LastPrintedDate`) VALUES
(1, '2018-06-01 00:00:00', 'Area-01', 'Area-01', '2018-06-05 04:34:51'),
(2, '2018-06-01 00:00:00', 'Area-02', 'Area-02', '2018-06-01 00:00:00'),
(3, '2018-06-01 00:00:00', 'Area-03', 'Area-03', '2018-06-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Nic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Fixed` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `DateTime`, `Name`, `Nic`, `Address`, `Mobile`, `Fixed`) VALUES
(1, '2018-06-02 08:40:17', 'W.K. IRANGANI', '196873303691', '502/16/1, HAWPE WATHTHA, THITHTHAGALLA, AHANGAMA', '0769177039', '0716344370'),
(2, '2018-06-02 08:46:07', 'J.G. ISHARA SHIWANTHI', '937714335V', 'WADIGA WATHTHA, HORADUGODA, IMADUWA', '0767900584', '0'),
(3, '2018-06-02 08:51:37', 'W.A. CHANDRALATHA', '806842311V', 'ATHURALIYA GEDARA, ELLALAGODA, IMADUWA', '0788938419', '0'),
(4, '2018-06-02 08:56:10', 'W. LAKMALI PERERA', '898611604V', 'WADIGA WATHTHA, HORADUGODA, IMADUWA', '0702689253', '0'),
(5, '2018-06-02 09:03:15', 'K.L. RUPIKA', '197751803551', 'SANDAWIMANA, ELLALAGODA, IMADUWA', '0773348773', '0'),
(6, '2018-06-02 09:08:14', 'T.M. ANUSHA LAKSHMI', '795560068V', 'ALUTH GEDARA, THITHTHAGALLA, AHANGAMA', '0772764754', '0'),
(7, '2018-06-02 09:12:23', 'W. ARIYALATHA', '607083959V', 'KAJJUGAHAWATHTHA, THITHTHAGALLA, AHANGAMA', '0775250288', '0'),
(8, '2018-06-02 09:17:52', 'G.N.M. PADMALEKA GAMAGE', '857423470V', 'KAJJUGAHAWATHTHA, THITHTHAGALLA, AHANGAMA', '0714986497', '0'),
(9, '2018-06-02 09:23:20', 'K. DANUSHIKA SANJEWANI', '867620028V', 'KAJJUGAHAWATHTHA, THITHTHAGALLA, AHANGAMA', '0750806172', '0'),
(10, '2018-06-02 09:27:43', 'K. GEETHA WASANTHI', '745722261V', 'RALAHAMIGE WATHTHA, THITHTHAGALLA, AHANGAMA', '0771548346', '0'),
(11, '2018-06-02 17:01:04', 'N.A. RUWINI DINUSHKA', '898440451V', 'DELGAHA WATHTHA, NAKANDA, AHANGAMA', '0776708531', '0'),
(12, '2018-06-02 17:08:40', 'M.K. WIJITHA KUMARI', '198454505180', '589/B/5, AMPAWILA, THITHTHAGALLA', '0755805492', '0'),
(13, '2018-06-02 17:14:54', 'W.A. CHATHURIKA PUSHPA KUMARI', '928103820V', 'GABADADUWA, INDURANNAWILA, DIKKUBURA, AHANGAMA', '0714849267', '0'),
(14, '2018-06-02 17:19:23', 'A.W.A. INDIKA WITHANAGE', '788102550V', '76/1, INDURANNAWILA, DIKKUBURA', '0726686069', '0766317389'),
(15, '2018-06-02 17:24:05', 'H.G. INOKA PRIYADARSHANI', '837084415V', 'HOMAGUDUMULLA, AMPAWILA, THITHTHAGALLA, AHANGAMA', '0763445632', '0'),
(16, '2018-06-02 17:28:52', 'R.H. DULIKA GANGANI', '907872220V', 'KOTEGODA, RABARWATHTHA, AHANGAMA', '0776677127', '0765346263'),
(17, '2018-06-02 17:32:58', 'Y.N. NILMINI DE SILVA', '738031512V', 'CHANDANA, MEKELIYAGAHA WATHTHA, AHANGAMA', '0776089331', '0'),
(18, '2018-06-02 17:37:36', 'H.G. SUSILA RANJANI', '665460509V', 'NO:02, ROTARY HOUSES, EDDUNKELE, AHANGAMA', '0778083540', '0'),
(19, '2018-06-02 17:42:48', 'A.G. SANDAMALI', '937254245V', 'LIYANGAHAWATHTHA, KOTEGODA, AHANGAMA', '0769802958', '0'),
(20, '2018-06-02 17:47:00', 'K.W. NANDANI', '196856205024', 'EGODAHAWATHTHA, GURULLAWALA, AHANGAMA', '0772311960', '0'),
(21, '2018-06-02 17:52:34', 'W.K. SAJINI SEWWANDI', '948183676V', '6 STEP, NO:12, KOTIGALAWATHTHA, DIKKUBURA', '0764522406', '0789017644'),
(22, '2018-06-02 17:56:54', 'W.A. MALANI', '576450222V', '94/3 INDURANNAWILA, DIKKUBURA', '0763712951', '0'),
(23, '2018-06-02 18:02:19', 'H.P. CHATHUNI LAKMALI', '947660861V', 'NO:30, KONGASHENA, MIDIGAMA, AHANGAMA', '0767491739', '0776871248'),
(24, '2018-06-02 18:07:19', 'K. DEEPIKA', '746390483V', '69, INDURANNAWILA, DIKKUBURA', '0767197325', '0'),
(25, '2018-06-02 18:13:20', 'N.W. RAMYA SHRIYANI', '196557902147', '96/2, PANCHALIYA, DIKKUBURA', '0771024003', '0'),
(26, '2018-06-02 18:17:40', 'W.M.D.S. KUMARI LAYANAL', '867361413V', 'PALATHURU UYANA, MALALGODAPITIYA, DIKKUBURA', '0766781182', '0'),
(27, '2018-06-02 18:23:10', 'D.R.L.T. SHYAMALI SIRIWARDHANA', '738522753V', 'NO:06, STAGE 6, KOTIGALAWATHTHA, DIKKUBURA', '0787507754', '0'),
(28, '2018-06-03 09:56:38', 'K.G. THILINI AMARADIWAKARA', '836653572V', 'NETHUPIYASA, WIDYACHANDRA MAWATHA, AHANGAMA', '0779161358', '0'),
(29, '2018-06-03 10:01:20', 'M. PRABODHA THILINI', '916582331V', 'NO:31, SHAKTHIPURA, KONGASHENA, AHANGAMA', '0763096593', '0'),
(30, '2018-06-03 10:06:13', 'L. NADEESHA DILRUKSHI', '887063028V', 'NO:20, GIGAHA KANATHTHA, NATIONAL HOUSES, IMADUWA', '0778210338', '0'),
(31, '2018-06-03 10:10:50', 'A.W. RENUKA', '197775800914', '80/2, INDURANNAWILA, DIKKUBURA, AHANGAMA', '0779489534', '0'),
(32, '2018-06-03 10:17:05', 'P. WANSAWATHI HEMALATHA', '606503032V', 'MALAPALAWATHTHA, THITHTHAGALLA, AHANGAMA', '0713397067', '0'),
(33, '2018-06-03 10:22:52', 'A. SHRIYANI', '815943589V', 'PLLIGODA, THITHTHAGALLA, AHANGAMA', '0764218354', '0'),
(34, '2018-06-03 10:26:49', 'P. INDRANI', '586360027V', 'GALLAGEWATHTHA, THITHTHAGALLA, AHANGAMA', '0915780127', '0'),
(35, '2018-06-03 10:31:38', 'A.W. ANUSHA JEEWANTHI', '857280130V', 'NO:135/E3, BERUKETIYA WATHTHA, IBBAWALA, AHANGAMA', '0767602217', '0764846364');

-- --------------------------------------------------------

--
-- Table structure for table `installment`
--

CREATE TABLE `installment` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `DateTime` datetime NOT NULL,
  `InstallmentAmount` double NOT NULL,
  `PaymentDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `installment`
--

INSERT INTO `installment` (`id`, `loan_id`, `DateTime`, `InstallmentAmount`, `PaymentDate`) VALUES
(1, 1, '2018-06-02 08:41:07', 19500, '2018-06-02 08:41:07'),
(2, 2, '2018-06-02 08:46:34', 9750, '2018-06-02 08:46:34'),
(3, 3, '2018-06-02 08:52:11', 19500, '2018-06-02 08:52:11'),
(4, 4, '2018-06-02 08:56:48', 6500, '2018-06-02 08:56:48'),
(5, 5, '2018-06-02 09:03:42', 13000, '2018-06-02 09:03:42'),
(6, 6, '2018-06-02 09:08:42', 9750, '2018-06-02 09:08:42'),
(7, 7, '2018-06-02 09:13:43', 13000, '2018-06-02 09:13:43'),
(8, 8, '2018-06-02 09:18:07', 9750, '2018-06-02 09:18:07'),
(9, 9, '2018-06-02 09:23:35', 13000, '2018-06-02 09:23:35'),
(12, 10, '2018-06-02 15:01:54', 9750, '2018-06-02 15:01:54'),
(13, 11, '2018-06-02 17:02:09', 5200, '2018-06-02 17:02:09'),
(14, 12, '2018-06-02 17:09:03', 5200, '2018-06-02 17:09:03'),
(15, 13, '2018-06-02 17:15:19', 7800, '2018-06-02 17:15:19'),
(16, 14, '2018-06-02 17:19:52', 5850, '2018-06-02 17:19:52'),
(17, 15, '2018-06-02 17:24:30', 10400, '2018-06-02 17:24:30'),
(18, 16, '2018-06-02 17:29:18', 5200, '2018-06-02 17:29:18'),
(19, 17, '2018-06-02 17:33:21', 15600, '2018-06-02 17:33:21'),
(20, 18, '2018-06-02 17:38:11', 9750, '2018-06-02 17:38:11'),
(21, 19, '2018-06-02 17:43:18', 3900, '2018-06-02 17:43:18'),
(22, 20, '2018-06-02 17:47:26', 7800, '2018-06-02 17:47:26'),
(23, 21, '2018-06-02 17:53:07', 4900, '2018-06-02 17:53:07'),
(24, 22, '2018-06-02 17:57:33', 1950, '2018-06-02 17:57:33'),
(25, 23, '2018-06-02 18:02:49', 7700, '2018-06-02 18:02:49'),
(26, 24, '2018-06-02 18:07:50', 2600, '2018-06-02 18:07:50'),
(27, 25, '2018-06-02 18:13:50', 2600, '2018-06-02 18:13:50'),
(28, 26, '2018-06-02 18:18:06', 13000, '2018-06-02 18:18:06'),
(29, 27, '2018-06-02 18:23:40', 2600, '2018-06-02 18:23:40'),
(30, 29, '2018-06-03 10:01:44', 1300, '2018-06-03 10:01:44'),
(32, 31, '2018-06-03 10:34:07', 1950, '2018-06-03 10:34:07'),
(33, 18, '2018-06-05 05:47:03', 3250, '2018-06-05 05:47:03'),
(34, 28, '2018-06-05 05:50:24', 7150, '2018-06-05 05:50:24'),
(35, 1, '2018-06-05 18:36:09', 3900, '2018-06-05 18:36:09'),
(36, 2, '2018-06-05 18:36:21', 1950, '2018-06-05 18:36:21'),
(37, 3, '2018-06-05 18:36:34', 3900, '2018-06-05 18:36:34'),
(38, 4, '2018-06-05 18:36:54', 1300, '2018-06-05 18:36:54'),
(39, 5, '2018-06-05 18:37:07', 2500, '2018-06-05 18:37:07'),
(40, 6, '2018-06-05 18:37:20', 1950, '2018-06-05 18:37:20'),
(41, 7, '2018-06-05 18:37:34', 2000, '2018-06-05 18:37:34'),
(42, 8, '2018-06-05 18:37:46', 1950, '2018-06-05 18:37:46'),
(43, 10, '2018-06-05 18:38:00', 1950, '2018-06-05 18:38:00'),
(44, 13, '2018-06-05 18:38:37', 1950, '2018-06-05 18:38:37'),
(45, 14, '2018-06-05 18:38:48', 3900, '2018-06-05 18:38:48'),
(46, 15, '2018-06-05 18:39:00', 2600, '2018-06-05 18:39:00'),
(47, 16, '2018-06-05 18:39:08', 1300, '2018-06-05 18:39:08'),
(48, 17, '2018-06-05 18:39:17', 3900, '2018-06-05 18:39:17'),
(49, 19, '2018-06-05 18:39:29', 1300, '2018-06-05 18:39:29'),
(50, 20, '2018-06-05 18:39:41', 2600, '2018-06-05 18:39:41'),
(51, 21, '2018-06-05 18:39:57', 2000, '2018-06-05 18:39:57'),
(52, 25, '2018-06-05 18:40:20', 1300, '2018-06-05 18:40:20'),
(53, 26, '2018-06-05 18:40:34', 6500, '2018-06-05 18:40:34'),
(54, 27, '2018-06-05 18:40:42', 1300, '2018-06-05 18:40:42'),
(55, 30, '2018-06-05 18:40:59', 1300, '2018-06-05 18:40:59'),
(56, 30, '2018-06-05 18:41:23', 2000, '2018-06-05 18:41:23'),
(57, 31, '2018-06-05 18:41:40', 1950, '2018-06-05 18:41:40'),
(58, 32, '2018-06-05 18:41:51', 1300, '2018-06-05 18:41:51'),
(59, 33, '2018-06-05 18:41:59', 1300, '2018-06-05 18:41:59'),
(60, 34, '2018-06-05 18:42:05', 1300, '2018-06-05 18:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `DateTime` datetime NOT NULL,
  `LoanAmount` double NOT NULL,
  `LoanCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `StartedDate` datetime NOT NULL,
  `Interest` double NOT NULL,
  `Period` int(11) NOT NULL,
  `isComplete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`id`, `area_id`, `customer_id`, `DateTime`, `LoanAmount`, `LoanCode`, `StartedDate`, `Interest`, `Period`, `isComplete`) VALUES
(1, 1, 1, '2018-06-02 08:40:17', 30000, 'MT000001', '2018-04-22 00:00:00', 0.3, 70, 0),
(2, 1, 2, '2018-06-02 08:46:07', 15000, 'MT000002', '2018-04-28 00:00:00', 0.3, 70, 0),
(3, 1, 3, '2018-06-02 08:51:37', 30000, 'MT000003', '2018-04-28 00:00:00', 0.3, 70, 0),
(4, 1, 4, '2018-06-02 08:56:10', 10000, 'MT000004', '2018-04-28 00:00:00', 0.3, 70, 0),
(5, 1, 5, '2018-06-02 09:03:15', 20000, 'MT000005', '2018-04-28 00:00:00', 0.3, 70, 0),
(6, 1, 6, '2018-06-02 09:08:14', 15000, 'MT000006', '2018-04-28 00:00:00', 0.3, 70, 0),
(7, 1, 7, '2018-06-02 09:12:23', 20000, 'MT000007', '2018-04-28 00:00:00', 0.3, 70, 0),
(8, 1, 8, '2018-06-02 09:17:52', 15000, 'MT000008', '2018-04-28 00:00:00', 0.3, 70, 0),
(9, 1, 9, '2018-06-02 09:23:20', 20000, 'MT000009', '2018-04-28 00:00:00', 0.3, 70, 0),
(10, 1, 10, '2018-06-02 09:27:43', 15000, 'MT000010', '2018-04-28 00:00:00', 0.3, 70, 0),
(11, 1, 11, '2018-06-02 17:01:04', 10000, 'MT000011', '2018-05-02 00:00:00', 0.3, 70, 0),
(12, 1, 12, '2018-06-02 17:08:40', 10000, 'MT000012', '2018-05-02 00:00:00', 0.3, 70, 0),
(13, 1, 13, '2018-06-02 17:14:54', 15000, 'MT000013', '2018-05-03 00:00:00', 0.3, 70, 0),
(14, 1, 14, '2018-06-02 17:19:23', 15000, 'MT000014', '2018-05-03 00:00:00', 0.3, 70, 0),
(15, 1, 15, '2018-06-02 17:24:05', 20000, 'MT000015', '2018-05-03 00:00:00', 0.3, 70, 0),
(16, 1, 16, '2018-06-02 17:28:52', 10000, 'MT000016', '2018-05-03 00:00:00', 0.3, 70, 0),
(17, 1, 17, '2018-06-02 17:32:58', 30000, 'MT000017', '2018-05-03 00:00:00', 0.3, 70, 0),
(18, 1, 18, '2018-06-02 17:37:36', 25000, 'MT000018', '2018-05-03 00:00:00', 0.3, 70, 0),
(19, 1, 19, '2018-06-02 17:42:48', 10000, 'MT000019', '2018-05-08 00:00:00', 0.3, 70, 0),
(20, 1, 20, '2018-06-02 17:47:00', 20000, 'MT000020', '2018-05-10 00:00:00', 0.3, 70, 0),
(21, 1, 21, '2018-06-02 17:52:34', 15000, 'MT000021', '2018-05-10 00:00:00', 0.3, 70, 0),
(22, 1, 22, '2018-06-02 17:56:54', 5000, 'MT000022', '2018-05-10 00:00:00', 0.3, 70, 0),
(23, 1, 23, '2018-06-02 18:02:19', 20000, 'MT000023', '2018-05-10 00:00:00', 0.3, 70, 0),
(24, 1, 24, '2018-06-02 18:07:19', 10000, 'MT000024', '2018-05-15 00:00:00', 0.3, 70, 0),
(25, 1, 25, '2018-06-02 18:13:20', 10000, 'MT000025', '2018-05-15 00:00:00', 0.3, 70, 0),
(26, 1, 26, '2018-06-02 18:17:40', 50000, 'MT000026', '2018-05-15 00:00:00', 0.3, 70, 0),
(27, 1, 27, '2018-06-02 18:23:10', 10000, 'MT000027', '2018-05-15 00:00:00', 0.3, 70, 0),
(28, 1, 28, '2018-06-03 09:56:38', 55000, 'MT000028', '2018-05-22 00:00:00', 0.3, 70, 0),
(29, 1, 29, '2018-06-03 10:01:20', 10000, 'MT000029', '2018-05-22 00:00:00', 0.3, 70, 0),
(30, 1, 30, '2018-06-03 10:06:13', 15000, 'MT000030', '2018-05-25 00:00:00', 0.3, 70, 0),
(31, 1, 31, '2018-06-03 10:10:50', 15000, 'MT000031', '2018-05-25 00:00:00', 0.3, 70, 0),
(32, 1, 32, '2018-06-03 10:17:05', 10000, 'MT000032', '2018-05-30 00:00:00', 0.3, 70, 0),
(33, 1, 33, '2018-06-03 10:22:52', 10000, 'MT000033', '2018-05-30 00:00:00', 0.3, 70, 0),
(34, 1, 34, '2018-06-03 10:26:49', 10000, 'MT000034', '2018-05-30 00:00:00', 0.3, 70, 0),
(35, 1, 35, '2018-06-03 10:31:38', 20000, 'MT000035', '2018-05-30 00:00:00', 0.3, 70, 0);

-- --------------------------------------------------------

--
-- Table structure for table `loans_witnesses`
--

CREATE TABLE `loans_witnesses` (
  `loan_id` int(11) NOT NULL,
  `witness_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loans_witnesses`
--

INSERT INTO `loans_witnesses` (`loan_id`, `witness_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(5, 9),
(5, 10),
(6, 11),
(6, 12),
(7, 13),
(7, 14),
(8, 15),
(8, 16),
(9, 17),
(9, 18),
(10, 19),
(10, 20),
(11, 21),
(11, 22),
(12, 23),
(12, 24),
(13, 25),
(13, 26),
(14, 27),
(14, 28),
(15, 29),
(15, 30),
(16, 31),
(16, 32),
(17, 33),
(17, 34),
(18, 35),
(18, 36),
(19, 37),
(19, 38),
(20, 39),
(20, 40),
(21, 41),
(21, 42),
(22, 43),
(22, 44),
(23, 45),
(23, 46),
(24, 47),
(24, 48),
(25, 49),
(25, 50),
(26, 51),
(26, 52),
(27, 53),
(27, 54),
(28, 55),
(28, 56),
(29, 57),
(29, 58),
(30, 59),
(30, 60),
(31, 61),
(31, 62),
(32, 63),
(32, 64),
(33, 65),
(33, 66),
(34, 67),
(34, 68),
(35, 69),
(35, 70);

-- --------------------------------------------------------

--
-- Table structure for table `witness`
--

CREATE TABLE `witness` (
  `id` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Nic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Fixed` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `witness`
--

INSERT INTO `witness` (`id`, `DateTime`, `Name`, `Nic`, `Address`, `Mobile`, `Fixed`) VALUES
(1, '2018-06-02 08:40:17', 'T.G. CHANDRARAJINI', '756163450V', 'No:06, HAWPE WATHTHA, THITHTHAGALLA, AHANGAMA', '0754132318', '0'),
(2, '2018-06-02 08:40:17', 'W.K.D.S. KUMARA', '862272846V', '502/16/1, HAWPE WATHTHA, THITHTHAGALLA, AHANGAMA', '0', '0'),
(3, '2018-06-02 08:46:07', 'D.L. CHATHURI IMALKA', '786350387V', 'ALUTHGEDARA WATHTHA, HORADUGODA, IMADUWA', '0713163566', '0'),
(4, '2018-06-02 08:46:07', 'J.G. NILUKA SHIWANTHI', '867881778V', 'WADIGA WATHTHA, HORADUGODA, IMADUWA', '0', '0'),
(5, '2018-06-02 08:51:37', 'E.A. YAMUNA RUWANI', '197759600582', 'YAMUNA, HORADUGODA, IMADUWA', '0778190223', '0'),
(6, '2018-06-02 08:51:37', 'J.G. KUSUMAWATHI', '656251000V', 'HORADUGODA, IMADUWA', '0726871180', '0'),
(7, '2018-06-02 08:56:10', 'J.G. THARAKA SANKALPANI', '916900503v', 'PERAMUNAWATHTHA, HORADUGODA, IMADUWA', '0770508644', '0'),
(8, '2018-06-02 08:56:10', 'W.R. LALITHA', '678480134V', 'POLWATHTHA, KODAGODA, IMADUWA', '0', '0'),
(9, '2018-06-02 09:03:15', 'K. KAMANI PUSHPIKA', '197965702930', '144, GOLDEN CETY, IBBAWALA, WELIGAMA', '0775701487', '0'),
(10, '2018-06-02 09:03:15', 'A.G.G. JAGATH GAMAGE', '722071727V', 'SANDAWIMANA, ELLALAGODA, IMADUWA', '0', '0'),
(11, '2018-06-02 09:08:14', 'K. CHANDIMA NISANSALA', '857600223V', 'ALUTHGEDARA, THITHTHAGALLA, AHANGAMA', '0914909863', '0'),
(12, '2018-06-02 09:08:14', 'P. SAMAN KUMARA', '733153288V', 'ALUTH GEDARA, THITHTHAGALLA, AHANGAMA', '0', '0'),
(13, '2018-06-02 09:12:23', 'K.B. CHANDRAWATHI', '588622029V', 'KAJJUGAHAWATHTHA, THITHTHAGALLA, AHANGAMA', '0714929179', '0'),
(14, '2018-06-02 09:12:23', 'K. ASHEN ISHARA', '950223170V', 'KAJJUGAHAWATHTHA, THITHTHAGALLA, AHANGAMA', '0', '0'),
(15, '2018-06-02 09:17:52', 'I. NILANTHI', '958231210V', 'UDAHAGEDARA, THITHTHAGALLA, AHANGAMA', '0757767826', '0'),
(16, '2018-06-02 09:17:52', 'W. SHRIYANI SHRIYALATHA', '718160030V', 'THITHTHAGALLA, AHANGAMA', '0', '0'),
(17, '2018-06-02 09:23:20', 'I. CHANDRALATHA', '755650897V', 'UDAHAGEDARA, THITHTHAGALLA, AHANGAMA', '0779917619', '0'),
(18, '2018-06-02 09:23:20', 'G.N.M. PADMALEKA GAMAGE', '857423470V', 'KAJJUGAHAWATHTHA, THITHTHAGALLA, AHANGAMA', '0', '0'),
(19, '2018-06-02 09:27:43', 'A. SHRIYANI', '815943589V', 'PALLIGODA, THITHTHAGALLA, AHANGAMA', '0775111156', '0'),
(20, '2018-06-02 09:27:43', 'K. WAYALAT', '646611415V', 'DELGAHA WATHTHA, THITHTHAGALLA, AHANGAMA', '0', '0'),
(21, '2018-06-02 17:01:04', 'K.G. LAKMALI', '866072574V', 'NO:15 METRO PARK, NONDIYAWATHTHA, NAKANDA, AHANGAMA', '0776741367', '0'),
(22, '2018-06-02 17:01:04', 'A.W.B. DAMINDA SAMPATH', '882120716V', 'DELGAHAWATHTHA, NAKANDA, AHANGAMA', '0', '0'),
(23, '2018-06-02 17:08:40', 'W. CHANDRALATHA', '628021236V', 'MAHA PATHTHINI DEWALAYA, MEEPE GEDARA, THITHTHAGALLA, AHANGAMA', '0770584607', '0'),
(24, '2018-06-02 17:08:40', 'L.H. SAMPATH', '198331702441', '589/B/5, AMPAWILA, AHANGAMA', '0', '0'),
(25, '2018-06-02 17:14:54', 'T.M. AMALI RANGIKA', '855650436V', 'GABADADUWA, INDURANNAWILA, AHANGAMA', '0719134703', '0'),
(26, '2018-06-02 17:14:54', 'A.W.A. INDIKA WITHANAGE', '788102550V', '76/1, INDURANNAWILA, DIKKUBURA', '0', '0'),
(27, '2018-06-02 17:19:23', 'K. DEPIKA', '746390483V', 'NO:69, INDURANNAWILA, DIKKUBURA, AHANGAMA', '0767197325', '0'),
(28, '2018-06-02 17:19:23', 'D. SUJITH WEERAWARDHANA', '783480018V', '76/1, INDURANNAWILA, DIKKUBURA', '0', '0'),
(29, '2018-06-02 17:24:05', 'P.W. WINETHA', '635333251V', 'HOMAGUDUMULLA, THITHTHAGALLA, AHANGAMA', '0765448441', '0'),
(30, '2018-06-02 17:24:05', 'M.K. UDUL', '792845053V', 'HOMAGUDUMULLA, AMPAWILA, THITHTHAGALLA, AHANGAMA', '0', '0'),
(31, '2018-06-02 17:28:52', 'W.K. NIRMALA KUMARI', '856324117V', '151A, DOLAGAWA WATHTHA, MEEGAHAGODA, AHANGAMA', '0779639613', '0'),
(32, '2018-06-02 17:28:52', 'J.G. WASANTHA', '647340474V', 'KOTEGODA, AHANGAMA', '0', '0'),
(33, '2018-06-02 17:32:58', 'J.P. NADEKA JAYAWEERA', '867763503V', 'KOTEGODA, AHANGAMA', '0766594285', '0'),
(34, '2018-06-02 17:32:58', 'R. RENUKA', '196563304835', '5/A, KOTEGODA, RABARWATHTHA, AHANGAMA', '0', '0'),
(35, '2018-06-02 17:37:36', 'K.T. THAKSHILA DILRUKSHI', '958110120V', 'NO:08, ROTARY HOUSES, EDDUNKELE, AHANGAMA', '0775398890', '0'),
(36, '2018-06-02 17:37:36', 'K.P. NANDANA PREMASIRI', '641561142V', 'NO:02, ROTARY HOUSES, EDDUNKELE, AHANGAMA', '0', '0'),
(37, '2018-06-02 17:42:48', 'O.D. NILANTHI', '197280403121', 'BEBINA NIWASA, HEENATIGALA WATHTHA, KOTEGODA, AHANGAMA', '0786482599', '0'),
(38, '2018-06-02 17:42:48', 'RANJITH UDAYA KUMARA', '890544711V', 'LIYANGAHAWATHTHA, KOTEGODA, AHANGAMA', '0', '0'),
(39, '2018-06-02 17:47:00', 'K.W. CHANDIMA', '908164776V', 'RANAWIRU GAMMANAYA, GURULLAWALA, AHANGAMA', '0773030405', '0'),
(40, '2018-06-02 17:47:00', 'G.P.K. PRADEEPA KUMARI', '863322585V', 'EGODAHAWATHTHA, GURULLAWALA, AHANGAMA', '0', '0'),
(41, '2018-06-02 17:52:34', 'S. SHAMALI', '855690390V', 'KOTIGALAWATHTHA, DIKKUBURA, AHANGAMA', '0776935183', '0'),
(42, '2018-06-02 17:52:34', 'M.A.M. RUWAN KUMARA', '961460999V', '6 STEP, NO:12, KOTIGALAWATHTHA, DIKKUBURA', '0', '0'),
(43, '2018-06-02 17:56:54', 'B.G. SHA SANDAMALI', '835654052V', '94/5, INDURANNAWILA, DIKKUBURA', '0779110096', '0'),
(44, '2018-06-02 17:56:54', 'K.G. CHANUKA RUSITH', '972850730V', 'NO:94/3, INDURANNAWILA, DIKKUBURA', '0', '0'),
(45, '2018-06-02 18:02:19', 'M. PRABODHA THILINI', '916582331V', 'NO:31, SHAKTHIPURA, KONGASHENA, AHANGAMA', '0763096593', '0'),
(46, '2018-06-02 18:02:19', 'M.M.M. PRADEEP KUMARA', '922914834V', 'NO:30, KONGASHENA, MIDIGAMA, AHANGAMA', '0', '0'),
(47, '2018-06-02 18:07:19', 'M.E. AMITHA', '625834287V', 'NO:94, INDURANNAWILA, AHANGAMA', '0789409991', '0'),
(48, '2018-06-02 18:07:19', 'A. RAMYASIRI', '650771834V', '69, INDURANNAWILA, DIKKUBURA, AHANGAMA', '0', '0'),
(49, '2018-06-02 18:13:20', 'W.P. CHANDRIKA', '745980252V', 'NO:02, DINU, DELGAHAWATHTHA, PANCHALIYA, AHANGAMA', '0766146897', '0'),
(50, '2018-06-02 18:13:20', 'P. OSHAN SASANKA', '980930106V', '96/2 INDURANNAWILA, DIKKUBURA', '0', '0'),
(51, '2018-06-02 18:17:40', 'A.G. MALANI', '835964280V', 'PALATHURU UYANA, MALALGODAPITIYA, DIKKUBURA', '0773572583', '0'),
(52, '2018-06-02 18:17:40', 'W.G. JAYANTHA', '832234133V', 'PALATHURU UYANA, MALALGODAPITIYA, DIKKUBURA', '0', '0'),
(53, '2018-06-02 18:23:10', 'W.K. SAJINI SEWWANDI', '948183676V', '6 STEP, NO:12, KOTIGALAWATHTHA, DIKKUBURA', '0764522406', '0'),
(54, '2018-06-02 18:23:10', 'K.D. RASIKA PRIYANGANI', '878572840V', 'NO:7, 5 STEP, KOTIGALAWATHTHA, DIKKUBURA', '0', '0'),
(55, '2018-06-03 09:56:38', 'L. NADEESHA DILRUKSHI', '887063028V', 'NO:20, GIGAHA KANATHTHA, NATIONAL HOUSES, IMADUWA', '0778210338', '0'),
(56, '2018-06-03 09:56:38', 'J.W.S. MANOJ KUMARA', '793293127V', 'NETHUPIYASA, WIDYAVHANDRA MAWATHA, AHANGAMA', '0', '0'),
(57, '2018-06-03 10:01:20', 'H.P. CHATHUNI LAKMALI', '947660861V', 'NO:30, KONGASHENA, MIDIGAMA, AHANGAMA', '0767491739', '0'),
(58, '2018-06-03 10:01:20', 'M.H. RASIKA PRIYANKARA', '871913650V', 'NO:31, SHAKTHIPURA, KONGASHENA, AHANGAMA', '0', '0'),
(59, '2018-06-03 10:06:13', 'K.G. THILINI AMARADIWAKARA', '836653572V', 'NETHUPIYASA, WIDYACHANDRA MAWATHA, AHANGAMA', '0779161358', '0'),
(60, '2018-06-03 10:06:13', 'K.L. SHANTHI WINIFREEDA', '195953200976', 'NO:20, GIGAHA KANATHTHA, NATIONAL HOUSES, IMADUWA', '0', '0'),
(61, '2018-06-03 10:10:50', 'S.K. WASANTHA', '617483882V', 'NO:80, INDURANNAWILA, DIKKUBURA', '0', '0'),
(62, '2018-06-03 10:10:50', 'W. SUPUN MADUSHAN', '981752945V', '80/2, INDURANNAWILA, DIKKUBURA', '0', '0'),
(63, '2018-06-03 10:17:05', 'P. PIYASILI', '196359400549', 'DINUKA, MALAPALAWATHTHA, THITHTHAGALLA, AHANGAMA', '0712253343', '0'),
(64, '2018-06-03 10:17:05', 'M. NIRANJALA PRIYADARSHANI', '917581452V', 'MALAPALAWATHTHA, THITHTHAGALLA, AHANGAMA', '0', '0'),
(65, '2018-06-03 10:22:52', 'K. GEETHA WASANTHI', '745722261V', 'RALAHAMIGE WATHTHA, THITHTHAGALLA, AHANGAMA', '0771548346', '0'),
(66, '2018-06-03 10:22:52', 'M. CHANDIMALI', '838023959V', 'THITHTHAGALLA, AHANGAMA', '0771608047', '0'),
(67, '2018-06-03 10:26:49', 'W. HEMALATHA', '527940494V', 'GALLAGEWATHTHA, THITHTHAGALLA, AHAMGAMA', '0775117476', '0'),
(68, '2018-06-03 10:26:49', 'W.W. HARSHANI DULAKSHIKA', '996750060V', 'GALLAGEWATHTHA, THITHTHAGALLA, AHANGAMA', '0', '0'),
(69, '2018-06-03 10:31:38', 'G.H. SANOJA PRIYADARSHANI', '798052411V', 'BERUKETIYAWATHTHA, IBBAWALA, WELIGAMA', '0717181612', '0'),
(70, '2018-06-03 10:31:38', 'S.N. CHAMINDA SANJEEWA', '840064719V', 'NO:135/E3, BERUKETIYA WATHTHA, THITHTHAGALLA, AHANGAMA', '0', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D7943D68F1EA5CB6` (`AreaCode`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installment`
--
ALTER TABLE `installment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B778ACDCE73868F` (`loan_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C5D30D03BD0F409C` (`area_id`),
  ADD KEY `IDX_C5D30D039395C3F3` (`customer_id`);

--
-- Indexes for table `loans_witnesses`
--
ALTER TABLE `loans_witnesses`
  ADD PRIMARY KEY (`loan_id`,`witness_id`),
  ADD KEY `IDX_E95E9079CE73868F` (`loan_id`),
  ADD KEY `IDX_E95E9079F28D7E1C` (`witness_id`);

--
-- Indexes for table `witness`
--
ALTER TABLE `witness`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `installment`
--
ALTER TABLE `installment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `witness`
--
ALTER TABLE `witness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `installment`
--
ALTER TABLE `installment`
  ADD CONSTRAINT `FK_4B778ACDCE73868F` FOREIGN KEY (`loan_id`) REFERENCES `loan` (`id`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `FK_C5D30D039395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `FK_C5D30D03BD0F409C` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`);

--
-- Constraints for table `loans_witnesses`
--
ALTER TABLE `loans_witnesses`
  ADD CONSTRAINT `FK_E95E9079CE73868F` FOREIGN KEY (`loan_id`) REFERENCES `loan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E95E9079F28D7E1C` FOREIGN KEY (`witness_id`) REFERENCES `witness` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;