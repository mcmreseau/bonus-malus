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
            $req = "SELECT * FROM Seance
                    INNER JOIN Groupe ON Seance.id_groupe = Groupe.id_groupe
                    INNER JOIN Matiere ON Seance.id_matiere = Matiere.id_matiere
                    INNER JOIN Professeur ON Seance.id_prof = Professeur.id_prof
                    order by Seance.nom_seance asc";
            $stmt = $this->con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }