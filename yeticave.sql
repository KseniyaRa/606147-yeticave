-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 16 2019 г., 06:18
-- Версия сервера: 5.7.23
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yeticave`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` char(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(3, 'Ботинки'),
(1, 'Доски и лыжи'),
(5, 'Инструменты'),
(2, 'Крепления'),
(4, 'Одежда'),
(6, 'Разное');

-- --------------------------------------------------------

--
-- Структура таблицы `lot`
--

CREATE TABLE `lot` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата и время, когда этот лот был создан пользователем',
  `name` char(50) DEFAULT NULL COMMENT 'название ',
  `discription` text COMMENT 'описание ',
  `image` varchar(255) DEFAULT NULL COMMENT 'изображение — ссылка на файл изображения',
  `initial_price` decimal(10,0) DEFAULT NULL COMMENT 'начальная цена',
  `completion_date` datetime DEFAULT NULL COMMENT 'дата завершения',
  `step_rate` decimal(10,0) DEFAULT NULL COMMENT 'шаг ставки',
  `author` int(11) DEFAULT NULL COMMENT 'автор — пользователь, создавший лот',
  `winner` int(11) DEFAULT NULL COMMENT 'победитель — пользователь, выигравший лот',
  `category_id` int(11) DEFAULT NULL COMMENT 'категория — категория объявления'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lot`
--

INSERT INTO `lot` (`id`, `date`, `name`, `discription`, `image`, `initial_price`, `completion_date`, `step_rate`, `author`, `winner`, `category_id`) VALUES
(13, '2019-02-14 14:13:01', '2014 Rossignol District Snowboard', NULL, 'img/lot-1.jpg', '10999', NULL, NULL, 1, NULL, 1),
(14, '2019-02-14 14:16:06', 'DC Ply Mens 2016/2017 Snowboard', NULL, 'img/lot-2.jpg', '159999', NULL, NULL, 2, NULL, 1),
(15, '2019-02-14 14:21:02', 'Крепления Union Contact Pro 2015 года размер L/XL', NULL, 'img/lot-3.jpg', '8000', NULL, NULL, NULL, NULL, 2),
(16, '2019-02-14 14:21:02', 'Ботинки для сноуборда DC Mutiny Charocal', NULL, 'img/lot-4.jpg', '10999', NULL, NULL, NULL, NULL, 3),
(17, '2019-02-14 14:21:02', 'Куртка для сноуборда DC Mutiny Charocal', NULL, 'img/lot-5.jpg', '7500', NULL, NULL, NULL, NULL, 4),
(18, '2019-02-14 14:21:02', 'Маска Oakley Canopy', NULL, 'img/lot-6.jpg', '5400', NULL, NULL, NULL, NULL, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `rate`
--

CREATE TABLE `rate` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата — дата и время размещения ставки',
  `price` double DEFAULT NULL COMMENT 'сумма — цена, по которой пользователь готов приобрести лот',
  `user_id` int(11) DEFAULT NULL COMMENT 'пользователь',
  `lot_id` int(11) DEFAULT NULL COMMENT 'лот'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rate`
--

INSERT INTO `rate` (`id`, `date`, `price`, `user_id`, `lot_id`) VALUES
(2, '2019-02-14 15:01:22', 12345, 1, 13),
(3, '2019-02-14 15:01:22', 16549, 2, 14);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'дата регистрации — дата и время, когда этот пользователь завёл аккаунт',
  `email` char(128) DEFAULT NULL COMMENT 'email',
  `name` char(50) DEFAULT NULL COMMENT 'имя',
  `password` char(30) DEFAULT NULL COMMENT 'пароль — хэшированный пароль пользователя',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'аватар — ссылка на загруженный аватар пользователя',
  `contacts` varchar(255) DEFAULT NULL COMMENT 'контакты — контактная информация для связи с пользователем',
  `lot_id` int(11) DEFAULT NULL COMMENT 'созданные лоты',
  `rate_id` int(11) DEFAULT NULL COMMENT 'ставки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `date`, `email`, `name`, `password`, `avatar`, `contacts`, `lot_id`, `rate_id`) VALUES
(1, '2019-02-14 14:54:59', 'ivanov@gmail.com', 'Иванов Иван Иванович', 'asd', NULL, NULL, 13, 2),
(2, '2019-02-14 14:54:59', 'petrov@gmail.com', 'Петров Петр Петрович', 'asd', NULL, NULL, 14, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `lot`
--
ALTER TABLE `lot`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `image` (`image`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author` (`author`),
  ADD KEY `winner` (`winner`);

--
-- Индексы таблицы `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lot_id` (`lot_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `lot_id` (`lot_id`),
  ADD KEY `rate_id` (`rate_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `lot`
--
ALTER TABLE `lot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `rate`
--
ALTER TABLE `rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `lot`
--
ALTER TABLE `lot`
  ADD CONSTRAINT `lot_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `lot_ibfk_2` FOREIGN KEY (`author`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `lot_ibfk_3` FOREIGN KEY (`winner`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`lot_id`) REFERENCES `lot` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`lot_id`) REFERENCES `lot` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`rate_id`) REFERENCES `rate` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
