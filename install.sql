CREATE table `issue` (
`id` INT(5) PRIMARY KEY NOT NULL auto_increment ,
`title` VARCHAR(250),
`description` TEXT,
`severity` INT(2),
`urgency` INT(2),
 UNIQUE KEY `id` (`id`)
);
CREATE table `status` (
`id` INT(7) PRIMARY KEY NOT NULL auto_increment,
`id_issue` INT(5),
`status` INT(3),
`date` DATETIME,
 UNIQUE KEY `id` (`id`)
);