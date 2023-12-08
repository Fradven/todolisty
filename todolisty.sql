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