CREATE DATABASE readme
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login CHAR(255) NOT NULL UNIQUE,
    email CHAR(128) NOT NULL UNIQUE,
    password CHAR(64),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    avatar CHAR(64)
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    type_id INT,
    header CHAR(255),
    post TEXT(65535),
    author_quote CHAR(255),
    images_link CHAR(64),
    video_link CHAR(255),
    site_link CHAR(255),
    hashtag TEXT(1000),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    view INT
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    post_id INT,
    post TEXT(65535),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    post_id INT
);

CREATE TABLE subscribes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    subscribed_id INT
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    addressee_id INT,
    message TEXT(65535),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE hashtags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hashtag CHAR(255)
);

CREATE TABLE type_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(255),
    icon CHAR(64)
);