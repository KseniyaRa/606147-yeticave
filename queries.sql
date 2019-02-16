INSERT INTO category (name) VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');

INSERT INTO `lot`(`name`,`category_id`,`initial_price`,`image`) VALUES ('2014 Rossignol District Snowboard	',1,10999,'img/lot-1.jpg');
INSERT INTO `lot`(`name`,`category_id`,`initial_price`,`image`) VALUES ('DC Ply Mens 2016/2017 Snowboard',1,159999,'img/lot-2.jpg');
INSERT INTO `lot`(`name`,`category_id`,`initial_price`,`image`) VALUES ('Крепления Union Contact Pro 2015 года размер L/XL',2,8000,'img/lot-3.jpg');
INSERT INTO `lot`(`name`,`category_id`,`initial_price`,`image`) VALUES ('Ботинки для сноуборда DC Mutiny Charocal',3,10999,'img/lot-4.jpg');
INSERT INTO `lot`(`name`,`category_id`,`initial_price`,`image`) VALUES ('Куртка для сноуборда DC Mutiny Charocal',4,7500,'img/lot-5.jpg');
INSERT INTO `lot`(`name`,`category_id`,`initial_price`,`image`) VALUES ('Маска Oakley Canopy',6,5400,'img/lot-6.jpg');

INSERT INTO `user`(`email`, `name`, `password`) VALUES ('ivanov@gmail.com','Иванов Иван Иванович','asd');
INSERT INTO `user`(`email`, `name`, `password`) VALUES ('petrov@gmail.com','Петров Петр Петрович','asd');

INSERT INTO `rate`(`price`, `user_id`, `lot_id`) VALUES (12345, 1, 13);
INSERT INTO `rate`(`price`, `user_id`, `lot_id`) VALUES (16549, 2, 14);


/*получить все категории*/
SELECT * FROM `category`;

/*получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;(т.к. лоты созданы 14.02.19 выборка по свежести Лотов сделана за переиод 1го дня*/
SELECT lot.name, initial_price, image, /*цена*/ c.name 
FROM lot
JOIN category c
ON lot.category_id = c.id
WHERE lot.date BETWEEN '2019-02-14' AND '2019-02-15' 
ORDER BY lot.date DESC;

/*показать лот по его id. Получите также название категории, к которой принадлежит лот*/
SELECT lot.name, lot.date, discription, image, initial_price, completion_date, author, winner, c.name 
FROM lot
JOIN category c
ON lot.category_id = c.id
WHERE lot.id = 13;

/*обновить название лота по его идентификатору*/
UPDATE `lot` SET `name`='new' WHERE `id`=13;

/*получить список самых свежих ставок для лота по его идентификатору*/
SELECT price FROM rate WHERE lot_id = 13 ORDER BY rate.date DESC;