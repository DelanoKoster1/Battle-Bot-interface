DROP DATABASE IF EXISTS `battlebot`;
CREATE DATABASE IF NOT EXISTS `battlebot`;

USE `battlebot`;

CREATE TABLE IF NOT EXISTS `role` (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,

    CONSTRAINT pk_role PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `stats` (
    id INT NOT NULL AUTO_INCREMENT,
    wins INT NOT NULL DEFAULT 0,
    playedMatches INT NOT NULL DEFAULT 0,

    CONSTRAINT pk_stats PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `specs` (
    id INT NOT NULL AUTO_INCREMENT,
    board VARCHAR(100) NOT NULL,
    interface VARCHAR(100) NOT NULL,

    CONSTRAINT pk_specs PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `bot` (
    id INT NOT NULL AUTO_INCREMENT,
    statsId INT NOT NULL,
    specsId INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(999),
    imagePath VARCHAR(50),

    CONSTRAINT pk_bot PRIMARY KEY (id)
    
    );

CREATE TABLE IF NOT EXISTS `team` (
    id INT NOT NULL AUTO_INCREMENT,
    botId INT NOT NULL,
    name VARCHAR(50) NOT NULL,

    CONSTRAINT pk_team PRIMARY KEY (id)
    );

CREATE TABLE IF NOT EXISTS `account` (
    id INT NOT NULL AUTO_INCREMENT,
    teamId INT,
    roleId INT NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(200) NOT NULL,
    points int(11) NOT NULL DEFAULT 1000,

    CONSTRAINT pk_account PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `event` (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    date TIMESTAMP NOT NULL,
    description VARCHAR(999) NOT NULL,
    type enum('public','private') NOT NULL,

    CONSTRAINT pk_event PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `team-event` (
    eventId INT NOT NULL,
    teamId INT NOT NULL,
    points INT DEFAULT 0,

    CONSTRAINT pk_team_event PRIMARY KEY (eventId, teamId)
    );

INSERT INTO `role` (id, name) VALUES (1, "Default"), (2, "Admin");

INSERT INTO `stats` (id) VALUES (1), (2), (3), (4), (5);

INSERT INTO `specs` (id, board, interface) VALUES (1, "ESP32", "Arduino IDE"), (2, "ESP32", "Arduino IDE"), (3, "ESP32", "Arduino IDE"), (4, "ESP32", "Arduino IDE"), (5, "ESP32", "Arduino IDE");

INSERT INTO `bot` (id, statsId, specsId, name, description, imagePath) VALUES (1, 1, 1, "Bot1", "Description Bot1", "image.png"), (2, 2, 2, "Bot2", "Description Bot2", "image.png"), (3, 3, 3, "Bot3", "Description Bot3", "image.png"), (4, 4, 4, "Bot4", "Description Bot4", "image.png"), (5, 5, 5, "Bot5", "Description Bot5", "image.png");

INSERT INTO `team` (id, botId, name) VALUES (1, 1, "INF1A"), (2, 2, "INF1B"), (3, 3, "INF1C"), (4, 4, "INF1D"), (5, 5, "INF1E");

INSERT INTO `account` (id, teamId, roleId, username, password, email) VALUES (1, 0, 1, "User", "test1", "user1@battlebot.nl"), (2, 0, 2, "Admin", "test2", "admin@battlebot.nl");

INSERT INTO `event` (id, name, date, description) VALUES (1, "Main Event", "2022-04-14 08:30:00", "The main BattleBot Event!");

INSERT INTO `team-event` (eventId, teamId) VALUES (1, 1);