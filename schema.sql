CREATE DATABASE IF NOT EXISTS taskForce
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_general_ci;
USE taskForce;


CREATE TABLE category (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(128) NOT NULL UNIQUE,
code VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE specialization (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(128) NOT NULL UNIQUE,
code VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE user (
user_id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(128) NOT NULL,
email VARCHAR(128) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
role VARCHAR(128) NOT NULL,
birthday DATE,
avatar VARCHAR(255),
phone VARCHAR(11),
telegram VARCHAR(128),
location VARCHAR(128) NOT NULL,
about VARCHAR(255),
specialization_id INT,
show_contacts BOOLEAN DEFAULT FALSE,
failed_tasks INT DEFAULT 0,
FOREIGN KEY (specialization_id) REFERENCES specialization(id)
);

CREATE TABLE cities (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(128) NOT NULL UNIQUE,
latitude DECIMAL(10, 8),
longitude DECIMAL(11, 8)
);

CREATE TABLE task (
task_id INT PRIMARY KEY AUTO_INCREMENT,
title VARCHAR(128) NOT NULL,
description TEXT NOT NULL,
budget INT,
date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
due_date DATE,
status VARCHAR(128),
employer_id INT NOT NULL,
performer_id INT,
city_id INT,
category_id INT,
FOREIGN KEY (employer_id) REFERENCES user(user_id),
FOREIGN KEY (performer_id) REFERENCES user(user_id),
FOREIGN KEY (category_id) REFERENCES category(id),
FOREIGN KEY (city_id) REFERENCES cities(id)
);

CREATE TABLE file (
file_id INT PRIMARY KEY AUTO_INCREMENT,
path VARCHAR(255) NOT NULL,
id_task INT,
FOREIGN KEY (id_task) REFERENCES task(task_id)
);

CREATE TABLE response (
id INT AUTO_INCREMENT PRIMARY KEY,
date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
budget INT,
comment TEXT,
task_id INT NOT NULL,
performer_id INT NOT NULL,
is_rejected BOOLEAN DEFAULT FALSE,
FOREIGN KEY (task_id) REFERENCES task(task_id),
FOREIGN KEY (performer_id) REFERENCES user(user_id)
);

CREATE TABLE review (
id INT AUTO_INCREMENT PRIMARY KEY,
date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
text VARCHAR(1000) NOT NULL,
score INT NOT NULL,
task_id INT NOT NULL UNIQUE ,
employer_id INT NOT NULL,
performer_id INT NOT NULL,
review_name varchar(125),
review_icon varchar(125),
FOREIGN KEY (task_id) REFERENCES task(task_id),
FOREIGN KEY (employer_id) REFERENCES user(user_id),
FOREIGN KEY (performer_id) REFERENCES user(user_id)
);
