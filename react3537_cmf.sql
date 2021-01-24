-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 10 2020 г., 10:02
-- Версия сервера: 5.5.65-MariaDB-cll-lve
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `react3537_cmf`
--

-- --------------------------------------------------------

--
-- Структура таблицы `katalog`
--

CREATE TABLE IF NOT EXISTS `katalog` (
  `id` int(15) NOT NULL,
  `name_uz` text NOT NULL,
  `name_ru` text NOT NULL,
  `cat` varchar(10) NOT NULL,
  `activ` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `katalog`
--

INSERT INTO `katalog` (`id`, `name_uz`, `name_ru`, `cat`, `activ`) VALUES
(1, 'ðŸ•º Kostyumlar', 'ðŸ•º ÐšÐ¾ÑÑ‚ÑŽÐ¼Ñ‹', '0', 1),
(2, 'ðŸ’ƒ Liboslar', 'ðŸ’ƒ ÐŸÐ»Ð°Ñ‚ÑŒÑ', '0', 1),
(3, 'ðŸ‘œ Sumkalar', 'ðŸ‘œ Ð¡ÑƒÐ¼ÐºÐ¸', '0', 1),
(5, 'â›¸ Sport', 'â›¸ Ð¡Ð¿Ð¾Ñ€Ñ‚', '0', 1),
(8, 'ðŸ‘™ Suzish kiyimlari', 'ðŸ‘™ ÐšÑƒÐ¿Ð°Ð»ÑŒÐ½Ð¸ÐºÐ¸', '0', 1),
(9, 'S o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ S', '1', 1),
(10, 'M o''chamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ M', '1', 1),
(11, 'L o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ L', '1', 1),
(12, 'XL o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ XL', '1', 1),
(13, 'S o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ S', '2', 1),
(15, 'M o''chamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ M', '2', 1),
(16, 'L o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ L', '2', 1),
(17, 'XL o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ XL', '2', 1),
(18, 'Sumkalar', 'Ð¡ÑƒÐ¼ÐºÐ¸', '3', 1),
(19, 'Hamyonlar', 'ÐšÐ¾ÑˆÐµÐ»ÑŒÐºÐ¸', '3', 1),
(21, 'ðŸ€ Toplar', 'ðŸ€ Ð¢Ð¾Ð¿Ñ‹', '5', 1),
(22, 'ðŸ¤¸â€â™€ï¸ Losinalar', 'ðŸ¤¸â€â™€ï¸ Ð›Ð¾ÑÐ¸Ð½Ñ‹', '5', 1),
(23, 'ðŸ¥‹ Sport-kiyimlar', 'ðŸ¥‹ Ð¡Ð¿Ð¾Ñ€Ñ‚-ÐºÐ¾ÑÑ‚ÑŽÐ¼Ñ‹', '5', 1),
(24, 'S o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ S', '8', 1),
(25, 'M o''chamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ M', '8', 1),
(26, 'L o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ L', '8', 1),
(27, 'XL o''lchamlari', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ XL', '8', 1),
(34, 'S o''lchamlar', 'Ð Ð°Ð·Ð¼ÐµÑ€Ñ‹ S', '21', 1),
(39, 'Nomi uz', 'ÐÐ¾Ð¼Ð¸ Ñ€Ñƒ', '34', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tovar`
--

CREATE TABLE IF NOT EXISTS `tovar` (
  `id` int(11) NOT NULL,
  `name_uz` text CHARACTER SET utf8mb4 NOT NULL,
  `name_ru` text CHARACTER SET utf8mb4 NOT NULL,
  `narx` int(50) NOT NULL,
  `rasm` text CHARACTER SET utf8mb4 NOT NULL,
  `cat` int(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tovar`
--

INSERT INTO `tovar` (`id`, `name_uz`, `name_ru`, `narx`, `rasm`, `cat`) VALUES
(2, 'Tulkicha', 'Ð¢ÑƒÐ»ÐºÐ¸Ñ‡Ð°', 15000, 'AgACAgIAAxkBAAILGl8v7sGVxBFaTCqV_0SkvFJIzerHAAJxrzEbMm2ASWclWgEiFq1yZB1Lli4AAwEAAwIAA20AA6lzAAIaBA', 9),
(9, 'Morgan', 'ÐœÐ¾Ñ€Ð³Ð°Ð½', 2500, 'AgACAgIAAxkBAAIQd18wQzRNteeYfO3heiTcHLUkMfhWAAIEsDEbMm2ASaQ5-tFLI0PbG77Aki4AAwEAAwIAA20AAxCTBQABGgQ', 34),
(10, 'Jshssbb', 'babsvevd', 7000, 'AgACAgIAAxkDAAISTl8wTHXkbNXzjRCvAdI1WU1Sf_2GAAIEsDEbMm2ASaQ5-tFLI0PbG77Aki4AAwEAAwIAA20AAxCTBQABGgQ', 34),
(11, 'uzbek', 'rus', 14000, 'AgACAgEAAxkBAAIS918wWcdXwdvoaesAAZ05m0prnmCS_AACyqgxG_8tiEUrXmpFQWbTME2qEjAABAEAAwIAA20AAyX6AQABGgQ', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `lng` varchar(3) NOT NULL,
  `map` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `chat_id`, `lng`, `map`) VALUES
(8, 266873587, 'uz', '3-9'),
(13, 587144350, 'ru', '1-4'),
(14, 1115067337, 'ru', '1-2'),
(15, 132683035, 'uz', '0');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `katalog`
--
ALTER TABLE `katalog`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tovar`
--
ALTER TABLE `tovar`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `katalog`
--
ALTER TABLE `katalog`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT для таблицы `tovar`
--
ALTER TABLE `tovar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
