CREATE DATABASE IF NOT EXISTS PomodoroGardenDB;

USE PomodoroGardenDB;

CREATE TABLE IF NOT EXISTS users(
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(25) UNIQUE,
    email varchar(100) UNIQUE,
    password varchar(255)
);

CREATE TABLE IF NOT EXISTS plants(
    id int PRIMARY KEY AUTO_INCREMENT,
    title varchar(100) UNIQUE,
    description varchar(255),
    health_points int, 
    task_completed bool,
    instance_instance varchar(255),
    plantedDay DATE,
    plant_state varchar(10),
    previous_state varchar(10)
);

INSERT INTO users (name, email, password) VALUES (
	"emaol"
);