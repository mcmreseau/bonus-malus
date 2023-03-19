<?php
         
         //Rôle 1 = Administrateur
         //Rôle 2 = Professeur
         //Rôle 3 = Etudiant

session_start(); //Demarrage de la session
include('../db/connect.php') ; //Connexion à la bd

if(!empty($_POST['email']) && !empty($_POST['password'])) {

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $email = strtolower($email); //email transformé en miniscule

        if (empty($email)) {
                header('Location : acceuil.php?error = Email is required');
                exit();
        }else if(empty($password)){
                header('Location : acceuil.php?error = Password is required');
                exit();
        }
        //On regarde si l'utilisateur est inscrit dans la base de données

        $check = $bdd -> prepare('SELECT * FROM identifiant WHERE mail = ?');
        $check -> execute(array($email));
        $data = $check -> fetch();
        $row = $check -> rowcount();

        

        // si >0 alors l'utilisateur existe

        if($row > 0){
                // si le mail est bon niveau format
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        //si le mdp est bon 
                        if(password_verify($password, $data['password'])) {
                                //On crée la session et on dirige sur acceuil.php
                                $_SESSION['user'] = $data['token'];
                                header('Location: ./view/acceuil.php');
                                die();
                        }else{
                                header('Location: ./view/acceuil.php ? login_err = password');
                                die(); 
                        } 
                } else {
                                header('Location: ./view/acceuil.php ? login_err = email');
                                die();
                        }
                } else {
                                header('Location: ./view/acceuil.php?login_err = already');
                                die();
                         }
                } else { //Si le formulaire est renvoyé sans aucune données
                        header('Location: ./view/acceuil.php');
                        die();
                } 
?>