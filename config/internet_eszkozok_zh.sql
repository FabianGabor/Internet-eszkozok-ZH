-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Gép: localhost:3306
-- Létrehozás ideje: 2021. Máj 18. 17:59
-- Kiszolgáló verziója: 8.0.25-0ubuntu0.20.04.1
-- PHP verzió: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `internet_eszkozok_zh`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int UNSIGNED NOT NULL,
  `vezeteknev` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `keresztnev` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `jelszo` varchar(128) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `vezeteknev`, `keresztnev`, `email`, `jelszo`) VALUES
(1, 'Fábián', 'Gábor', 'info@fabiangabor.com', '57ed8c0220d7bc4d34231825cc0d904d4298c1034094a4bcfb297e97a5ac4bae85e323854a74b20383aacffbc630ff54f181d42ee5f35c44179b4efb0f86b531'),
(2, 'Teszt', 'Elek', 'test@test', 'ca11330c41c964e5f3a4ee5f29c3cf6551288fff1dbfd41570f7e35352a987459b6376b37180f77fb3afedb7d57dd129981c3c2acb647202d2153c417a4b4170');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fogasok`
--

CREATE TABLE `fogasok` (
  `id` int UNSIGNED NOT NULL,
  `userid` int UNSIGNED NOT NULL,
  `vizterulet` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `halfajta` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `halsuly` float UNSIGNED NOT NULL,
  `fogasdatum` date NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `feltoltesdatum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `fogasok`
--

INSERT INTO `fogasok` (`id`, `userid`, `vizterulet`, `halfajta`, `halsuly`, `fogasdatum`, `img`, `feltoltesdatum`) VALUES
(1, 1, '1', '1', 1, '2021-05-02', '1uNh3B3ppl4.jpg', '2021-05-18 15:21:14');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `fogasok`
--
ALTER TABLE `fogasok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `fogasok`
--
ALTER TABLE `fogasok`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
