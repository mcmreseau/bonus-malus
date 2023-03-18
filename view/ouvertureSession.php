<?php
         
         //Rôle 1 = Administrateur
         //Rôle 2 = Professeur
         //Rôle 3 = Etudiant

session_start(); //Demarrage de la session
include('../db/connect.php') ;
include('../repositories/identifiant.php'); // Récupération des fonctions de gestion de la base de données
$erreur = "";

if(!empty($_POST['email']) && !empty($_POST['password'])) {

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $email = strtolower($email); //email transformé en miniscule

        if (empty($email)) {
                header('Location : login.php?erreur = Email is required');

        }else if(empty($password)){
                header('Location : login.php?erreur = Password is required');
             
        }

        //On regarde si l'utilisateur est inscrit dans la base de données
        $identifiant = new Identifiant();
        $check = $identifiant->findByMail($email);
        $row = $check -> rowcount();

        // si >0 alors l'utilisateur existe

        if($row > 0){
          // si le mail est bon niveau format
          if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  //si le mdp est bon 
                  if(password_verify($password, $data['password'])) {
                          //On crée la session et on dirige sur acceuil.php
                         // $_SESSION['user'] = $data['token'];
                          $user["password"] = "";
                          $_SESSION["role"] = $user["role_id"];
                          $_SESSION["user"] = $user;
                          $erreur = "connexion réussie";
                          header('Location : acceuil.php');
                  }else{
                          header('Location : acceuil.php ? erreur = password');
                  } 
          } else {
                          header('Location : acceuil.php ? erreur = email');
                  }
          } else {
                          header('Location : acceuil.php?erreur = already');
                   }
  } 
  else { //Si le formulaire est renvoyé sans aucune données
                  header('Location: login.php');
          } 

?>