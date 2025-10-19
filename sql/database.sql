--
-- Table structure for table `users`
--

CREATE TABLE `users` (
	`uid` varchar(32) NOT NULL,
	`name` varchar(255) NOT NULL,
	`surname` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`password` varchar(100) NOT NULL,
	`to_modify` tinyint(1) NOT NULL DEFAULT 0,
	`date_update` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	`date_create` datetime NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`uid`),
	UNIQUE KEY `users_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger for table `users`
--

DELIMITER $$

CREATE TRIGGER add_role
AFTER INSERT
ON users FOR EACH ROW
BEGIN
	INSERT INTO user_role (uid_user) VALUES (NEW.uid);
END$$

DELIMITER ;

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data for table `roles`
--

INSERT INTO `roles` VALUES
(1,'user'),
(10,'administrator');

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
	`uid_user` varchar(32) NOT NULL,
	`id_role` int(11) NOT NULL DEFAULT 1,
	`date_update` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`uid_user`,`id_role`),
	KEY `user_role_roles_FK` (`id_role`),
	CONSTRAINT `user_role_roles_FK` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`),
	CONSTRAINT `user_role_users_FK` FOREIGN KEY (`uid_user`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
	`uid` varchar(32) NOT NULL,
	`uid_user` varchar(32) NOT NULL,
	`ip_address` varchar(255) NOT NULL,
	`token` text NOT NULL,
	`date_create` datetime NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`uid`),
	KEY `user_tokens_users_FK` (`uid_user`),
	CONSTRAINT `user_tokens_users_FK` FOREIGN KEY (`uid_user`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `user_reset_password`
--

CREATE TABLE `user_reset_password` (
	`uid_user` varchar(32) NOT NULL,
	`link` varchar(64) NOT NULL,
	`date_create` datetime NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`uid_user`),
	CONSTRAINT `user_reset_password_users_FK` FOREIGN KEY (`uid_user`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS categories (
	uid varchar(32) NOT NULL PRIMARY KEY,
	uri varchar(255) NOT NULL,
	position int NOT NULL
);

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS articles (
	uid varchar(32) NOT NULL PRIMARY KEY,
	uid_category varchar(32) NOT NULL,
	uri varchar(255) NOT NULL,
	CONSTRAINT articles_categories_FK FOREIGN KEY (uid_category) REFERENCES categories (uid)
);

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS languages (
	code varchar(7) NOT NULL PRIMARY KEY
) COLLATE = utf8mb4_general_ci;

--
-- Table structure for table `category_names`
--

CREATE TABLE IF NOT EXISTS category_names (
	uid varchar(32) NOT NULL PRIMARY KEY,
	uid_category varchar(32) NOT NULL,
	name varchar(255) NOT NULL,
	code_language varchar(7) NOT NULL,
	CONSTRAINT category_names_categories_FK FOREIGN KEY (uid_category) REFERENCES categories (uid),
	CONSTRAINT category_names_languages_code_FK FOREIGN KEY (code_language) REFERENCES languages (code)
) COLLATE = utf8mb4_general_ci;

--
-- Table structure for table `article_names`
--

CREATE TABLE IF NOT EXISTS contents (
	uid varchar(32) NOT NULL PRIMARY KEY,
	uid_article varchar(32) NOT NULL,
	uid_creator varchar(32) NULL,
	content text NOT NULL,
	display_name varchar(255) NOT NULL,
	code_language varchar(7) NOT NULL,
	CONSTRAINT contents_articles_FK FOREIGN KEY (uid_article) REFERENCES articles (uid),
	CONSTRAINT contents_languages_code_FK FOREIGN KEY (code_language) REFERENCES languages (code),
	CONSTRAINT contents_users_FK FOREIGN KEY (uid_creator) REFERENCES users (uid)
) COLLATE = utf8mb4_general_ci;

--
-- Table structure for table `versions`
--

CREATE TABLE IF NOT EXISTS versions (
	id int NOT NULL PRIMARY KEY,
	name varchar(10) NOT NULL
);

--
-- Table structure for table `article_versions`
--

CREATE TABLE IF NOT EXISTS article_versions (
	uid_article varchar(32) NOT NULL,
	id_version int NOT NULL,
	CONSTRAINT article_versions_articles_FK FOREIGN KEY (uid_article) REFERENCES articles (uid),
	CONSTRAINT article_versions_versions_FK FOREIGN KEY (id_version) REFERENCES versions (id)
);
