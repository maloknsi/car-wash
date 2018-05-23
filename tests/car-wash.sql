/*
Navicat MySQL Data Transfer

Source Server         : [localhost]-root
Source Server Version : 50638
Source Host           : 127.0.0.1:3306
Source Database       : car-wash

Target Server Type    : MYSQL
Target Server Version : 50638
File Encoding         : 65001

Date: 2018-05-23 17:49:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for box
-- ----------------------------
DROP TABLE IF EXISTS `box`;
CREATE TABLE `box` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `title` varchar(255) NOT NULL COMMENT 'название',
  `description` text COMMENT 'описание',
  `time_start` time NOT NULL COMMENT 'время начала работы',
  `time_end` time NOT NULL COMMENT 'время окончания работы',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Боксы мойки';

-- ----------------------------
-- Records of box
-- ----------------------------
INSERT INTO `box` VALUES ('1', 'Бокс №1', '', '08:00:00', '18:00:00');
INSERT INTO `box` VALUES ('2', 'Бокс №2', null, '08:00:00', '18:00:00');
INSERT INTO `box` VALUES ('3', 'Бокс №3', null, '06:00:00', '22:00:00');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `alias` varchar(50) NOT NULL COMMENT 'уникальный текст для URL',
  `title` varchar(255) DEFAULT NULL COMMENT 'название',
  `content` text COMMENT 'текст новости',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата создания',
  PRIMARY KEY (`id`),
  KEY `pk-news-alias` (`alias`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Новости';

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', 'u-nas-v-gostyakh-novyy-kanal1', 'У нас в гостях «Новый Канал»1', '<p>У нас побывала съемочная группа программы Подъем, которая выходит на &laquo;Новом канале&raquo;. Ведущий телепрограммы Скичко Александр рассказал где и как нужно мыть авто! Смотрите сами!</p>\r\n', '2018-05-20 20:30:20');
INSERT INTO `news` VALUES ('3', 'aromatizatsiyadezodoratsiya-salona-2-2', 'Ароматизация/дезодорация салона-2', '<p>Новая услуга &ndash; ароматизация салона автомобилей при помощи сухого тумана. В наличии 5 видов ароматов: цитрус, вишня, трава Кентукки, нейтрализатор запаха и специальный противотабачный &ndash; для устранения запаха прокуренного салона. Полная нейтрализация неприятных запахов, возникших в результате затопления авто или пожара. Достоинство услуги заключается в том, что сухой туман в отличии от других способов обеззараживания, не заглушает и не вуалирует неприятные запахи, а полностью их убирает (на 99 %).</p>\r\n', '2018-05-20 20:30:20');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `service_id` int(11) NOT NULL COMMENT 'внешний ключ на таблицу услуг',
  `user_id` int(11) DEFAULT NULL COMMENT 'внешний ключ на таблицу пользователей',
  `box_id` int(11) NOT NULL COMMENT 'внешний ключ на таблицу боксов мойки',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время создания заказа',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'время обновления заказа',
  `date_start` date DEFAULT NULL COMMENT 'дата заказа',
  `time_start` time DEFAULT NULL COMMENT 'время начала выполнения заказа',
  `time_end` time DEFAULT NULL COMMENT 'время окончания выполнения заказа',
  `money_cost` decimal(5,2) DEFAULT NULL COMMENT 'стоимость заказа',
  `status` smallint(1) NOT NULL DEFAULT '0' COMMENT 'статус выполнения заказа',
  PRIMARY KEY (`id`),
  KEY `pk-order-service_id` (`service_id`),
  KEY `pk-order-box_id` (`box_id`),
  KEY `pk-order-user_id` (`user_id`),
  CONSTRAINT `fk-order-box_id` FOREIGN KEY (`box_id`) REFERENCES `box` (`id`),
  CONSTRAINT `fk-order-service_id` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  CONSTRAINT `fk-order-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='таблица заказов клиентов';

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('1', '1', '1', '1', '2018-05-23 16:13:20', '2018-05-23 17:33:07', '2018-05-23', '10:30:00', '11:00:00', '120.00', '1');
INSERT INTO `order` VALUES ('3', '2', '1', '1', '2018-05-23 17:42:07', null, '2018-05-23', '11:30:00', '12:00:00', '100.00', '1');
INSERT INTO `order` VALUES ('4', '3', '1', '2', '2018-05-23 17:42:17', '2018-05-23 17:42:53', '2018-05-23', '08:20:27', '12:40:41', '300.00', '1');

-- ----------------------------
-- Table structure for page
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `alias` varchar(10) NOT NULL COMMENT 'уникальный текст для URL',
  `title` varchar(100) DEFAULT NULL COMMENT 'название',
  `content` text COMMENT 'текст новости',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pk-page-alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='страницы сайта';

-- ----------------------------
-- Records of page
-- ----------------------------
INSERT INTO `page` VALUES ('1', 'about', 'О нас', '<h2>Автомойка &quot;<strong>Nexus</strong>&quot; была открыта &ndash; в 2005 году.</h2>\r\n\r\n<p><u>И за время работы успела обзавестись широким кругом постоянных клиентов. </u></p>\r\n\r\n<p>Владельцы автомобилей, которые впервые воспользовались нашими услугами, возвращаются к нам снова.</p>\r\n\r\n<p>Такое доверие со стороны наших клиентов объясняется тем, что услуги, предоставляемые нами, выполняются на самом высоком уровне. Квалифицированые работники отлично знают своё дело, качественно выполняют ручную мойку автомобиля, промывку двигателя, бесконтактную мойку и многое другое. Спектр предоставляемых нами услуг широк, по этому, обратившись к нам, Вы сможете провести все необходимые процедуры для ухода за автомобилем. Ко всему прочему, привлекает клиентов доступными ценами на услуги. Свою работы мы выполняем с удовольствием и, как следствие, ежедневно видим владельцев автомобилей довольных нашим сервисом. А отличное настроение клиентов &ndash; это и есть стимул, чтобы и далее предоставлять только лучшее обслуживание! &quot;Nexus&quot; выделяется среди других авто-моек удобным месторасположением и Вы можете попасть на мойку не прокладывая дополнительных маршрутов. &quot;Nexus&quot; &ndash; это удобно, быстро и качественно.</p>\r\n');
INSERT INTO `page` VALUES ('2', 'contacts', 'Контактная информация', 'Мы находимся по адресу:\r\n\r\nг.Киев, ул. Пшеничная, 9.\r\nЗаезд на территорию \r\nсервисный центр АВТЕК\r\n\r\nТелефоны:\r\n\r\n+38 (098) 863 90 25 \r\nотд. логистики /администрация\r\n\r\n+38 (050) 682 55 75 \r\nадминистрация\r\n\r\n+38 (097) 108 33 77 \r\nГОРЯЧАЯ ЛИНИЯ');

-- ----------------------------
-- Table structure for review
-- ----------------------------
DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинремент',
  `user_id` int(11) DEFAULT NULL COMMENT 'внешний ключ на таблицу пользователей',
  `user_name` varchar(50) DEFAULT NULL COMMENT 'имя клиента',
  `user_email` varchar(50) DEFAULT NULL COMMENT 'email клиента',
  `user_phone` int(11) DEFAULT NULL COMMENT 'телефон клиента',
  `message` text COMMENT 'текст отзыва',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата создания отыва',
  `status` enum('canceled','confirmed','moderated') NOT NULL DEFAULT 'moderated' COMMENT 'статус отображения отзыва',
  PRIMARY KEY (`id`),
  KEY `fk-review-user_id` (`user_id`),
  CONSTRAINT `fk-review-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='отзывов клиентов';

-- ----------------------------
-- Records of review
-- ----------------------------
INSERT INTO `review` VALUES ('1', null, 'Сергей', 'nsi@ukr.net', '380667274', 'отличная мойка, быстро и качествнно помыли мою машинку', '2018-05-20 20:54:16', 'confirmed');
INSERT INTO `review` VALUES ('3', null, 'Максим', 'nsi@ukr.net', null, 'очень доволен услугами, плюсую', '2018-05-22 00:43:52', 'confirmed');
INSERT INTO `review` VALUES ('5', null, '222222', '', null, '11111111', '2018-05-22 20:04:05', 'moderated');

-- ----------------------------
-- Table structure for service
-- ----------------------------
DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `title` varchar(50) NOT NULL COMMENT 'название',
  `description` text COMMENT 'описание',
  `time_processing` time NOT NULL COMMENT 'время выполнения услуги',
  `money_cost` decimal(5,2) NOT NULL COMMENT 'стоимость услуги',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='таблица предоставляемых услуг автомойки';

-- ----------------------------
-- Records of service
-- ----------------------------
INSERT INTO `service` VALUES ('1', 'Комплекс «Стандарт»', 'мойка авто, воск, сушка, пылесос + влажная уборка салона', '01:00:00', '180.00');
INSERT INTO `service` VALUES ('2', 'Комплекс «Чистый»', 'мойка авто, жидкий воск, сушка, пылесос, влажная уборка салона, обезжир. стекол внутри салона', '01:30:00', '190.00');
INSERT INTO `service` VALUES ('3', 'Комплекс «Люкс»', 'мойка авто, воск, сушка, пылесос, влажная уборка салона, обезжир. стекол внутри снаружи, обработка пластиковых деталей салона, чернение резины', '02:00:00', '230.00');
INSERT INTO `service` VALUES ('4', 'Комплекс «V.I.P»', 'мойка авто б/к +ручная, полимер, пылесос, влажная уборка салона, обезж. стекол, чистка колёсных дисков, кондиционер кожи салона, полироль пластика салона, чернение резины', '03:00:00', '400.00');
INSERT INTO `service` VALUES ('5', 'Мойка бесконтактная', 'мойка, воск, сушка, коврики', '00:40:00', '100.00');
INSERT INTO `service` VALUES ('6', 'Мойка двигателя', null, '00:30:00', '100.00');
INSERT INTO `service` VALUES ('7', 'Экспресс сбивка водой', 'сбивка кузова автомобиля водой без автохимии без сушки', '00:20:00', '30.00');
INSERT INTO `service` VALUES ('8', 'Экспресс сбивка с химией', 'сбивка кузова авто водой с применением автохимии без сушки', '00:40:00', '60.00');
INSERT INTO `service` VALUES ('9', 'Пылесос салона и влажная уборка', null, '00:30:00', '50.00');
INSERT INTO `service` VALUES ('10', 'Пылесос багажника', null, '00:15:00', '20.00');
INSERT INTO `service` VALUES ('11', 'Пылесос салона', null, '00:30:00', '40.00');
INSERT INTO `service` VALUES ('12', 'Уборка салона', 'натирка, обработка пластика внутри салона, влажная уборка пластиковых элементов', '00:40:00', '50.00');
INSERT INTO `service` VALUES ('13', 'Твёрдый воск кузова авто (снаружи)', null, '01:00:00', '300.00');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время создания',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'время обновления',
  `username` varchar(150) DEFAULT NULL COMMENT 'логин пользователя ',
  `last_name` varchar(50) DEFAULT NULL COMMENT 'фамилия пользователя',
  `first_name` varchar(50) DEFAULT NULL COMMENT 'имя пользователя',
  `car_number` varchar(10) DEFAULT NULL COMMENT 'номер автомобиля клиента',
  `car_model` varchar(50) DEFAULT NULL COMMENT 'модель автомобиля клиента',
  `phone` bigint(11) DEFAULT NULL COMMENT 'телефон пользователя',
  `auth_key` varchar(32) DEFAULT NULL COMMENT 'ключ авторизации',
  `email_confirm_token` varchar(255) DEFAULT NULL COMMENT 'токен подтверждения email',
  `password_hash` varchar(255) DEFAULT NULL COMMENT 'хеш-код пароля',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT 'хеш-код сброса пароля',
  `email` varchar(255) DEFAULT NULL COMMENT 'email пользователя',
  `role` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'роль пользователя',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'статус активации пользователя',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='таблица пользователей (клиенты, операторы, администраторы)';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '2018-05-20 14:32:56', '2018-05-22 00:39:28', 'admin', 'Сергей', 'Назаров', 'ВМ2378АМ', 'Renault Magan 2', '380667274171', 'Q4Xk7D2OKMACjCsg8fOaHa6eBugqttcX', '', '$2y$13$JgmoemNGfn90wWowN2fFJeIXUv6hnQyflLbHQ5yCSW4Ruyb0xxXiK', '', 'nsi@ukr.net', '4', '1');
INSERT INTO `user` VALUES ('3', '2018-05-21 21:57:37', '2018-05-22 00:39:24', '(380555555555)', '', '', '', '', '380555555555', 'k7pceAoOm46w6siwUJZVAnc7H1IbNfSb', null, '$2y$13$aKJ6ERh2WHEWtf.yP/viueVnzNgJQHGVkpn2SylyruiZ5NuH2raT.', null, null, '1', '1');
INSERT INTO `user` VALUES ('11', '2018-05-22 22:52:40', '2018-05-22 22:54:29', '11111', '', '11111', '', '', null, 'ktd7oZeg9yvq7JbeciLxKGiKekwWwp_P', null, '$2y$13$Mf8PKUhjnc9BF8Q9l1WDj./n690d5jMCCOTlnHSqrjWjwu5cGjHyG', null, null, '4', '1');
INSERT INTO `user` VALUES ('12', '2018-05-23 16:26:31', null, '[380667574172]', null, null, null, null, '380667574172', null, null, null, null, null, '1', '1');

-- ----------------------------
-- Table structure for user_blocking
-- ----------------------------
DROP TABLE IF EXISTS `user_blocking`;
CREATE TABLE `user_blocking` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `user_id` int(11) DEFAULT NULL COMMENT 'внешний ключ на таблицу пользователей',
  `ip` varchar(100) DEFAULT NULL COMMENT 'IP адресс клиента',
  `phone` bigint(11) DEFAULT NULL COMMENT 'телефон клиента',
  `text` text COMMENT 'текст - причина блокировки',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время создания блокировки',
  `date_started` timestamp NULL DEFAULT NULL COMMENT 'время начала блокировки',
  `date_ended` timestamp NULL DEFAULT NULL COMMENT 'время окончания блокировки',
  PRIMARY KEY (`id`),
  KEY `fk-user_blocking-user_id` (`user_id`),
  CONSTRAINT `fk-user_blocking-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблица списка IP и телефонов ненадежных клиентов для блокировки предоставления им услуг';

-- ----------------------------
-- Records of user_blocking
-- ----------------------------

-- ----------------------------
-- Table structure for user_review
-- ----------------------------
DROP TABLE IF EXISTS `user_review`;
CREATE TABLE `user_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `user_id` int(11) DEFAULT NULL COMMENT 'внешний ключ на таблицу пользователей',
  `phone` bigint(11) DEFAULT NULL COMMENT 'телефон клиента',
  `car_model` varchar(50) DEFAULT NULL COMMENT 'модель авто клиента',
  `car_number` varchar(10) DEFAULT NULL COMMENT 'номер авто клиента',
  `first_name` varchar(50) DEFAULT NULL COMMENT 'имя клиента',
  `last_name` varchar(50) DEFAULT NULL COMMENT 'фамилия клиента',
  `message` text COMMENT 'текст - отзыв о клиенте',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время создания отзыва',
  PRIMARY KEY (`id`),
  KEY `freee` (`user_id`),
  CONSTRAINT `fk-user_review-service_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблца отзывов мойщиков и менеджеров о клиентах';

-- ----------------------------
-- Records of user_review
-- ----------------------------

-- ----------------------------
-- Table structure for user_sms_query
-- ----------------------------
DROP TABLE IF EXISTS `user_sms_query`;
CREATE TABLE `user_sms_query` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
  `user_id` int(11) DEFAULT NULL COMMENT 'внешний ключ на таблицу пользователей',
  `phone` bigint(11) DEFAULT NULL COMMENT 'телефон',
  `code` varchar(10) DEFAULT NULL COMMENT 'код из смс',
  `hash` varchar(32) DEFAULT NULL COMMENT 'хеш-код смс',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата создания кода',
  `end_time` timestamp NULL DEFAULT NULL COMMENT 'дата окончания действия кода',
  `status` enum('active','disabled','used') DEFAULT 'active' COMMENT 'статус активности кода',
  PRIMARY KEY (`id`),
  KEY `fk-user_sms_query` (`user_id`),
  CONSTRAINT `fk-user_sms_query` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='таблица запросов СМС кодов пользователей';

-- ----------------------------
-- Records of user_sms_query
-- ----------------------------
INSERT INTO `user_sms_query` VALUES ('5', null, '380555555555', '0552', 'f1853ed53cc1727a371092d9093bc8c9', '2018-05-21 20:30:26', '2018-05-21 20:40:26', 'active');
INSERT INTO `user_sms_query` VALUES ('6', null, '380555555555', '8750', 'ea44e0a7331f61a8ca1665644238de59', '2018-05-21 20:31:34', '2018-05-21 20:41:34', 'active');
INSERT INTO `user_sms_query` VALUES ('7', null, '380555555555', '5537', 'dfb5e78f7e135c12dae99c7b5e163cdc', '2018-05-21 20:31:36', '2018-05-21 20:41:36', 'active');
INSERT INTO `user_sms_query` VALUES ('8', null, '380667274171', '5921', '880fbc8d9b3230429dd0aec0f5cb7a35', '2018-05-21 20:32:16', '2018-05-21 20:42:16', 'active');
INSERT INTO `user_sms_query` VALUES ('9', '1', '380667274172', '6960', '61b34bc4e712700f3fb743a649804e13', '2018-05-21 20:32:27', '2018-05-21 20:42:27', 'active');
INSERT INTO `user_sms_query` VALUES ('10', '1', '380667274172', '1111', '66715e20a0f4c14336cf2f8ee9f36519', '2018-05-21 20:34:02', '2018-05-21 20:44:02', 'active');
INSERT INTO `user_sms_query` VALUES ('11', null, '380123333333', '1111', '89874c07c9488444c4e39c746cec9e6c', '2018-05-21 20:40:03', '2018-05-21 20:50:03', 'active');
INSERT INTO `user_sms_query` VALUES ('12', null, '380111111111', '1111', '3aa9028d22f7600c752af3e074a4ce94', '2018-05-21 20:59:55', '2018-05-21 21:09:55', 'active');
INSERT INTO `user_sms_query` VALUES ('13', null, '380222222222', '1111', '1d6e2072e554360f265cb3a2ee8b2bd1', '2018-05-21 21:03:08', '2018-05-21 21:13:08', 'active');
INSERT INTO `user_sms_query` VALUES ('14', null, '380555555555', '1111', '74af5367a5a99d1febb1236618adc8e6', '2018-05-21 21:57:26', '2018-05-21 22:07:26', 'active');
INSERT INTO `user_sms_query` VALUES ('15', '3', '380555555555', '1111', 'ca2e30ee535297ebf10d53c53e87179b', '2018-05-21 22:09:00', '2018-05-21 22:19:00', 'active');
INSERT INTO `user_sms_query` VALUES ('16', null, '380333333333', '1111', '66d362dd53832367ced1da840d673b17', '2018-05-21 22:12:50', '2018-05-21 22:22:50', 'used');
INSERT INTO `user_sms_query` VALUES ('17', '3', '380555555555', '1111', 'badaf650ae6f27723c60984ee6fb4d57', '2018-05-21 22:13:31', '2018-05-21 22:23:31', 'used');
INSERT INTO `user_sms_query` VALUES ('18', '3', '380555555555', '1111', '050d791b01d6fe37f32781ec92f3931c', '2018-05-21 22:24:09', '2018-05-21 22:34:09', 'used');
INSERT INTO `user_sms_query` VALUES ('19', '3', '380555555555', '1111', '2245cb81df4034b1dadf597c6d08926f', '2018-05-21 22:24:56', '2018-05-21 22:34:56', 'used');
INSERT INTO `user_sms_query` VALUES ('20', '3', '380555555555', '1111', '9129374beb1c7aa02f2479e6e2a28b0c', '2018-05-21 22:25:59', '2018-05-21 22:35:59', 'used');
INSERT INTO `user_sms_query` VALUES ('21', '3', '380555555555', '1111', '8e0b6cf9b477c65524fbe8a6926c0b0c', '2018-05-21 22:26:47', '2018-05-21 22:36:47', 'used');
INSERT INTO `user_sms_query` VALUES ('22', '3', '380555555555', '1111', 'cc87145c0e12fd1a73f38badff08eb5d', '2018-05-21 22:27:36', '2018-05-21 22:37:36', 'used');
INSERT INTO `user_sms_query` VALUES ('23', null, '380667274171', '1111', '0c7e79c7d0731a6eb441376ffaa96d3a', '2018-05-21 22:31:10', '2018-05-21 22:41:10', 'active');
INSERT INTO `user_sms_query` VALUES ('24', null, '380667274171', '1111', '01932ccb45e14b020b5eef2b2e13cf62', '2018-05-21 22:34:24', '2018-05-21 22:44:24', 'used');
INSERT INTO `user_sms_query` VALUES ('25', null, '380667274171', '9583', '376e87cb63ec93d41a3dc3dd8d3e8cac', '2018-05-21 22:35:28', '2018-05-21 22:45:28', 'active');
INSERT INTO `user_sms_query` VALUES ('26', null, '380667274171', '2209', '656abe0e67f809f7cdddde8731628999', '2018-05-21 22:37:34', '2018-05-21 22:47:34', 'active');
INSERT INTO `user_sms_query` VALUES ('27', null, '380667274171', '1125', '383b5d57abe68cafaeb4b4875057bd74', '2018-05-21 22:40:35', '2018-05-21 22:50:35', 'active');
INSERT INTO `user_sms_query` VALUES ('28', null, '380667274171', '8284', '92f5be888fa0a40eef35856dd6c63c00', '2018-05-21 22:50:32', '2018-05-21 23:00:32', 'active');
INSERT INTO `user_sms_query` VALUES ('29', null, '380667274171', '7884', 'd8024e0ed6b2f6f01a7ea9c1beb84576', '2018-05-21 22:51:55', '2018-05-21 23:01:55', 'active');
INSERT INTO `user_sms_query` VALUES ('30', null, '380667274171', '3045', '20650cf09d23e0142fe1153d2090487c', '2018-05-21 22:52:35', '2018-05-21 23:02:35', 'active');
INSERT INTO `user_sms_query` VALUES ('31', null, '380667274171', '2231', '1d2960418a2b46390475c818edad58b8', '2018-05-21 22:54:13', '2018-05-21 23:04:13', 'active');
INSERT INTO `user_sms_query` VALUES ('32', null, '380066771111', '1111', '937de4a3f97363b7247038cd23991aa1', '2018-05-22 00:50:07', '2018-05-22 01:00:07', 'used');
INSERT INTO `user_sms_query` VALUES ('33', '1', '380667274171', '1111', '72b3edfaceb476ec4d1806901189137a', '2018-05-22 00:51:10', '2018-05-22 01:01:10', 'used');
INSERT INTO `user_sms_query` VALUES ('34', '1', '380667274171', '1111', '82b6553e31ba24b68bcfbc275246d44c', '2018-05-22 17:26:06', '2018-05-22 17:36:06', 'used');
INSERT INTO `user_sms_query` VALUES ('35', '1', '380667274171', '1111', '82df5e8c4729bf2ab7d068121178a960', '2018-05-22 17:33:00', '2018-05-22 17:43:00', 'used');
INSERT INTO `user_sms_query` VALUES ('36', '1', '380667274171', '1111', '964c686f893bc5bef5ec461574aa688b', '2018-05-22 17:42:50', '2018-05-22 17:52:50', 'active');
INSERT INTO `user_sms_query` VALUES ('37', null, '380066727417', '1111', '7068138d876d83f825ead7abfc35ea5b', '2018-05-22 17:46:42', '2018-05-22 17:56:42', 'used');
INSERT INTO `user_sms_query` VALUES ('38', '1', '380667274171', '1111', '81bd0866d087f03add07097b9ef2dea0', '2018-05-22 17:50:37', '2018-05-22 18:00:37', 'used');
INSERT INTO `user_sms_query` VALUES ('39', '1', '380667274171', '1111', '9d8c3577a45b6800fd29d482774d102e', '2018-05-22 18:46:25', '2018-05-22 18:56:25', 'used');
INSERT INTO `user_sms_query` VALUES ('40', '1', '380667274171', '1111', '0643ba4cf08cf24ebdf6c3d7fc1eb4f5', '2018-05-22 18:46:59', '2018-05-22 18:56:59', 'used');
INSERT INTO `user_sms_query` VALUES ('41', '1', '380667274171', '1111', '568b44961db9a6d7fdbde767c2b904fb', '2018-05-22 19:00:51', '2018-05-22 19:10:51', 'used');
INSERT INTO `user_sms_query` VALUES ('42', '1', '380667274171', '1111', '2d8a2c10e24b0df8c0e0595f488136c7', '2018-05-22 20:05:40', '2018-05-22 20:15:40', 'used');
INSERT INTO `user_sms_query` VALUES ('43', '1', '380667274171', '3680', 'd226363d43e7a930c454aa62f7645284', '2018-05-22 20:25:28', '2018-05-22 20:35:28', 'active');
INSERT INTO `user_sms_query` VALUES ('44', '1', '380667274171', '1111', 'c1a9af6f075cb824ee902901782239d4', '2018-05-22 22:36:28', '2018-05-22 22:46:28', 'used');
INSERT INTO `user_sms_query` VALUES ('45', '1', '380667274171', '1111', '1e8df2430b9ea05765260d645f5ff77d', '2018-05-22 23:03:35', '2018-05-22 23:13:35', 'used');
INSERT INTO `user_sms_query` VALUES ('46', null, '380667574172', '1111', 'b6a5ec9c31323701826c62a55e337df2', '2018-05-23 16:26:28', '2018-05-23 16:36:28', 'used');
