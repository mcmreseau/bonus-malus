<?php 
  session_start();
  if(empty($_SESSION["user"])){
    header("location:login.php");
  }
  if($_SESSION["role"]=="etudiant"){
    require_once("accueil_etudiant.php");
  }
  else if($_SESSION["role"]=="professeur"){
    require_once("accueil_prof.php");
  }
?>
