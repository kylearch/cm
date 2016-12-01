# User Table
CREATE TABLE `users` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`numComments` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

# Comments Table
CREATE TABLE `comments` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`userId` INT(11) UNSIGNED NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`comment` TEXT NOT NULL,
	`length` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`averageWordLength` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`twoLetterWords` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`capitalLetters` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	KEY `usersUserIdForeign` (`userId`),
	CONSTRAINT `usersUserIdForeign` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;