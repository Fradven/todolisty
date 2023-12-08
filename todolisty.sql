CREATE DATABASE todolisty /!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci/ /!80016 DEFAULT ENCRYPTION='N'/;

CREATE TABLE priority (
  id int NOT NULL AUTO_INCREMENT,
  label varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE role (
  id int NOT NULL AUTO_INCREMENT,
  label varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE status (
  id int NOT NULL AUTO_INCREMENT,
  label varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tasks (
  id int NOT NULL AUTO_INCREMENT,
  title varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  body text COLLATE utf8mb4_general_ci COMMENT 'Content of the post',
  create_user_id int DEFAULT NULL,
  assign_user_id int DEFAULT NULL,
  status_id int DEFAULT NULL,
  priority_id int DEFAULT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  deleted_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY status_id (status_id),
  KEY priority_id (priority_id),
  KEY create_user_id (create_user_id),
  KEY assign_user_id (assign_user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE users (
  id int NOT NULL AUTO_INCREMENT,
  username varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  password varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  deleted_at timestamp NULL DEFAULT NULL,
  role_id int DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO status (label) VALUES ('à faire');
INSERT INTO status (label) VALUES ('en cours');
INSERT INTO status (label) VALUES ('terminé');

INSERT INTO priority (label) VALUES ('bas');
INSERT INTO priority (label) VALUES ('moyen');
INSERT INTO priority (label) VALUES ('élevé');

INSERT INTO role (label) VALUES ('Admin');
INSERT INTO role (label) VALUES ('User');

INSERT INTO todolisty.users
(id, username, password, created_at, deleted_at, role_id)
VALUES(5, 'adam', '$2y$10$8kOt/v35OJC91gT2RnmZN.Lv4e9RU0YODxqt1EZSIJMi97DQIcfde', '2023-12-08 23:35:19', NULL, 1);
INSERT INTO todolisty.users
(id, username, password, created_at, deleted_at, role_id)
VALUES(6, 'henry', '$2y$10$jNQsfg0nBOUuL8ov6adow.twZY31uVpfpQxsUrd4VG2B8nHcCTcpK', '2023-12-08 23:41:36', NULL, 2);
INSERT INTO todolisty.users
(id, username, password, created_at, deleted_at, role_id)
VALUES(7, 'Julia', '$2y$10$Ihtuy9ta5j95Q.OPuEDgnOrycw.dbqcm6BzrGATonCBhYrkqEeKJ2', '2023-12-08 23:44:58', NULL, 2);
INSERT INTO todolisty.users
(id, username, password, created_at, deleted_at, role_id)
VALUES(8, 'Lucia', '$2y$10$PUlNKQIJFM3lPzIGeKvhOe/cFa3KK/.HsMztRVqSRRV2hYzmoEc1i', '2023-12-08 23:47:40', NULL, 2);
INSERT INTO todolisty.users
(id, username, password, created_at, deleted_at, role_id)
VALUES(9, 'Edward', '$2y$10$aVM33Jyc7ur/MiRtlPhSUOJRW0RZRgFyICG7d5udwnsKCSpu2qtXO', '2023-12-08 23:48:08', NULL, 2);