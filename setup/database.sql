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

    CONSTRAINT pk_account PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `event` (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    date TIMESTAMP NOT NULL,
    description VARCHAR(999) NOT NULL,

    CONSTRAINT pk_event PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `team-event` (
    eventId INT NOT NULL,
    teamId INT NOT NULL,
    points INT DEFAULT 0,

    CONSTRAINT pk_team_event PRIMARY KEY (eventId, teamId)
    );