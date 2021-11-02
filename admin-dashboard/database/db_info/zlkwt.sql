-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2020 at 11:01 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zlkwt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adm_id` int(11) NOT NULL COMMENT 'admin id',
  `adm_name` varchar(255) NOT NULL COMMENT 'admin name',
  `adm_mail` varchar(255) NOT NULL COMMENT 'admin mail',
  `adm_password` varchar(255) NOT NULL COMMENT 'admin password',
  `adm_avatar` varchar(255) NOT NULL COMMENT 'admin avatar',
  `adm_status` int(11) DEFAULT '0',
  `date_register` datetime NOT NULL COMMENT 'admin date register'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all s';

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adm_id`, `adm_name`, `adm_mail`, `adm_password`, `adm_avatar`, `adm_status`, `date_register`) VALUES
(1, 'zlkwt', 'zlkwt2020@gmail.com', '4fb19977d0ddf332b11195ade5d85aed', '644338_image4.jpeg', 1, '2020-06-16 00:00:00'),
(2, 'fdfdfdfd', 'fgfggfhg@gmail.com', 'a07ac98d82e3aa50376f3c9947a37d44c4f02635', '65352_7.jpg', 1, '2020-07-02 01:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL COMMENT 'category ID',
  `c_name` varchar(255) NOT NULL COMMENT 'category name',
  `c_description` text NOT NULL COMMENT 'Category Description',
  `c_picture` varchar(255) NOT NULL COMMENT 'category photo',
  `active` int(11) NOT NULL DEFAULT '0' COMMENT 'category is active or pending',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT 'categories parent',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'categories date insert'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info special categories ';

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `c_name`, `c_description`, `c_picture`, `active`, `parent`, `timestamp`) VALUES
(2, 'Custom Bracelets', 'This Category special all Custom Bracelets.', '221664_5.jpg', 0, 0, '2020-06-29 22:08:58'),
(3, 'Bracelets Men', 'This Category special Bracelets Men.', '569826_image4.jpeg', 0, 2, '2020-06-28 18:47:17'),
(4, 'Bracelets Women', 'This category special Bracelets Women.', '205254_3.jpg', 0, 2, '2020-06-28 18:48:04'),
(5, 'Bracelets Girls', 'This is category all special Bracelets Girls.', '985385_image9.jpg', 0, 2, '2020-06-28 18:48:49'),
(6, 'Bracelets Boys', 'This category special Bracelets Boys.', '759107_image7.jpeg', 0, 2, '2020-06-28 18:49:40'),
(7, 'Custom Necklaces', 'This category special Custom Necklaces.', '654121_image1.jpeg', 0, 0, '2020-06-29 21:36:54'),
(8, 'Custom Keychains', 'This category Custom Keychains.', '962398_image6.jpeg.jpeg', 0, 0, '2020-06-28 18:53:22'),
(9, 'Earrings', 'This is Earrings parent category.', '839625_6.jpg', 0, 0, '2020-10-14 09:09:08'),
(11, 'Earrings Girls', 'This is Earrings Girls Category', '812277_brown-bracelet-boys.jpg', 0, 9, '2020-07-06 19:24:03'),
(12, 'Nose Rings', 'This is Nose Rings category', '838286_red-girl.jpg', 0, 0, '2020-10-14 08:37:59'),
(13, 'Belly Rings', 'This is Belly Rings category', '924799_wide-black-studded-cuff-bracelet.jpg', 0, 0, '2020-10-14 09:03:02'),
(14, 'Girls Jewelries', 'This is Girls Jewelries category', '529412_braided-bracelets-collection.jpg', 0, 0, '2020-07-06 19:21:14'),
(18, 'Earning Teens', 'All special Earning Teens', '984172_19086_coordinates-bracelets-collections.jpg', 0, 9, '2020-10-14 08:35:42');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_id` int(11) NOT NULL COMMENT 'customer id',
  `cus_name` varchar(255) NOT NULL COMMENT 'customer name',
  `cus_mail` varchar(255) NOT NULL COMMENT 'customer mail',
  `cus_password` varchar(255) NOT NULL,
  `cus_phone` int(11) NOT NULL COMMENT 'customer phone',
  `cus_avatar` varchar(255) NOT NULL COMMENT 'customer avatar',
  `cus_enter_date` datetime NOT NULL COMMENT 'customer date register',
  `cus_city` varchar(255) NOT NULL COMMENT 'customer city'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about customers';

-- --------------------------------------------------------

--
-- Table structure for table `favorite_products`
--

CREATE TABLE `favorite_products` (
  `p_fav` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `ord_detail_id` int(11) NOT NULL COMMENT 'order details id',
  `productID` int(11) NOT NULL COMMENT 'product id special order',
  `customerID` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `ord_number` int(11) NOT NULL COMMENT 'order number',
  `ord_quantity` int(11) NOT NULL COMMENT 'order quantity',
  `size` varchar(255) NOT NULL COMMENT 'product size',
  `order_id` int(11) NOT NULL COMMENT 'order id',
  `product_color` varchar(255) NOT NULL COMMENT 'bracelet color',
  `bracelet_type` varchar(255) NOT NULL COMMENT 'bracelet type',
  `text_engraving` varchar(255) NOT NULL DEFAULT 'not_found',
  `position_txt_eng` varchar(255) NOT NULL DEFAULT 'not_found',
  `product_f_price` int(11) NOT NULL COMMENT 'product final price',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about order detail';

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ord_id` int(11) NOT NULL COMMENT 'order id',
  `customerID` int(11) NOT NULL COMMENT 'customer id',
  `ord_number` int(11) NOT NULL DEFAULT '0' COMMENT 'order number',
  `payment_type` varchar(255) NOT NULL COMMENT 'payment type',
  `f_name` varchar(255) NOT NULL COMMENT 'customer for full name ',
  `s_name` varchar(255) NOT NULL,
  `country_key` int(11) NOT NULL,
  `cus_phone_number` int(11) NOT NULL COMMENT 'customer phone number',
  `cus_whats_number` int(11) NOT NULL,
  `area_address` varchar(255) NOT NULL COMMENT 'first address customer',
  `s_address` varchar(255) NOT NULL DEFAULT 'not_found' COMMENT 'second address',
  `additional_information` text COMMENT 'customer city',
  `custmer_area` varchar(255) NOT NULL,
  `ord_total_price` int(11) NOT NULL COMMENT 'order total price',
  `ord_date` date NOT NULL COMMENT 'order date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about orders';

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `email` varchar(255) NOT NULL COMMENT 'email special person who forget pass',
  `p_key` varchar(255) NOT NULL COMMENT 'key will send',
  `expDate` datetime NOT NULL COMMENT 'key expiry date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL COMMENT 'product name',
  `p_description` text NOT NULL COMMENT 'product description',
  `p_picture` varchar(255) NOT NULL COMMENT 'product picture',
  `discount` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'discount price',
  `price` int(11) NOT NULL COMMENT 'product price',
  `categoryID` int(11) NOT NULL COMMENT 'category identifier',
  `Ranking` int(11) NOT NULL COMMENT 'product ranking',
  `country_made` varchar(255) NOT NULL COMMENT 'product country made',
  `status_material` varchar(255) NOT NULL COMMENT 'product status [ new - old - e.g]',
  `product_status` int(11) NOT NULL DEFAULT '0' COMMENT 'product approved or not',
  `available_product_num` int(11) NOT NULL DEFAULT '0',
  `orders_number` int(11) NOT NULL DEFAULT '0' COMMENT 'done product sell',
  `done_sell` int(11) NOT NULL DEFAULT '0',
  `date_inserted` datetime NOT NULL COMMENT 'product date inserted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about products';

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `p_description`, `p_picture`, `discount`, `price`, `categoryID`, `Ranking`, `country_made`, `status_material`, `product_status`, `available_product_num`, `orders_number`, `done_sell`, `date_inserted`) VALUES
(1, 'rrrrrrrrrrrrrrrrrrrr', 'rrrrrrrrrrrrrrrrrrrrrrrr', '951669_6.jpg', 4, 333, 6, 1, 'America', 'like-new', 1, 6, 1, 1, '2020-06-28 23:41:34'),
(2, 'first product', 'all special product 938', '465983_braided-bracelets-collection.jpg', 4, 123, 5, 0, 'America', 'Used', 1, 122, 3, 0, '2020-07-06 21:27:00'),
(3, 'bracelet two', 'This bracelet two', '432228_coordinates-bracelets-collections.jpg', 5, 233, 9, 3, 'Egypt', 'Like-New', 1, 123, 4, 1, '2020-07-06 21:28:15'),
(4, 'bracelet 8', 'all special bracelet', '145071_wide-black-studded-cuff-bracelet.jpg', 3, 122, 5, 5, 'China', 'Used', 1, 11, 2, 0, '2020-07-06 21:30:30'),
(5, 'bracelet 77', 'all special bracelet 77', '982577_brown-bracelet-boys.jpg', 4, 524, 6, 0, 'China', 'Used', 1, 29, 3, 0, '2020-07-06 21:31:36'),
(9, 'fdfggfdgdf', 'dfgdfgdfdfgf', '591250_logo.png', 3, 33, 7, 3, 'China', 'Like-New', 1, 4, 1, 0, '2020-07-07 21:16:59'),
(10, 'fdf', 'dfdfdfdf', '606070_egypt.png', 4, 33, 9, 2, 'Egypt', 'New', 1, 2, 0, 0, '2020-07-07 21:18:30'),
(11, 'dsdasd', 'fdsffdsfdsfddf', '912321_f_logo.png', 3, 222, 7, 0, 'China', 'Like-New', 1, 3, 1, 1, '2020-07-07 21:27:36'),
(12, 'fdffdf', '3eeeerrrrrrrr', '300931_f_logo.png', 7, 44, 7, 0, 'China', 'Like-New', 1, 9, 0, 0, '2020-07-07 21:29:51'),
(13, 'fefefe', 'effefefefe', '164431_f_logo.png', 4, 33, 7, 0, 'Egypt', 'Like-New', 1, 3, 0, 0, '2020-07-07 21:30:27'),
(14, 'sdsdsds', 'dsdsdsd', '182867_egypt.png', 3, 233, 8, 3, 'China', 'Used', 0, 4, 0, 0, '2020-07-07 21:35:12'),
(15, 'ffsdfs', 'fsdffdfsfsf', '965113_egypt.png', 4, 33, 7, 0, 'Egypt', 'Like-New', 0, 4, 0, 0, '2020-07-07 21:37:54'),
(16, 'wffwf', '23223dsdas', '623790_egypt.png', 4, 333, 5, 4, 'Egypt', 'Like-New', 1, 4, 1, 0, '2020-07-07 21:40:37'),
(17, 'hamekfdki', 'folwfovkmgeifgfgvbkl;fmgvbk;', '532898_brown-bracelet-boys.jpg', 127, 2732, 8, 0, 'Egypt', 'Like-New', 0, 3, 0, 0, '2020-07-08 16:03:51'),
(18, 'fgfgfd', 'fgfgfd', '567405_egypt.png', 5, 44, 4, 0, 'Japan', 'Used', 0, 1, 0, 0, '2020-07-08 16:06:27'),
(19, 'efewfew', 'fweewfwef', '767871_logo_d.png', 4, 33, 7, 0, 'Egypt', 'Like-New', 1, 2, 0, 0, '2020-07-08 16:10:13'),
(20, 'rggre', 'geerge', '158107_f_logo.png', 3, 44, 8, 0, 'China', 'Like-New', 1, 3, 0, 0, '2020-07-08 16:13:03'),
(26, 'ddddddddddd', 'ddddddddddddddddddddddd', '339266_egypt.png', 3, 33, 6, 0, 'Kwuit', 'Like-New', 0, 3, 0, 0, '2020-08-07 20:11:36'),
(27, 'ddddddd', 'dddddddddddddddddddd', '634171_custom-printed-bracelets-collections.jpg', 33, 333, 4, 0, 'Kwuit', 'New', 1, 3, 2, 0, '2020-08-07 20:12:17'),
(28, 'fffffffffffffff', 'ffffffffffffffffffffffffffffffff', '521708_custom-printed-bracelets-collections.jpg', 2, 33, 6, 0, 'Egypt', 'Old', 1, 2, 1, 0, '2020-08-07 20:13:04'),
(29, 'fffffffffffffffffffa', 'aaaaasadaaaaaaaaaaaaaaaaa', '110449_avatar2.png', 4, 444, 5, 0, 'Egypt', 'New', 1, 3, 0, 0, '2020-08-07 20:15:27'),
(30, 'ddddddddddww', 'dwwddddddddddddddaa', '905408_egypt.png', 2, 22, 7, 0, 'Egypt', 'Like-New', 1, 3, 0, 0, '2020-08-07 20:16:55'),
(31, 'ddddddw', 'ddddddddddddddw', '823313_egypt.png', 1, 22, 8, 0, 'Kwuit', 'New', 1, 2, 3, 0, '2020-08-07 20:23:17'),
(32, 'ddddddddddddddddqc', 'dddddddddddjjk', '358959_logo.jpg', 2, 222, 4, 0, 'China', 'New', 1, 1, 0, 0, '2020-08-07 20:25:42');

