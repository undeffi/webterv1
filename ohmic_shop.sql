-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Ápr 16. 12:56
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `ohmic_shop`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_title` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `order_shipping`
--

CREATE TABLE `order_shipping` (
  `ID` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `line1` varchar(255) DEFAULT NULL,
  `line2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` varchar(32) NOT NULL,
  `type` int(11) NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `supply` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `type`, `imagePath`, `supply`) VALUES
(4, 'Szénfilm ellenállás 0.01Ω 100 db', '1400', 0, '../img/resistor.jpg', 6),
(6, 'Szénfilm ellenállás 0.1Ω 100 db', '1400', 0, '../img/resistor.jpg', 8),
(7, 'Szénfilm ellenállás 1Ω 100 db', '1400', 0, '../img/resistor.jpg', 10),
(8, 'Szénfilm ellenállás 10Ω 100 db', '1450', 0, '../img/resistor.jpg', 40),
(9, 'Szénfilm ellenállás 100Ω 100 db', '1500', 0, '../img/resistor.jpg', 20),
(10, 'Szénfilm ellenállás 1kΩ 100 db', '1550', 0, '../img/resistor.jpg', 20),
(11, 'Kerámia kondenzátor 3300µF 10V 100 db', '3000', 2, '../img/capacitor.jpg', 45),
(12, 'Kerámia kondenzátor 1000µF 16V 100 db', '3000', 2, '../img/capacitor.jpg', 34),
(13, 'Kerámia kondenzátor 330µF 25V 100 db', '4000', 2, '../img/capacitor.jpg', 12),
(14, 'Kerámia kondenzátor 1µF 100V 100 db', '4500', 2, '../img/capacitor.jpg', 23),
(15, 'DC Relé 1A 5V', '3000', 3, '../img/relay.jpg', 10),
(16, 'DC Relé 1A 12V', '3000', 3, '../img/relay.jpg', 21),
(17, 'AC Relé 10A 240V', '5000', 3, '../img/relay.jpg', 2),
(18, 'Biztosíték 1/4A 10 db', '1000', 4, '../img/fuse.jpg', 40),
(19, 'Biztosíték 1/2A 10 db', '1000', 4, '../img/fuse.jpg', 62),
(20, 'Biztosíték 1A 10 db', '1100', 4, '../img/fuse.jpg', 23),
(21, 'Biztosíték 2A 10 db', '1200', 4, '../img/fuse.jpg', 37),
(22, 'Biztosíték 5A 10 db', '1300', 4, '../img/fuse.jpg', 62),
(23, 'Biztosíték 10A 10 db', '1500', 4, '../img/fuse.jpg', 38),
(24, 'Hoover Max Extract® Pressure Pro™, Model 60 légszűrő', '50000000', 5, '../img/hoover-filter.jpg', 8),
(25, 'OOOOAAAAAA', '12000', 5, '../img/OOOAAAAAA.jpg', 100);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `producttypes`
--

CREATE TABLE `producttypes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `producttypes`
--

INSERT INTO `producttypes` (`id`, `name`) VALUES
(0, 'Ellenállás'),
(2, 'Kondenzátor'),
(3, 'Relé'),
(4, 'Biztosíték'),
(5, 'Más');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `product_id`, `rating`) VALUES
(10, 7, 4, 5),
(11, 7, 6, 2),
(12, 11, 4, 5),
(13, 11, 6, 4),
(14, 12, 4, 1),
(15, 12, 6, 5);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `priviligeLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `passwd`, `priviligeLevel`) VALUES
(7, 'admin', 'admin', 'admin@admin.com', '$2y$10$v/CnxfJV.bFEhO2.4FWLcu61ZLGUQ1GlDiwl.wr16wre2980n7K5m', 2),
(11, 'Users', 'Users', 'user@user.com', '$2y$10$ZK6vaaIfucVbdahH5.gTxu8rqIOnaUXTwb16v1EFJYiQtCRREpHfe', 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- A tábla indexei `order_shipping`
--
ALTER TABLE `order_shipping`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `order_id` (`order_id`);

--
-- A tábla indexei `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- A tábla indexei `producttypes`
--
ALTER TABLE `producttypes`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT a táblához `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT a táblához `order_shipping`
--
ALTER TABLE `order_shipping`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT a táblához `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT a táblához `producttypes`
--
ALTER TABLE `producttypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Megkötések a táblához `order_shipping`
--
ALTER TABLE `order_shipping`
  ADD CONSTRAINT `order_shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Megkötések a táblához `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`type`) REFERENCES `producttypes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
