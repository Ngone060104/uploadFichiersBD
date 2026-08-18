-- Active: 1782519660172@@127.0.0.1@3306@gestion_personnes
CREATE DATABASE IF NOT EXISTS gestion_personnes;
USE gestion_personnes;

-- 1. Supprimer l'ancienne table (et toutes ses données)
DROP TABLE IF EXISTS personnes;

-- 2. Créer la nouvelle table avec la colonne LONGBLOB
CREATE TABLE personnes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    image_data LONGBLOB NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


