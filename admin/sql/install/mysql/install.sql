CREATE TABLE IF NOT EXISTS `#__ddc_clients` (
  `ddc_client_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` varchar(255) NOT NULL,
  `building_number` varchar(10) NOT NULL,
  `building_name` varchar(60) NULL,
  `street` varchar(60) NOT NULL,
  `town` varchar(60) NULL,
  `district` varchar(60) NULL,
  `postcode` varchar(10) NOT NULL,
  `catid` int(11) NOT NULL,
  `rate_per_hour` double NOT NULL,
  `logo` varchar(255) NULL,
  `created_by` int(11) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL,
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL,
  PRIMARY KEY (`ddc_client_id`),
  KEY `catid` (`catid`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_clientusers` (
  `ddc_clientuser_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL,
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_clientuser_id`),
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`),
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_projects` (
  `ddc_project_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NULL,
  `pl_startdate` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `pl_enddate` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `act_startdate` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `act_enddate` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_approver` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL,
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_project_id`),
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`),
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
  
CREATE TABLE IF NOT EXISTS `#__ddc_tasks` (
  `ddc_task_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NULL,
  `user_id` int(11) NOT NULL,
  `time_estimate` int(11) NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL,
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_taskdetails` (
  `ddc_taskdetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `action_detail` text NULL,
  `timestart` int(11) NOT NULL default '0',
  `timeend` int(11) NOT NULL default '0', 
  `action_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL default '0',
  `task_id` int(11) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL,
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_taskdetail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_invoice_headers` (
  `ddc_invoice_header_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `purchase_order` varchar(255) NOT NULL,
  `posteddate` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `closeddate` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `client_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `created_by` int(11) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL,
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_invoice_header_id`),
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`),
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_invoice_details` (
  `ddc_invoice_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `item` int(11) NOT NULL default '0',
  `task` int(11) NOT NULL default '0',
  `quantity` int(11) NOT NULL default '0',
  `cost` double NOT NULL default '0.00',
  `user_id` int(11) NOT NULL default '0',
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL,
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_invoice_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_items` (
  `ddc_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NULL,
  `quantity` int(11) NOT NULL default '0',
  `cost` double NOT NULL default '0.00',
  `user_id` int(11) NOT NULL default '0',
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL,
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;