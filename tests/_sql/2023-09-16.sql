CREATE TABLE `company` (
                           `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'автоинкремент',
                           `title` varchar(255) NOT NULL COMMENT 'название',
                           `title_short` varchar(255) NOT NULL COMMENT 'название',
                           `description` text DEFAULT NULL COMMENT 'описание',
                           `contacts` text DEFAULT NULL,
                           `address` text DEFAULT NULL,
                           `alias` varchar(100) NOT NULL,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Компании';

ALTER TABLE `box` ADD COLUMN `company_id` int NULL AFTER `description`;
ALTER TABLE `box` ADD COLUMN `active` smallint NULL DEFAULT 1 AFTER `company_id`;
ALTER TABLE `order` ADD COLUMN `company_id` int NULL AFTER `box_id`;
ALTER TABLE `news` ADD COLUMN `company_id` int NULL AFTER `title`;
ALTER TABLE `page` ADD COLUMN `company_id` int NULL AFTER `title`;
ALTER TABLE `review` ADD COLUMN `company_id` int NULL AFTER `id`;
ALTER TABLE `service`
    ADD COLUMN `company_id` int NULL AFTER `id`,
    MODIFY COLUMN `time_processing` time(0) NULL COMMENT 'время выполнения услуги' AFTER `description`,
    MODIFY COLUMN `money_cost` decimal(5, 2) NULL COMMENT 'стоимость услуги' AFTER `time_processing`;
ALTER TABLE `user` ADD COLUMN `company_id` int NULL AFTER `id`;
ALTER TABLE `user_blocking` ADD COLUMN `company_id` int NULL AFTER `id`;
ALTER TABLE `user_review` ADD COLUMN `company_id` int NULL AFTER `id`;
ALTER TABLE `order` DROP FOREIGN KEY `fk-order-box_id`;
ALTER TABLE `order` DROP FOREIGN KEY `fk-order-service_id`;
ALTER TABLE `order` DROP FOREIGN KEY `fk-order-user_id`;
ALTER TABLE `order` ADD CONSTRAINT `fk-order-box_id` FOREIGN KEY (`box_id`) REFERENCES `box` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                    ADD CONSTRAINT `fk-order-service_id` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                    ADD CONSTRAINT `fk-order-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                    ADD CONSTRAINT `fk-order-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `news` ADD CONSTRAINT `fk-news-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `box` ADD CONSTRAINT `fk-box-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `page` ADD CONSTRAINT `fk-page-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `review` ADD CONSTRAINT `fk-review-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `service` ADD CONSTRAINT `fk-service-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `user` ADD CONSTRAINT `fk-user-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `user_blocking` ADD CONSTRAINT `fk-user_blocking-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `user_review` ADD CONSTRAINT `fk-user_review-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;