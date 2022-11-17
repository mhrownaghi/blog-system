CREATE TABLE IF NOT EXISTS `users` (
    `id` SERIAL PRIMARY KEY,
    `name` VARCHAR(400),
    `username` VARCHAR(150),
    `email` VARCHAR(100),
    `password` VARCHAR(100),
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB CHARACTER SET utf8mb4;

CREATE TABLE IF NOT EXISTS `categories` (
    `id` SERIAL PRIMARY KEY,
    `name` VARCHAR(255),
    `note` VARCHAR(255),
    `description` TEXT,
    `published` BOOLEAN,
    `image` VARCHAR(255),
    `alt` VARCHAR(255),
    `seo_title` VARCHAR(255),
    `seo_description` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB CHARACTER SET utf8mb4;

CREATE TABLE IF NOT EXISTS `articles` (
    `id` SERIAL PRIMARY KEY,
    `title` VARCHAR(255),
    `slug` VARCHAR(255),
    `content` TEXT,
    `published` BOOLEAN,
    `image` VARCHAR(255),
    `alt` VARCHAR(255),
    `seo_title` VARCHAR(255),
    `seo_description` TEXT,
    `author` BIGINT UNSIGNED NOT NULL,
    `category` BIGINT UNSIGNED NOT NULL,    
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk-article-author`
        FOREIGN KEY (`author`) REFERENCES `users` (`id`)
        ON DELETE CASCADE
        ON UPDATE RESTRICT,
    CONSTRAINT `fk-article-category`
        FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)