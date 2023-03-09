<?php 
    include_once("./db/connect.php");

    
    class Groupe {
        private $con;
        public function __construct(){
            $this->con=connexion();
        }

        
        public function createG($nom) {
            $req = "insert into Groupe(nom_groupe)
                values (:a)";
            $stmt = $this->con->prepare($req);
            $res = $stmt->execute([":a"=>$nom]);
            return $res;
        }

        public function deleteById(int $id_groupe){
            $stmt = $this->con->prepare("delete from Matiere where id_matiere=:id");
            $stmt->bindParam(":id",$id_mat);
            return $stmt->execute();
        }


    }