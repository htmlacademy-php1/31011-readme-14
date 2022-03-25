CREATE DATABASE `readme`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE `readme`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `login` char(255) NOT NULL,
  `email` char(128) NOT NULL,
  `password` char(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `avatar` char(64) DEFAULT NULL
);

CREATE TABLE `type_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` char(255) NOT NULL,
  `icon` char(64) NOT NULL
);

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `hashtag` char(255) NOT NULL
);

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `header` char(255) NOT NULL,
  `post` mediumtext NOT NULL,
  `author_quote` char(255),
  `images_link` char(64),
  `video_link` char(255),
  `site_link` char(255),
  `hashtag` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `view` int(11) NOT NULL DEFAULT 0,
  KEY `type_id` (`type_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type_content` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `addressee_id` int(11) NOT NULL,
  `message` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  KEY `addressee_id` (`addressee_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`addressee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `subscribes` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `subscribed_id` int(11) NOT NULL,
  KEY `subscribed_id` (`subscribed_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `subscribes_ibfk_1` FOREIGN KEY (`subscribed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subscribes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);