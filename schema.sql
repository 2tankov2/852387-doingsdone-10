CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE `projects` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) NOT NULL,
  `user_id` INT unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tasks` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `user_id` INT unsigned NOT NULL,
  `project_id`INT unsigned NOT NULL,
  `date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `state` TINYINT DEFAULT '0',
  `name` CHAR(255) NOT NULL,
  `file_url` CHAR(255),
  `complete_date` DATE DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `email` CHAR(225) NOT NULL,
  `name` CHAR(225) NOT NULL,
  `password` CHAR(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
