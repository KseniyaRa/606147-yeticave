-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 14 2019 г., 13:34
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
  `date` datetime NOT NULL COMMENT 'дата и время, когда этот лот был создан пользователем',
  `name` char(50) NOT NULL COMMENT 'название ',
  `discription` text NOT NULL COMMENT 'описание ',
  `image` varchar(255) NOT NULL COMMENT 'изображение — ссылка на файл изображения',
  `initial_price` decimal(10,0) NOT NULL COMMENT 'начальная цена',
  `completion_date` datetime NOT NULL COMMENT 'дата завершения',
  `step_rate` decimal(10,0) NOT NULL COMMENT 'шаг ставки',
  `author` int(11) NOT NULL COMMENT 'автор — пользователь, создавший лот',
  `winner` int(11) NOT NULL COMMENT 'победитель — пользователь, выигравший лот',
  `category_id` int(11) NOT NULL COMMENT 'категория — категория объявления'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `rate`
--

CREATE TABLE `rate` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL COMMENT 'дата — дата и время размещения ставки',
  `price` double NOT NULL COMMENT 'сумма — цена, по которой пользователь готов приобрести лот',
  `user_id` int(11) NOT NULL COMMENT 'пользователь',
  `lot_id` int(11) NOT NULL COMMENT 'лот'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL COMMENT 'дата регистрации — дата и время, когда этот пользователь завёл аккаунт',
  `email` char(128) NOT NULL COMMENT 'email',
  `name` char(50) NOT NULL COMMENT 'имя',
  `password` char(30) NOT NULL COMMENT 'пароль — хэшированный пароль пользователя',
  `avatar` varchar(255) NOT NULL COMMENT 'аватар — ссылка на загруженный аватар пользователя',
  `contacts` varchar(255) NOT NULL COMMENT 'контакты — контактная информация для связи с пользователем',
  `lot_id` int(11) NOT NULL COMMENT 'созданные лоты',
  `rate_id` int(11) NOT NULL COMMENT 'ставки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `lot`
--
ALTER TABLE `lot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rate`
--
ALTER TABLE `rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
