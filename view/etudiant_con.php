
<?php 
    if(!empty($_POST["id_seance"])){
        echo $_POST["id_seance"];
        include_once("../repositories/etudiant.php");
        $etudiantRepo = new Etudiant();
        $etudiants = $etudiantRepo->findEtudiant($_POST["id_seance"]);
        var_dump($etudiants);
    }
?>