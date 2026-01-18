CREATE DATABASE IF NOT EXISTS PomodoroGardenDB;

USE PomodoroGardenDB;

CREATE TABLE IF NOT EXISTS users(
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(25) UNIQUE NOT NULL,
    email varchar(100) UNIQUE NOT NULL,
    password varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS plants(
    id int PRIMARY KEY AUTO_INCREMENT,
    title varchar(100) UNIQUE NOT NULL,
    description varchar(255),
    plant_pic varchar(255) NOT NULL,
    deadline int NOT NULL,
    planted_day int NOT NULL,
    plant_state varchar(10) NOT NULL,
    previous_state varchar(10) NOT NULL,
    task_completed bool NOT NULL,
    health_points int NOT NULL
);

DELETE FROM users;
DELETE FROM PomodoroGardenDB.users WHERE id=10;

SELECT * FROM users where "" = "";

INSERT INTO users (name, email, password) VALUES ("test2", "correo@mail.com", "pass");

UPDATE users SET name = 'testing', email = 'correo@mail.com' WHERE id=7;

SELECT * FROM users;

DROP TABLE PomodoroGardenDB.plants;