-- --------------------------------------------------------

--
-- Table structure for table `shape`
--

CREATE TABLE `shape` (
  `shap_id` int(11) NOT NULL,
  `shap_img` varchar(255) NOT NULL,
  `p_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `store_cart_item`
--

CREATE TABLE `store_cart_item` (
  `p_c_id` int(11) NOT NULL COMMENT 'product cart id',
  `p_id` int(11) NOT NULL COMMENT 'main product cart id',
  `p_name` varchar(255) NOT NULL COMMENT 'product_cart_name',
  `color` varchar(255) NOT NULL COMMENT 'color ',
  `p_img` varchar(255) NOT NULL COMMENT 'product cart img',
  `p_price` int(11) NOT NULL COMMENT 'product cart price',
  `p_quantity` int(11) NOT NULL DEFAULT '1' COMMENT 'product quntity',
  `discount` int(11) NOT NULL COMMENT 'price discount',
  `date_insert` datetime NOT NULL,
  `kind` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `p_desc` varchar(255) NOT NULL,
  `product_size` varchar(255) NOT NULL COMMENT 'product size',
  `text_engraving` varchar(255) NOT NULL DEFAULT 'not_found',
  `position_eng` varchar(255) NOT NULL DEFAULT 'Center'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `favorite_products`
--
ALTER TABLE `favorite_products`
  ADD PRIMARY KEY (`p_fav`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `user_id` (`userid`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`ord_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `productID` (`productID`),
  ADD KEY `ord_number` (`ord_number`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ord_id`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `ord_number` (`ord_number`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `shape`
--
ALTER TABLE `shape`
  ADD PRIMARY KEY (`shap_id`);

--
-- Indexes for table `store_cart_item`
--
ALTER TABLE `store_cart_item`
  ADD PRIMARY KEY (`p_c_id`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'admin id', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'category ID', AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'customer id', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `favorite_products`
--
ALTER TABLE `favorite_products`
  MODIFY `p_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `ord_detail_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'order details id', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'order id', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `shape`
--
ALTER TABLE `shape`
  MODIFY `shap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `store_cart_item`
--
ALTER TABLE `store_cart_item`
  MODIFY `p_c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'product cart id', AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorite_products`
--
ALTER TABLE `favorite_products`
  ADD CONSTRAINT `p_id` FOREIGN KEY (`p_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `ord_num` FOREIGN KEY (`ord_number`) REFERENCES `orders` (`ord_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_id` FOREIGN KEY (`productID`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `store_cart_item`
--
ALTER TABLE `store_cart_item`
  ADD CONSTRAINT `produc_id` FOREIGN KEY (`p_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
