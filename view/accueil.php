<?php 

include ("../repositories/professeur.php");
include ("../repositories/etudiant.php");

  session_start();
  if(empty($_SESSION["user"])){
    header("location:login.php");
  }
  if($_SESSION["role"]=="etudiant"){
    $etudiant = new Etudiant();
    header('Location:accueil_etudiant.php');
  }
  else if($_SESSION["role"]=="professeur"){
    $prof=new Professeur();
    header('Location:accueil_prof.php');
  }
?>
