/*
 Navicat Premium Backup

 Source Server         : laravel
 Source Server Type    : MySQL
 Source Server Version : 50614
 Source Host           : 127.0.0.1
 Source Database       : laravel

 Target Server Type    : MySQL
 Target Server Version : 50614
 File Encoding         : utf-8

 Date: 06/05/2014 22:07:26 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `cities`
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL COMMENT 'Страна',
  `name` varchar(128) DEFAULT NULL COMMENT 'Название',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `cities_country_fk` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cities`
-- ----------------------------
BEGIN;
INSERT INTO `cities` VALUES ('1', '1', 'Москва'), ('2', '1', 'Санкт-Петербург'), ('3', '1', 'Омск'), ('4', '1', 'Самара'), ('5', '1', 'Казань'), ('6', '2', 'Айзпуте'), ('7', '2', 'Айнажи'), ('8', '2', 'Акнисте'), ('9', '2', 'Вентспилс'), ('10', '3', 'Акко'), ('11', '3', 'Арад'), ('12', '3', 'Ариэль'), ('13', '3', 'Йехуд-Моноссон'), ('14', '3', 'Ришон-ле-Цион');
COMMIT;

-- ----------------------------
--  Table structure for `countries`
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL COMMENT 'Название',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `countries`
-- ----------------------------
BEGIN;
INSERT INTO `countries` VALUES ('1', 'Россия'), ('2', 'Латвия'), ('3', 'Израиль');
COMMIT;

-- ----------------------------
--  Table structure for `setup`
-- ----------------------------
DROP TABLE IF EXISTS `setup`;
CREATE TABLE `setup` (
  `name` varchar(64) DEFAULT NULL,
  `value` text,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `setup`
-- ----------------------------
BEGIN;
INSERT INTO `setup` VALUES ('email', '2066520@gmail.com');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL COMMENT 'Электронная почта',
  `password` varchar(64) DEFAULT NULL COMMENT 'Пароль',
  `active` tinyint(4) DEFAULT NULL COMMENT 'Доступ',
  `CREATE_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `remember_token` varchar(256) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'admin@email.ru', '$2y$10$K2QBP24lMgk/qJ.RcwMUv.JOc.7hM5YOp/zljh3MMzKLwfQdlkMHW', '1', '2014-06-04 09:39:46', 'ppPMoEcMz0Lm8plnn1ndzqAoJMWQB89xoo8Cw2nxPP5HOUrfMKfhkfRju91r', '2014-06-04 16:22:01');
COMMIT;

-- ----------------------------
--  Table structure for `worksheets`
-- ----------------------------
DROP TABLE IF EXISTS `worksheets`;
CREATE TABLE `worksheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(128) DEFAULT NULL COMMENT 'Фамилия',
  `first_name` varchar(128) DEFAULT NULL COMMENT 'Имя',
  `middle_name` varchar(128) DEFAULT NULL COMMENT 'Отчество',
  `birthday` datetime DEFAULT NULL COMMENT 'Дата рождения',
  `photo_file_name` varchar(38) DEFAULT NULL COMMENT 'Фото (jpg, png)',
  `email` varchar(128) DEFAULT NULL COMMENT 'Электронная почта',
  `city` int(11) DEFAULT NULL COMMENT 'Город',
  `checked` tinyint(1) DEFAULT '0' COMMENT 'Проверена',
  `CREATE_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания записи',
  PRIMARY KEY (`id`),
  KEY `city` (`city`),
  CONSTRAINT `worksheets_city_fk` FOREIGN KEY (`city`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `worksheets`
-- ----------------------------
BEGIN;
INSERT INTO `worksheets` VALUES ('2', 'Фамилия', 'Имя', 'Отчество', '2012-12-20 14:00:00', null, '2066520@gmail.com', '8', '1', '2014-06-04 00:39:01'), ('3', 'adasdsa', 'Илья', 'gg', '2012-12-20 14:00:00', null, 'a@b.ru', '1', '0', '2014-06-04 00:44:56'), ('4', 'Васильев', 'Илья', 'Мартынович', '2012-12-20 14:00:00', null, 'a@b.ru', '13', '0', '2014-06-04 20:22:29'), ('6', 'Васильев', 'ddd', 'Мартынович', '2012-12-20 14:00:00', null, 'a@b.ru', '10', '1', '2014-06-05 21:43:25'), ('7', 'Васильев', 'ddd', 'Мартынович', '2012-12-20 14:00:00', null, 'a@b.ru', '10', '0', '2014-06-05 21:43:58'), ('8', 'Васильев', 'Илья', 'Мартынович', '2012-12-20 14:00:00', '8.jpg', 'a@b.ru', '7', '0', '2014-06-05 21:44:59');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
