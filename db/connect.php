<?php 
     function connexion() : PDO{
        //$pdo = new PDO("mysql:host=localhost;dbname=mazifa1","mazifa","2nxW2psi");
        $pdo = new PDO("mysql:host=localhost;dbname=base_test","root","");
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        return $pdo;
    }