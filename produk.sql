-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2021 at 02:29 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `algen`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `kode` int(11) NOT NULL,
  `item` varchar(50) NOT NULL,
  `item_price` float NOT NULL,
  `item_picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kode`, `item`, `item_price`, `item_picture`) VALUES
(1, 'Fantastic Wooden Shoes', 108554, 'https://via.placeholder.com/100x100.png/00aa11?text=business+sequi'),
(2, 'Aerodynamic Marble Shoes', 81096, 'https://via.placeholder.com/100x100.png/00bb66?text=business+quia'),
(3, 'Practical Leather Coat', 128472, 'https://via.placeholder.com/100x100.png/00cc22?text=business+velit'),
(4, 'Intelligent Wooden Watch', 31880, 'https://via.placeholder.com/100x100.png/007744?text=business+vel'),
(5, 'Durable Steel Bench', 91469, 'https://via.placeholder.com/100x100.png/0055aa?text=business+saepe'),
(6, 'Ergonomic Steel Computer', 37948, 'https://via.placeholder.com/100x100.png/006622?text=business+saepe'),
(7, 'Lightweight Steel Hat', 111206, 'https://via.placeholder.com/100x100.png/0033aa?text=business+fugiat'),
(8, 'Durable Rubber Clock', 104071, 'https://via.placeholder.com/100x100.png/00ff11?text=business+et'),
(9, 'Rustic Wooden Shirt', 63817, 'https://via.placeholder.com/100x100.png/0033ee?text=business+incidunt'),
(10, 'Enormous Concrete Coat', 86211, 'https://via.placeholder.com/100x100.png/0088dd?text=business+dolorem'),
(11, 'Enormous Linen Coat', 74913, 'https://via.placeholder.com/100x100.png/00ffbb?text=business+saepe'),
(12, 'Durable Rubber Knife', 84232, 'https://via.placeholder.com/100x100.png/003377?text=business+sed'),
(13, 'Lightweight Iron Coat', 115215, 'https://via.placeholder.com/100x100.png/00ff00?text=business+vel'),
(14, 'Aerodynamic Paper Plate', 132247, 'https://via.placeholder.com/100x100.png/0033aa?text=business+eius'),
(15, 'Fantastic Plastic Chair', 91390, 'https://via.placeholder.com/100x100.png/00ff00?text=business+voluptatem'),
(16, 'Durable Silk Bag', 84718, 'https://via.placeholder.com/100x100.png/00aa33?text=business+repellat'),
(17, 'Awesome Plastic Knife', 11082, 'https://via.placeholder.com/100x100.png/00dd77?text=business+et'),
(18, 'Awesome Linen Knife', 82896, 'https://via.placeholder.com/100x100.png/0000dd?text=business+perferendis'),
(19, 'Ergonomic Silk Knife', 17411, 'https://via.placeholder.com/100x100.png/00bbbb?text=business+consequuntur'),
(20, 'Ergonomic Copper Hat', 32290, 'https://via.placeholder.com/100x100.png/00eeee?text=business+dolor'),
(21, 'Synergistic Bronze Bag', 44233, 'https://via.placeholder.com/100x100.png/002299?text=business+et'),
(22, 'Practical Iron Lamp', 63719, 'https://via.placeholder.com/100x100.png/0055aa?text=business+deleniti'),
(23, 'Synergistic Paper Hat', 22373, 'https://via.placeholder.com/100x100.png/00ddff?text=business+ut'),
(24, 'Small Steel Knife', 111353, 'https://via.placeholder.com/100x100.png/0055aa?text=business+sunt'),
(25, 'Practical Concrete Gloves', 96834, 'https://via.placeholder.com/100x100.png/005522?text=business+nihil'),
(26, 'Mediocre Plastic Knife', 78360, 'https://via.placeholder.com/100x100.png/0033aa?text=business+neque'),
(27, 'Awesome Linen Plate', 131447, 'https://via.placeholder.com/100x100.png/00aa00?text=business+id'),
(28, 'Intelligent Aluminum Watch', 66269, 'https://via.placeholder.com/100x100.png/0000cc?text=business+aspernatur'),
(29, 'Intelligent Wooden Watch', 68143, 'https://via.placeholder.com/100x100.png/006655?text=business+at'),
(30, 'Ergonomic Granite Knife', 51448, 'https://via.placeholder.com/100x100.png/0000dd?text=business+iure'),
(31, 'Rustic Leather Chair', 69010, 'https://via.placeholder.com/100x100.png/000000?text=business+veritatis'),
(32, 'Gorgeous Iron Gloves', 79571, 'https://via.placeholder.com/100x100.png/0066bb?text=business+unde'),
(33, 'Ergonomic Concrete Knife', 53234, 'https://via.placeholder.com/100x100.png/00aa22?text=business+et'),
(34, 'Durable Wooden Gloves', 16579, 'https://via.placeholder.com/100x100.png/00ff44?text=business+quia'),
(35, 'Lightweight Rubber Chair', 37673, 'https://via.placeholder.com/100x100.png/001144?text=business+sint'),
(36, 'Ergonomic Linen Bottle', 121637, 'https://via.placeholder.com/100x100.png/00cccc?text=business+repellat'),
(37, 'Small Silk Pants', 123925, 'https://via.placeholder.com/100x100.png/00aa44?text=business+architecto'),
(38, 'Fantastic Rubber Wallet', 44680, 'https://via.placeholder.com/100x100.png/0099bb?text=business+debitis'),
(39, 'Sleek Aluminum Keyboard', 125918, 'https://via.placeholder.com/100x100.png/00dd33?text=business+consequatur'),
(40, 'Sleek Wooden Watch', 86053, 'https://via.placeholder.com/100x100.png/007700?text=business+impedit'),
(41, 'Practical Wooden Bench', 41523, 'https://via.placeholder.com/100x100.png/00dd11?text=business+occaecati'),
(42, 'Mediocre Rubber Clock', 120230, 'https://via.placeholder.com/100x100.png/001199?text=business+cupiditate'),
(43, 'Intelligent Leather Computer', 111604, 'https://via.placeholder.com/100x100.png/00ffdd?text=business+est'),
(44, 'Rustic Iron Hat', 85681, 'https://via.placeholder.com/100x100.png/003300?text=business+voluptatem'),
(45, 'Synergistic Plastic Plate', 98357, 'https://via.placeholder.com/100x100.png/00dd11?text=business+velit'),
(46, 'Lightweight Aluminum Knife', 108919, 'https://via.placeholder.com/100x100.png/00ddaa?text=business+est'),
(47, 'Lightweight Marble Computer', 42713, 'https://via.placeholder.com/100x100.png/0022ee?text=business+facilis'),
(48, 'Rustic Paper Knife', 65573, 'https://via.placeholder.com/100x100.png/00ee33?text=business+omnis'),
(49, 'Intelligent Aluminum Wallet', 100972, 'https://via.placeholder.com/100x100.png/0055ff?text=business+blanditiis'),
(50, 'Awesome Iron Coat', 107934, 'https://via.placeholder.com/100x100.png/000066?text=business+qui');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
