CREATE DATABASE IF NOT EXISTS tp7CRUD

USE tp7CRUD;

CREATE TABLE formations (
    codeFormation VARCHAR(10) NOT NULL PRIMARY KEY,
    nomFormation VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    duration INT(11) NOT NULL
);

CREATE TABLE etudiants (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    codeFormation VARCHAR(10) DEFAULT NULL,
    KEY (codeFormation),
    FOREIGN KEY (codeFormation) REFERENCES formations(codeFormation)
);

CREATE TABLE modules (
    codeModule VARCHAR(10) NOT NULL PRIMARY KEY,
    nomModule VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    codeFormation VARCHAR(10) DEFAULT NULL,
    KEY (codeFormation),
    FOREIGN KEY (codeFormation) REFERENCES formations(codeFormation)
);

INSERT INTO formations (codeFormation, nomFormation, description, duration) VALUES
('INFO', 'Informatique', 'Licence en informatique et génie logiciel', 36),
('MATH', 'Mathématiques', 'Licence en mathématiques appliquées', 36),
('PHYS', 'Physique', 'Licence en physique fondamentale', 36);

INSERT INTO etudiants (id, nom, prenom, email, codeFormation) VALUES
(1, 'Alaoui', 'Sara', 'sara.alaoui@example.com', 'INFO'),
(2, 'Benani', 'Youssef', 'youssef.benani@example.com', 'INFO');

INSERT INTO modules (codeModule, nomModule, description, codeFormation) VALUES
('M101', 'Programmation C', 'Bases de la programmation en C', 'INFO'),
('M102', 'Bases de données', 'SQL et modélisation', 'INFO');
