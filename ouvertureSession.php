<?php
// Connexion à la base de données
$mysqli = mysqli_connect("localhost", "user", "password", "mydatabase");

// Création de la table de session
$sql = "CREATE TABLE IF NOT EXISTS sessions (
        id varchar(255) NOT NULL,
        data text NOT NULL,
        expiration int(11) NOT NULL,
        PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
mysqli_query($mysqli, $sql);

// Configuration de PHP pour utiliser la base de données pour stocker les informations de session
ini_set('session.save_handler', 'user');
ini_set('session.save_path', 'localhost:/tmp');

// Démarrage de la session
session_start();

// Stockage et récupération des données de session
$_SESSION['username'] = 'John';
echo $_SESSION['username'];

// Déconnexion de la base de données
mysqli_close($mysqli);
?>