ALTER TABLE `service` ADD COLUMN `menu_block` smallint NULL DEFAULT 1 AFTER `money_cost`;
ALTER TABLE `service` ADD COLUMN `sort` smallint NULL DEFAULT 0 AFTER `menu_block`;