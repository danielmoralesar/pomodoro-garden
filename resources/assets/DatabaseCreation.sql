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

INSERT INTO PomodoroGardenDB.users (name, email, password) VALUES ("test", "correo@mail.com", "ContraseñaHasheada");

INSERT INTO plants (title, description, plant_pic, deadline, planted_day, plant_state, previous_state, task_completed, health_points) VALUES ("Test", "test", "/resources/assets/silencePrincess.jpg", 1, 2, "seed", "initial", false, 100);