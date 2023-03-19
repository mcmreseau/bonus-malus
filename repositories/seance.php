<?php 
    include_once("../db/connect.php");
    class SeanceRepo {
        private $con;

        public function __construct(){
            $this->con = connexion();
        }

        public function findSeanceActive(int $id_prof){
            $stmt="select * from Seance where id_prof=:id and date_seance >= now()";
            $req = $this->con->prepare($stmt);
            $req->bindParam(":id",$id_prof);
            $req->execute();
            return $req->fetchAll();
        }

        public function findSeanceNoActive(int $id_prof){
            $stmt="select * from Seance where id_prof=:id and date_seance < now()";
            $req = $this->con->prepare($stmt);
            $req->bindParam(":id",$id_prof);
            $req->execute();
            return $req->fetchAll();
        }

        public function findAll() {
            $req = "SELECT * FROM seance
                    INNER JOIN groupe ON seance.id_groupe = groupe.id_groupe
                    INNER JOIN matiere ON seance.id_matiere = matiere.id_matiere
                    INNER JOIN professeur ON seance.id_prof = professeur.id_prof";
            $stmt = $this->con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }