CREATE DATABASE `readme`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE `readme`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `login` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` char(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `avatar` varchar(64) DEFAULT NULL
);

CREATE TABLE `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `icon` varchar(64) NOT NULL
);

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `hashtag` varchar(255) NOT NULL
);

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `header` varchar(255) NOT NULL,
  `post` mediumtext NOT NULL,
  `author_quote` varchar(255) NULL DEFAULT NULL,
  `image_link` varchar(255) NULL DEFAULT NULL,
  `video_link` varchar(255) NULL DEFAULT NULL,
  `site_link` varchar(255) NULL DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `view` int(11) NOT NULL DEFAULT 0,
  `repost_id` INT(11) NULL DEFAULT NULL,
  KEY `type_id` (`type_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `content_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `posts_hashtags` (
  `post_id` int(11) NOT NULL,
  `hashtag_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`, `hashtag_id`),
  KEY `user_id` (`hashtag_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `posts_hashtags_ibfk_1` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_hashtags_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE

);

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`user_id`, `post_id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `message` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  KEY `recipient_id` (`recipient_id`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `subscribed_id` int(11) NOT NULL,
  KEY `subscribed_id` (`subscribed_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `subscribes_ibfk_1` FOREIGN KEY (`subscribed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subscribes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE FULLTEXT INDEX header_post_search ON posts(header, post);
