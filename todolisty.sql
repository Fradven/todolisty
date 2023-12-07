CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(255),
  `password` VARCHAR(255),
  `role` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP
);

CREATE TABLE `tasks` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(255),
  `body` TEXT COMMENT 'Content of the post',
  `create_user_id` INT,
  `assign_user_id` INT,
  `status_id` INT,
  `priority_id` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP,
  FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  FOREIGN KEY (`priority_id`) REFERENCES `priority` (`id`),
  FOREIGN KEY (`create_user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`assign_user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `status` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `label` VARCHAR(255)
);

CREATE TABLE `priority` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `label` VARCHAR(255)
);
