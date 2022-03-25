CREATE DATABASE `readme`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE `readme`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL UNIQUE,
  `login` char(255) NOT NULL UNIQUE,
  `email` char(128) NOT NULL UNIQUE,
  `password` char(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` char(64)
);

CREATE TABLE `posts` (
  `id` int(11) NOT NULL UNIQUE,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `header` char(255) NOT NULL,
  `post` mediumtext NOT NULL,
  `author_quote` char(255),
  `images_link` char(64),
  `video_link` char(255),
  `site_link` char(255),
  `hashtag` text,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `view` int(11) NOT NULL DEFAULT 0
);

CREATE TABLE `comments` (
  `id` int(11) NOT NULL UNIQUE,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `likes` (
  `id` int(11) NOT NULL UNIQUE,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
);

CREATE TABLE `messages` (
  `id` int(11) NOT NULL UNIQUE,
  `user_id` int(11) NOT NULL,
  `addressee_id` int(11) NOT NULL,
  `message` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `subscribes` (
  `id` int(11) NOT NULL UNIQUE,
  `user_id` int(11) NOT NULL,
  `subscribed_id` int(11) NOT NULL
);

CREATE TABLE `type_content` (
  `id` int(11) NOT NULL UNIQUE,
  `name` char(255) NOT NULL,
  `icon` char(64) NOT NULL
);

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL UNIQUE,
  `hashtag` char(255) NOT NULL
);
