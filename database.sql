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
    type enum('public', 'private') NOT NULL,
    active boolean not NULL,
    stream VARCHAR(255),
    CONSTRAINT pk_event PRIMARY KEY (id)
);
INSERT INTO `event` (
        `id`,
        `name`,
        `date`,
        `description`,
        `type`,
        `active`,
        `stream`
    )
VALUES (
        1,
        'Test dag',
        '2022-04-06 13:00:00',
        'Test dag voor het main event',
        'public',
        0,
        NULL
    ),
    (
        2,
        'Race dag',
        '2022-04-14 20:30:00',
        'Officiële race dag',
        'public',
        0,
        NULL
    ),
    (
        3,
        'Beta dag',
        '2022-04-04 12:19:00',
        'testen van bots',
        'public',
        0,
        '/assets/video/testvideo.mp4'
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
INSERT INTO `team-event` (`eventId`, `teamId`, `points`)
VALUES (1, 1, 0),
    (1, 2, 0),
    (1, 3, 0),
    (1, 4, 0),
    (1, 5, 0),
    (2, 1, 0),
    (2, 2, 0),
    (2, 3, 0),
    (2, 4, 0),
    (2, 5, 0);
INSERT INTO `role` (id, name)
VALUES (1, "Default"),
    (2, "Admin"),
    (3, "Team");
INSERT INTO `stats` (id)
VALUES (1),
    (2),
    (3),
    (4),
    (5);
INSERT INTO `specs` (id, board, interface)
VALUES (1, "ESP32", "Arduino IDE"),
    (2, "ESP32", "Arduino IDE"),
    (3, "ESP32", "Arduino IDE"),
    (4, "ESP32", "Arduino IDE"),
    (5, "ESP32", "Arduino IDE");
INSERT INTO `bot` (
        `id`,
        `statsId`,
        `specsId`,
        `name`,
        `description`,
        `imagePath`,
        `macAddress`
    )
VALUES (
        1,
        1,
        1,
        'INF1A',
        'Robot INF1A',
        '/assets/img/bots/6/Robot_INF1A.png',
        'FC:F5:C4:2F:45:5C'
    ),
    (
        2,
        2,
        2,
        'INF1B',
        'Robot INF1B',
        '/assets/img/bots/7/Robot_INF1B.png',
        'F0:08:D1:D1:72:A0'
    ),
    (
        3,
        3,
        3,
        'INF1C',
        'Robot INF1C',
        '/assets/img/bots/8/Robot_INF1C.png',
        '84:CC:A8:7A:A2:A8'
    ),
    (
        4,
        4,
        4,
        'INF1D',
        'Robot INF1D',
        '/assets/img/bots/9/Robot_INF1D.png',
        '24:0A:C4:61:A6:88'
    ),
    (
        5,
        5,
        5,
        'INF1E',
        'Robot INF1E',
        '/assets/img/bots/10/Robot_INF1E.png',
        '84:CC:A8:7A:AF:D8'
    );
INSERT INTO `team` (`id`, `botId`, `name`)
VALUES (1, 1, 'INF1A'),
    (2, 2, 'INF1B'),
    (3, 3, 'INF1C'),
    (4, 4, 'INF1D'),
    (5, 5, 'INF1E');
INSERT INTO `account` (id, teamId, roleId, username, password, email)
VALUES (
        1,
        0,
        2,
        "Admin",
        "$2y$10$0CG/LGUl/KgxUQFGBzqkUOXHFoNL03jQY9JKbq6KrXGO3R9/vcusC",
        "admin@battlebot.nl"
    ),
    (
        2,
        1,
        3,
        "TeamA",
        "$2y$10$FkF27OUFEM6jLXTM7DKNXOnASu0JhoC8ZPGYcSd6HNrL61o2WzObG",
        "TeamA@battlebot.nl"
    ),
    (
        3,
        2,
        3,
        "TeamB",
        "$2y$10$kp7QW9GsSzACwdFIMb33ee8ObNkmDQ1DYYGQTg2/2ZbLxX8GtQp2i",
        "TeamB@battlebot.nl"
    ),
    (
        4,
        3,
        3,
        "TeamC",
        "$2y$10$E1zBeuSmsBHS1Adw8KtDhecRzxOQ7SqgWK9ER142WoL.524F7DcNi",
        "TeamC@battlebot.nl"
    ),
    (
        5,
        4,
        3,
        "TeamD",
        "$2y$10$4j.3Z9S3S9UnQnlJBd4EjeYQHUT1XbbD54byygEIqSpANYmQRG.7C",
        "TeamD@battlebot.nl"
    ),
    (
        6,
        5,
        3,
        "TeamE",
        "$2y$10$lnUNUDZHzDkkvffXBL.MZebc8jzg4AStpRLqCspENhPsLOaVpLPyy",
        "TeamE@battlebot.nl"
    );
