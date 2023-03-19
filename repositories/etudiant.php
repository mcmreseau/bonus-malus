<?php
    include_once("../db/connect.php");
    class Etudiant {
        
        private $con;
        function __construct(){
            $this->con = connexion();
        }

        public function findEtudiant(int $id_seance){
            $stmt= " select e.id_etudiant,e.nom_etudiant,e.mail,b.note,g.nom_groupe from etudiant e,
                    bonus b, groupe g where e.id_etudiant = b.id_etudiant
                    and e.id_groupe=g.id_groupe
                    and b.id_seance=:id";
            $req = $this->con->prepare($stmt);
            $req->execute([":id"=>$id_seance]);
            return $req->fetchAll();
        }

        
        public function findEtud(int $id_seance){
            $stmt= " select e.nom_etudiant,e.mail,b.note from etudiant e
                     LEFTER JOIN bonus b on e.id_etudiant = b.id_etudiant
                     where b.id_seance=:id";
            $req = $this->con->prepare($stmt);
            $req->execute([":id"=>$id_seance]);
            return $req->fetchAll();
        }

        public function addEtudiant(array $tab){
            $req = "insert into Etudiant(nom_etudiant,mail,id_groupe) values
                                        (:a,:b,:c)";
                                        //pas besoin de l'id
              $stmt = $this->con->prepare($req);
                $stmt->bindParam(":a",$tab[0]);
       // $pass = password_hash($tab[1],PASSWORD_DEFAULT);
                $stmt->bindParam(":b",$tab[1]);
                $stmt->bindParam(":c",$tab[2]);
                $res=$stmt->execute();
                     return $res;

        }

    }
?>