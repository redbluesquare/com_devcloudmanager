ALTER TABLE `#__ddc_tasks` 
	CHANGE COLUMN `timestart` `timestart` TIME DEFAULT '00:00:00',
	CHANGE COLUMN `timeend` `timeend` TIME DEFAULT '00:00:00';