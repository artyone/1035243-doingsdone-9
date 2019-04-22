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
    PRIMARY KEY (id)
);

ALTER TABLE project ADD UNIQUE project_name_user_id_udx(name, user_id);

CREATE TABLE task
(
    id              INT          NOT NULL AUTO_INCREMENT,
    create_time     DATETIME DEFAULT CURRENT_TIMESTAMP,
    status          TINYINT DEFAULT 0,
    name            VARCHAR(500) NOT NULL,
    file_link       VARCHAR(500) DEFAULT NULL,
    expiration_time DATETIME DEFAULT NULL,
    user_id         INT          NOT NULL,
    project_id      INT          NOT NULL,
    PRIMARY KEY (id),
    INDEX (name),
    INDEX (status)
);

ALTER TABLE project
    ADD FOREIGN KEY (user_id)
        REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE task
    ADD FOREIGN KEY (user_id)
        REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE task
    ADD FOREIGN KEY (project_id)
        REFERENCES project(id) ON DELETE CASCADE ON UPDATE CASCADE;

