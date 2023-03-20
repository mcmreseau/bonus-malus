<?php 

  session_start();
  if(empty($_SESSION["user"])){
    header("location:login.php");
  }
  if($_SESSION["role"]=="2"){
    header('Location:accueil_etudiant.php');
  }
  else if($_SESSION["role"]=="1"){
    header('Location:accueil_prof.php');
  }
  else if($_SESSION["role"]=="3"){
    header('Location:dashboard_admin.php');
  }
?>
