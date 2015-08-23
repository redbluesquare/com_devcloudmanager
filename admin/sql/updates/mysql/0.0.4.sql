ALTER TABLE `#__ddc_items` ADD COLUMN `expiry_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `#__ddc_invoice_details` ADD COLUMN `invoiceheader_id` INT(11) NOT NULL DEFAULT '0' AFTER `ddc_invoice_detail_id`;
ALTER TABLE `#__ddc_invoice_details` ADD COLUMN `pos` INT(11) NOT NULL DEFAULT '0' AFTER `invoiceheader_id`;
ALTER TABLE `#__ddc_services` ADD COLUMN `start_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `client_id`;
ALTER TABLE `#__ddc_invoice_headers` ADD COLUMN `token` varchar(255) NOT NULL AFTER `state`;
ALTER TABLE `#__ddc_invoice_headers` ADD COLUMN `hits` int(11) NOT NULL DEFAULT '0' AFTER `token`;
ALTER TABLE `#__ddc_payments` ADD COLUMN `state` TINYINT(3) NOT NULL DEFAULT 0 AFTER `token`;