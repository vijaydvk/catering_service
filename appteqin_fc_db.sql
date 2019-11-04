-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2019 at 08:22 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appteqin_fc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `fc_customer_food_type`
--

CREATE TABLE `fc_customer_food_type` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `food_type_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fc_customer_tbl`
--

CREATE TABLE `fc_customer_tbl` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_phonenumber` varchar(15) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_address` varchar(500) DEFAULT NULL,
  `customer_pass` varchar(150) DEFAULT NULL,
  `customer_creditlimit` varchar(100) DEFAULT NULL,
  `customer_gst` varchar(100) DEFAULT NULL,
  `customer_alernative_phonenumber` varchar(100) DEFAULT NULL,
  `active` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fc_food_type`
--

CREATE TABLE `fc_food_type` (
  `food_type_id` int(11) NOT NULL,
  `food_type` varchar(150) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fc_food_type`
--

INSERT INTO `fc_food_type` (`food_type_id`, `food_type`, `active`) VALUES
(1, 'Breakfast', 0),
(2, 'Lunch', 0),
(3, 'Dinner', 0),
(4, 'Breakfast&Lunch', 0),
(5, 'Breakfast&Dinner', 0),
(6, 'Lunch&Dinner', 0),
(7, 'Breakfast&Lunch\r\n&Dinner', 0),
(8, 'special', 0),
(9, 'Transport', 0),
(11, 'Single meal', 0),
(12, 'Lunch NON VEG', 0),
(13, 'Corporate Lunch VEG \r\n& NON VEG', 0),
(14, 'BRIYANI COMBO', 0),
(15, 'Pongal', 0),
(16, 'Idly', 0),
(17, 'Dosai', 0),
(18, 'Veg meals', 0),
(19, 'Poori', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fc_invoice_details`
--

CREATE TABLE `fc_invoice_details` (
  `invoice_details_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `food_type_id` int(11) DEFAULT NULL,
  `description` varchar(150) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double NOT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fc_invoice_process`
--

CREATE TABLE `fc_invoice_process` (
  `process_id` int(11) NOT NULL,
  `invoice_ids` varchar(250) NOT NULL,
  `total` double DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `comment` varchar(250) DEFAULT NULL,
  `createdat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fc_invoice_tbl`
--

CREATE TABLE `fc_invoice_tbl` (
  `invoice_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `discounttype` int(1) DEFAULT NULL,
  `discountvalue` double NOT NULL,
  `total` double NOT NULL,
  `finaltotal` double NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `process` int(1) NOT NULL DEFAULT '0',
  `comment` varchar(250) NOT NULL,
  `invoice_flag` int(1) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fc_pure_invoice`
--

CREATE TABLE `fc_pure_invoice` (
  `id` int(11) NOT NULL,
  `pure_invoice_id` int(11) NOT NULL,
  `invoice_ids` varchar(2000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(11) DEFAULT NULL,
  `viewed` int(1) NOT NULL DEFAULT '0',
  `notes` varchar(250) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fc_user_tbl`
--

CREATE TABLE `fc_user_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `log` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fc_user_tbl`
--

INSERT INTO `fc_user_tbl` (`id`, `name`, `password`, `session_id`, `active`, `log`) VALUES
(1, 'admin', '120KQtYfL88ck', NULL, 0, 0),
(2, 'user', '12gcd9jnaW29c', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fc_web_menu`
--

CREATE TABLE `fc_web_menu` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(250) DEFAULT NULL,
  `category_description` varchar(2000) DEFAULT NULL,
  `category_image_url` varchar(500) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fc_web_menu`
--

INSERT INTO `fc_web_menu` (`category_id`, `category_name`, `category_description`, `category_image_url`, `active`) VALUES
(1, 'Wedding Catering', 'A Wedding is a ceremony where two people and two families unite in marriages. The ceremonies are very colorful and celebration may extend for several days. Food Corridor catering Services, the marriage catering service in Coimbatore, here to reduce your wedding work from searching of skilled cook man, trusted service people, quality store items, flower man, iyer and materials for performing the happiest wedding ceremony. We treat the guest as our guest with mouth watering foods. All you have to do is select the menu you want the guest at your wedding to taste and fill the stomach. FOOD CORRIDOR Catering Services the best catering service started for making unique, grand colorful wedding celebration with high quality varieties of food within your budget.', 'http://www.appteq.in/food_admin/uploads/wedding4.jpg', 0),
(2, 'Catering for Party Order', 'A birthday is an occasion for every child that’s too, first birthday is most aspersions, awaiting celebration, festival for whole family members. A child from birth to one year every moment of the child brings cot and lots happiness in around the home. A child smile can remove our worries. Organizing the birthday parties and inviting the guest for our children birthday party gives an immense satisfaction the memory that we carry along the growth of the child and giving them all these as memories, after they grow, make their life more added colorful the life beautiful.', 'https://foodcorridor.in/food_admin/uploads/breakfast-04.jpg', 0),
(3, 'Industrial Catering', '', 'https://foodcorridor.in/food_admin/uploads/industries_cafeteria.jpg', 0),
(4, 'Canteen  Services', '', 'https://foodcorridor.in/food_admin/uploads/cafeteria.jpg', 0),
(5, 'Housewarming', '', 'https://foodcorridor.in/food_admin/uploads/a887466406d0cac8b9b63eac0985d637.jpg', 0),
(6, 'Corporate Catering', 'Food Corridor Catering Services offer special packages for corporate clients. We plan and execute the parties, surprise birthday parties at the office, team parties, theme parties and other events. We understand better about your various needs for a great party. Hence, we always plan the corporate party along with Admin/H.R. to perfectly understand the expectations, preferences and appetites of people working for the organization. By addressing the very need of the organization, we have evolved to become the most successful corporate catering service provider. We take special care of Daily corporate catering, catering for conferences, annual functions, get together and other functions.', 'https://foodcorridor.in/food_admin/uploads/catering.jpg', 0),
(7, 'School and College Catering', '', 'https://foodcorridor.in/food_admin/uploads/karunya_school.jpg', 0),
(8, 'Snacks', '', 'https://foodcorridor.in/food_admin/uploads/snacks.jpg', 0),
(9, 'Sweets', '', 'https://foodcorridor.in/food_admin/uploads/sweetss11.jpg', 0),
(10, 'Exclusive Special Counters', '', 'https://foodcorridor.in/food_admin/uploads/fixedw_large_4x.jpg', 0),
(11, 'Non Veg Catering', '', 'https://foodcorridor.in/food_admin/uploads/ammas_special.jpg', 0),
(12, 'Special Podi', '', 'https://foodcorridor.in/food_admin/uploads/podi_recepie.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fc_web_menu_details`
--

CREATE TABLE `fc_web_menu_details` (
  `menu_details_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `menu_details_title` varchar(500) DEFAULT NULL,
  `menu_details_description` text,
  `menu_details_image_url` varchar(500) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fc_web_menu_details`
--

INSERT INTO `fc_web_menu_details` (`menu_details_id`, `category_id`, `menu_details_title`, `menu_details_description`, `menu_details_image_url`, `active`) VALUES
(2, 1, 'Lunch(WCL1)', 'Rasamalai\r\nSweet\r\nBriyani\r\nRaitha\r\nWhite rice\r\nParupu or Podi with Ghee\r\nSambar\r\nPulikulambu or Vathalkulambu\r\nRasam\r\nCurd\r\nPoriyal\r\nKootu\r\nThoovaiyal or Fry\r\nAppalam\r\nPickle\r\nVada\r\nPayasam\r\nIce Cream\r\nBeeda\r\nBanana\r\n1.Leaf Service', 'https://foodcorridor.in/food_admin/uploads/o1.jpg', 0),
(3, 1, 'Breakfast(WCBF1)', 'Sweet,\r\nMethu Vada,\r\nIdly,\r\nDosa,\r\nPongal,\r\nPoori,\r\nUppuma with choice of chutney and sambar,coffee.(All other varieties can be made on request) \r\n1)Leaf service,2)Buffet service,3)Take away', 'http://www.appteq.in/food_admin/uploads/51_1102180800266461.jpg', 0),
(4, 1, 'Canteen Services', 'We also take orders and contracts for supply of breakfast, lunch, dinner, tea, snacks for your team on daily basis. We also provide supply of food for your canteen or cafeteria.', 'http://www.appteq.in/food_admin/uploads/56_080518012040858.jpg', 0),
(5, 2, 'Cocktail', '', 'http://www.appteq.in/food_admin/uploads/t_53_080518124846658.jpg', 0),
(6, 1, 'Dinner(WCD1)', 'Sweet,\r\nMethu Vada,\r\nIdly,\r\nDosa,\r\nPongal,\r\nPoori,\r\nUppuma with choice of chutney and sambar', 'http://www.appteq.in/food_admin/uploads/54_270518030233715.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fc_web_testimonials`
--

CREATE TABLE `fc_web_testimonials` (
  `testimonial_id` int(11) NOT NULL,
  `testimonial_name` varchar(500) DEFAULT NULL,
  `testimonial_phone` varchar(500) DEFAULT NULL,
  `testimonial_description` varchar(2000) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fc_web_testimonials`
--

INSERT INTO `fc_web_testimonials` (`testimonial_id`, `testimonial_name`, `testimonial_phone`, `testimonial_description`, `active`) VALUES
(1, 'pri', '9751808080', 'ufyuglggyyfihouu8ggugugjk', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_billing`
--

CREATE TABLE `hotel_billing` (
  `id` int(11) NOT NULL,
  `billNo` varchar(20) NOT NULL,
  `billDate` varchar(20) NOT NULL,
  `billTime` varchar(100) NOT NULL,
  `disPer` varchar(20) NOT NULL,
  `disAmt` varchar(20) NOT NULL,
  `totalAmount` varchar(20) NOT NULL,
  `thirdParty` varchar(100) NOT NULL,
  `flag` int(11) NOT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel_billing`
--

INSERT INTO `hotel_billing` (`id`, `billNo`, `billDate`, `billTime`, `disPer`, `disAmt`, `totalAmount`, `thirdParty`, `flag`, `log`) VALUES
(1, '12', '12121', '1212', 'test1', '3', '33', '20030', 0, '2019-03-07 08:48:49'),
(2, '12', '12121', '1212', 'test1', '3', '33', '20030', 0, '2019-03-07 08:49:01'),
(3, '12', '12121', '1212', 'test1', '3', '33', '20030', 0, '2019-03-07 09:03:36'),
(4, '12', '10-03-2019', '12:10 pm', '10', '13.5', '121.50', 'swigy', 0, '2019-03-10 06:01:02'),
(5, '12', '10-03-2019', '12:10 pm', '10', '13.5', '121.50', 'swigy', 0, '2019-03-29 10:52:04'),
(6, '12', '10-03-2019', '12:10 pm', '10', '13.5', '121.50', 'swigy', 0, '2019-03-29 11:09:13'),
(7, '12', '10-03-2019', '12:10 pm', '10', '13.5', '121.50', 'swigy', 0, '2019-03-29 11:23:33'),
(8, '1', '29-03-2019', '05:19 PM', '0', '0', '120', '', 0, '2019-03-29 11:50:23'),
(9, '1', '30-03-2019', '11:17 AM', '20', '8.5', '77.5', '', 0, '2019-03-30 05:48:43'),
(10, '2', '30-03-2019', '11:20 AM', '0', '0', '140', 'SWIGGY', 0, '2019-03-30 05:50:44'),
(11, '3', '30-03-2019', '11:20 AM', '0', '0', '160', 'ZOMATO', 0, '2019-03-30 05:50:44'),
(12, '4', '30-03-2019', '11:40 AM', '10', '25', '225', '', 0, '2019-03-30 06:11:20'),
(13, '5', '30-03-2019', '12:12 PM', '0', '0', '25', '', 0, '2019-03-30 06:42:52'),
(14, '6', '30-03-2019', '12:13 PM', '0', '0', '50', '', 0, '2019-03-30 06:44:35'),
(15, '12', '10-03-2019', '12:10 pm', '10', '13.5', '121.50', 'swigy', 0, '2019-03-30 06:56:41'),
(16, '12', '10-03-2019', '12:10 pm', '10', '13.5', '121.50', 'swigy', 0, '2019-03-30 07:04:20'),
(17, '1', '01-04-2019', '11:27 AM', '0', '0', '120', '', 0, '2019-04-01 05:58:10'),
(18, '1', '10-05-2019', '04:16 PM', '0', '0', '70', '', 0, '2019-05-10 10:47:23'),
(19, '2', '10-05-2019', '04:18 PM', '0', '0', '25', '', 0, '2019-05-10 10:49:07'),
(20, '3', '10-05-2019', '04:23 PM', '0', '0', '25', '', 0, '2019-05-10 10:55:12'),
(21, '1', '10-05-2019', '05:52 PM', '0', '0', '400', '', 0, '2019-05-10 12:46:17'),
(22, '2', '10-05-2019', '05:54 PM', '0', '0', '401.5', '', 0, '2019-05-10 12:46:17'),
(23, '3', '10-05-2019', '05:55 PM', '0', '0', '436', '', 0, '2019-05-10 12:46:17'),
(24, '4', '10-05-2019', '05:57 PM', '0', '0', '55', '', 0, '2019-05-10 12:46:17'),
(25, '5', '10-05-2019', '05:58 PM', '0', '0', '242', 'swiggy', 0, '2019-05-10 12:46:18'),
(26, '6', '10-05-2019', '05:59 PM', '20', '24', '108', '', 0, '2019-05-10 12:46:18'),
(27, '7', '10-05-2019', '06:12 PM', '0', '0', '50', '', 0, '2019-05-10 12:48:42'),
(28, '8', '10-05-2019', '06:22 PM', '0', '0', '125', '', 0, '2019-05-10 12:58:59'),
(29, '4', '13-05-2019', '12:15 PM', '20', '34', '153', '', 0, '2019-05-13 06:50:19'),
(30, '5', '13-05-2019', '12:15 PM', '0', '0', '232', '', 0, '2019-05-13 06:50:20'),
(31, '1', '17-05-2019', '06:05 PM', '0', '0', '50', '', 0, '2019-05-17 12:47:54'),
(32, '2', '17-05-2019', '06:10 PM', '0', '0', '63', '', 0, '2019-05-17 12:47:55'),
(33, '3', '17-05-2019', '06:12 PM', '0', '0', '63', '', 0, '2019-05-17 13:03:20'),
(34, '4', '17-05-2019', '06:15 PM', '0', '0', '11.5', '', 0, '2019-05-17 13:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_billing_details`
--

CREATE TABLE `hotel_billing_details` (
  `id` int(11) NOT NULL,
  `billNo` varchar(10) NOT NULL,
  `productName` varchar(40) NOT NULL,
  `productQty` varchar(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `disPer` varchar(10) NOT NULL,
  `disAmt` int(11) NOT NULL,
  `totalAmount` varchar(20) NOT NULL,
  `flag` int(11) NOT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel_billing_details`
--

INSERT INTO `hotel_billing_details` (`id`, `billNo`, `productName`, `productQty`, `amount`, `disPer`, `disAmt`, `totalAmount`, `flag`, `log`) VALUES
(1, '12', 'test1', '3', '20030', '33', 0, '21221', 0, '2019-02-12 06:40:05'),
(2, '12', 'test1', '3', '20030', '33', 0, '21221', 0, '2019-02-12 06:40:52'),
(3, '12', 'test1', '3', '20030', '33', 0, '21221', 0, '2019-02-12 06:41:25'),
(4, '12', 'test1', '3', '20030', '33', 0, '21221', 0, '2019-02-12 06:46:43'),
(5, '12', 'asdasd', '12', '2000', '5', 20, '15000', 0, '2019-03-07 09:07:22'),
(6, '12', 'asdasd', '12', '2000', '5', 20, '15000', 0, '2019-03-07 09:07:40'),
(7, '12', 'asdasd', '12', '2000', '5', 20, '15000', 0, '2019-03-07 09:10:14'),
(8, '12', 'asdasd', '12', '2000', '5', 20, '15000', 0, '2019-03-10 05:53:35'),
(9, '13', 'test', '13', '3000', '6', 25, '5500', 0, '2019-03-10 05:53:35'),
(10, '14', 'test2', '14', '2500', '35', 2055, '65000', 0, '2019-03-10 05:53:35'),
(11, '12', 'dosai', '3', '20', '0', 0, '60', 0, '2019-03-10 05:56:42'),
(12, '12', 'idly', '5', '10', '0', 0, '25', 0, '2019-03-10 05:56:42'),
(13, '12', 'poori', '2', '25', '0', 0, '50', 0, '2019-03-10 05:56:42'),
(14, '12', 'dosai', '3', '20', '0', 0, '60', 0, '2019-03-29 10:51:38'),
(15, '12', 'idly', '5', '10', '0', 0, '25', 0, '2019-03-29 10:51:38'),
(16, '12', 'poori', '2', '25', '0', 0, '50', 0, '2019-03-29 10:51:38'),
(17, '12', 'dosai', '3', '20', '0', 0, '60', 0, '2019-03-29 11:23:05'),
(18, '12', 'idly', '5', '10', '0', 0, '25', 0, '2019-03-29 11:23:05'),
(19, '12', 'poori', '2', '25', '0', 0, '50', 0, '2019-03-29 11:23:05'),
(20, '1', 'Carrot Juice', '2', '60', '0', 0, '120', 0, '2019-03-29 11:50:23'),
(21, '1', 'Carrot Juice', '1', '60', '0', 0, '60', 0, '2019-03-30 05:48:43'),
(22, '1', 'Fresh Lime', '1', '25', '0', 0, '25', 0, '2019-03-30 05:48:43'),
(23, '2', 'Mango Juice', '2', '70', '0', 0, '140', 0, '2019-03-30 05:50:44'),
(24, '3', 'Pomegranate', '2', '80', '0', 0, '160', 0, '2019-03-30 05:50:44'),
(25, '4', 'Banana', '1', '50', '0', 0, '50', 0, '2019-03-30 06:11:20'),
(26, '4', 'Mango', '1', '80', '0', 0, '80', 0, '2019-03-30 06:11:20'),
(27, '4', 'Chikkoo', '2', '60', '0', 0, '120', 0, '2019-03-30 06:11:20'),
(28, '5', 'Fresh Lime', '1', '25', '0', 0, '25', 0, '2019-03-30 06:42:52'),
(29, '6', 'Fresh Lime', '2', '25', '0', 0, '50', 0, '2019-03-30 06:44:35'),
(30, '1', 'Vanilla', '2', '60', '0', 0, '120', 0, '2019-04-01 05:58:10'),
(31, '1', 'Butterscotch', '1', '70', '0', 0, '70', 0, '2019-05-10 10:47:23'),
(32, '2', 'Fresh Lime', '1', '25', '0', 0, '25', 0, '2019-05-10 10:49:06'),
(33, '3', 'Fresh Lime', '1', '25', '0', 0, '25', 0, '2019-05-10 10:55:12'),
(34, '1', 'Fresh Lime', '1', '25', '0', 0, '25', 0, '2019-05-10 12:46:16'),
(35, '1', 'Orange', '3', '55', '0', 0, '165', 0, '2019-05-10 12:46:16'),
(36, '1', 'Pure Apple', '1', '70', '0', 0, '70', 0, '2019-05-10 12:46:17'),
(37, '1', 'Pomegranate', '2', '70', '0', 0, '140', 0, '2019-05-10 12:46:17'),
(38, '2', 'Carrot Juice', '1', '60', '0', 0, '60', 0, '2019-05-10 12:46:17'),
(39, '2', 'Fresh Lime', '1', '25', '0', 0, '25', 0, '2019-05-10 12:46:17'),
(40, '2', 'Fresh Lime Soda(Sweet /Salt)', '2', '35', '0', 0, '70', 0, '2019-05-10 12:46:17'),
(41, '2', 'Banana', '2', '50', '0', 0, '100', 0, '2019-05-10 12:46:17'),
(42, '2', 'Dates', '1', '65', '0', 0, '65', 0, '2019-05-10 12:46:17'),
(43, '2', 'Custard Apple', '1', '65', '0', 0, '65', 0, '2019-05-10 12:46:17'),
(44, '3', 'Carrot Juice', '1', '60', '0', 0, '60', 0, '2019-05-10 12:46:17'),
(45, '3', 'Mosambi', '2', '50', '0', 0, '100', 0, '2019-05-10 12:46:17'),
(46, '3', 'Dates', '1', '65', '0', 0, '65', 0, '2019-05-10 12:46:17'),
(47, '3', 'Custard Apple', '2', '65', '0', 0, '130', 0, '2019-05-10 12:46:17'),
(48, '3', 'Butter Fruit', '1', '65', '0', 0, '65', 0, '2019-05-10 12:46:17'),
(49, '4', 'Fresh Lime', '2', '25', '0', 0, '50', 0, '2019-05-10 12:46:17'),
(50, '5', 'Pomegranate', '2', '80', '0', 0, '160', 0, '2019-05-10 12:46:17'),
(51, '5', 'Mosambi', '1', '60', '0', 0, '60', 0, '2019-05-10 12:46:17'),
(52, '6', 'Carrot Juice', '2', '60', '0', 0, '120', 0, '2019-05-10 12:46:18'),
(53, '7', 'Mosambi', '1', '50', '0', 0, '50', 0, '2019-05-10 12:48:42'),
(54, '8', 'Mango Juice', '1', '65', '0', 0, '65', 0, '2019-05-10 12:58:59'),
(55, '8', 'Carrot Juice', '1', '60', '0', 0, '60', 0, '2019-05-10 12:58:59'),
(56, '4', 'Carrot Juice', '2', '60', '0', 0, '120', 0, '2019-05-13 06:50:19'),
(57, '4', 'Mosambi', '1', '50', '0', 0, '50', 0, '2019-05-13 06:50:19'),
(58, '5', 'Banana', '2', '50', '0', 0, '100', 0, '2019-05-13 06:50:19'),
(59, '5', 'Carrot Juice', '2', '60', '0', 0, '120', 0, '2019-05-13 06:50:19'),
(60, '1', 'Ghee Roast', '1', '35', '0', 0, '35', 0, '2019-05-17 12:47:54'),
(61, '1', 'Plain Dosa', '1', '15', '0', 0, '15', 0, '2019-05-17 12:47:54'),
(62, '2', 'Idly', '1', '10', '0', 0, '10', 0, '2019-05-17 12:47:55'),
(63, '2', 'Ghee Roast', '1', '35', '0', 0, '35', 0, '2019-05-17 12:47:55'),
(64, '2', 'Plain Dosa', '1', '15', '0', 0, '15', 0, '2019-05-17 12:47:55'),
(65, '3', 'Idly', '1', '10', '0', 0, '10', 0, '2019-05-17 13:03:19'),
(66, '3', 'Plain Dosa', '1', '15', '0', 0, '15', 0, '2019-05-17 13:03:19'),
(67, '3', 'Ghee Roast', '1', '35', '0', 0, '35', 0, '2019-05-17 13:03:19'),
(68, '4', 'Idly', '1', '10', '0', 0, '10', 0, '2019-05-17 13:03:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fc_customer_food_type`
--
ALTER TABLE `fc_customer_food_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`,`food_type_id`);

--
-- Indexes for table `fc_customer_tbl`
--
ALTER TABLE `fc_customer_tbl`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `fc_food_type`
--
ALTER TABLE `fc_food_type`
  ADD PRIMARY KEY (`food_type_id`);

--
-- Indexes for table `fc_invoice_details`
--
ALTER TABLE `fc_invoice_details`
  ADD PRIMARY KEY (`invoice_details_id`);

--
-- Indexes for table `fc_invoice_process`
--
ALTER TABLE `fc_invoice_process`
  ADD PRIMARY KEY (`process_id`);

--
-- Indexes for table `fc_invoice_tbl`
--
ALTER TABLE `fc_invoice_tbl`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `fc_pure_invoice`
--
ALTER TABLE `fc_pure_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_user_tbl`
--
ALTER TABLE `fc_user_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_web_menu`
--
ALTER TABLE `fc_web_menu`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `fc_web_menu_details`
--
ALTER TABLE `fc_web_menu_details`
  ADD PRIMARY KEY (`menu_details_id`);

--
-- Indexes for table `fc_web_testimonials`
--
ALTER TABLE `fc_web_testimonials`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `hotel_billing`
--
ALTER TABLE `hotel_billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_billing_details`
--
ALTER TABLE `hotel_billing_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fc_customer_food_type`
--
ALTER TABLE `fc_customer_food_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_customer_tbl`
--
ALTER TABLE `fc_customer_tbl`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_food_type`
--
ALTER TABLE `fc_food_type`
  MODIFY `food_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `fc_invoice_details`
--
ALTER TABLE `fc_invoice_details`
  MODIFY `invoice_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_invoice_process`
--
ALTER TABLE `fc_invoice_process`
  MODIFY `process_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_invoice_tbl`
--
ALTER TABLE `fc_invoice_tbl`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_pure_invoice`
--
ALTER TABLE `fc_pure_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_user_tbl`
--
ALTER TABLE `fc_user_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fc_web_menu`
--
ALTER TABLE `fc_web_menu`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fc_web_menu_details`
--
ALTER TABLE `fc_web_menu_details`
  MODIFY `menu_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fc_web_testimonials`
--
ALTER TABLE `fc_web_testimonials`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hotel_billing`
--
ALTER TABLE `hotel_billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `hotel_billing_details`
--
ALTER TABLE `hotel_billing_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
