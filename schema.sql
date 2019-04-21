CREATE DATABASE doingdone
    CHARACTER SET UTF8
    COLLATE UTF8_GENERAL_CI;

USE doingdone;

CREATE TABLE user
(
    id          INT          NOT NULL AUTO_INCREMENT,
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    email       VARCHAR(254) NOT NULL,
    name        VARCHAR(500) NOT NULL,
    password    VARCHAR(500) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (email)
);

CREATE TABLE project
(
    id      INT          NOT NULL AUTO_INCREMENT,
    name    VARCHAR(500) NOT NULL,
    user_id INT          NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (name)
);

CREATE TABLE task
(
    id              INT          NOT NULL AUTO_INCREMENT,
    create_time     DATETIME DEFAULT CURRENT_TIMESTAMP,
    status          TINYINT,
    name            VARCHAR(500) NOT NULL,
    file_link       TEXT     DEFAULT NULL,
    expiration_time DATETIME DEFAULT NULL,
    project_id      INT          NOT NULL,
    user_id         INT          NOT NULL,
    PRIMARY KEY (id),
    INDEX (name)
);



