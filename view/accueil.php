<?php 

  session_start();
  if(empty($_SESSION["user"])){
    header("location:login.php");
  }
  if($_SESSION["role"]=="etudiant"){
    header('Location:accueil_etudiant.php');
  }
  else if($_SESSION["role"]=="professeur"){
    header('Location:accueil_prof.php');
  }
?>
