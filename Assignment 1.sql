CREATE DATABASE students;
USE students;

CREATE TABLE student (
    id int auto_increment primary key,
    student_name VARCHAR(256) not null,
    student_number int not null,
    student_age INT not null
);

INSERT INTO student (student_name, student_number, student_age)
VALUES 
('Nkem', '450', 20);