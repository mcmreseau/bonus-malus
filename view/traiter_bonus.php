<?php 
    session_start();
    include_once("../db/connect.php");
     $con = connexion();
    if(!empty($_SESSION["user"])){
        if(!empty($_POST["id_s"]) && !empty($_POST["id_etu"])){
        $stmt= "update bonus set note=:note where 
        id_seance=:id_s and id_etudiant=:id_etu";
        $req = $con->prepare($stmt);
        $res = $req->execute([":note"=>$_POST["note"],":id_s"=>$_POST["id_s"],":id_etu"=>$_POST["id_etu"]]);
        
        }
    }


?>