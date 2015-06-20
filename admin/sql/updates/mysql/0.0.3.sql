ALTER TABLE `#__ddc_tasks` 
	CHANGE COLUMN `time_estimate` `time_estimate` DOUBLE NULL DEFAULT NULL ;
ALTER TABLE `#__ddc_tasks` 
	ADD COLUMN `due_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `time_estimate`,
	ADD COLUMN `priority` INT NOT NULL DEFAULT 100 AFTER `due_date`;