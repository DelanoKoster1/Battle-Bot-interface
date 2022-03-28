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
    macAddress VARCHAR(18),
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
    date dateTime NOT NULL,
    description VARCHAR(999) NOT NULL,
    type enum('public','private') NOT NULL,
    active boolean not NULL,
    stream VARCHAR(255),

    CONSTRAINT pk_event PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `poll` (
    id INT NOT NULL AUTO_INCREMENT,
    questionType VARCHAR(50) NOT NULL,
    question VARCHAR(50) NOT NULL,
    answer1 VARCHAR(50) NULL,
    answer2 VARCHAR(50) NULL,
    answer3 VARCHAR(50) NULL,
    answer4 VARCHAR(50) NULL,
    answer5 VARCHAR(50) NULL,
    pollOutcome VARCHAR(50) NULL,
    active boolean,
    CONSTRAINT pk_poll PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `poll-outcome` (
    id INT NOT NULL AUTO_INCREMENT,
    userName VARCHAR(255) NULL,
    givenAnswer VARCHAR(255),
    CONSTRAINT pk_pollA PRIMARY KEY (id)
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

INSERT INTO `bot` (id, statsId, specsId, name, description, imagePath) VALUES (1, 1, 1, "Bot1", "Description Bot1", NULL), (2, 2, 2, "Bot2", "Description Bot2", NULL), (3, 3, 3, "Bot3", "Description Bot3", NULL), (4, 4, 4, "Bot4", "Description Bot4", NULL), (5, 5, 5, "Bot5", "Description Bot5", NULL);

INSERT INTO `team` (id, botId, name) VALUES (1, 1, "INF1A"), (2, 2, "INF1B"), (3, 3, "INF1C"), (4, 4, "INF1D"), (5, 5, "INF1E");

INSERT INTO `account` (id, teamId, roleId, username, password, email) VALUES (1, 0, 1, "User", "$2y$10$aGQ8W0VZuImV2hrYKq3HdO2sGSnDip3X.WekIXwgq0vk1tLlKak.6", "user1@battlebot.nl"), (2, 0, 2, "Admin", "$2y$10$0CG/LGUl/KgxUQFGBzqkUOXHFoNL03jQY9JKbq6KrXGO3R9/vcusC", "admin@battlebot.nl");

INSERT INTO `event` (id, name, date, description, stream) VALUES (1, "Main Event", "2022-04-14 08:30:00", "The main BattleBot Event!", "")
                                                        ,(2, "Past Event", "2022-01-01 08:30:00", "The Past BattleBot Event!", "Purple_Disco_Machine,_Sophie_and_the_Giants_-_In_The_Dark.mp4");

INSERT INTO `team-event` (eventId, teamId) VALUES (1, 1);