<?php 
    include_once("../db/connect.php");
    class Professeur {
        private $con;

        public function __construct(){
            $this->con = connexion();
        }

        public function findById(int $id_prof) {         
            $req = "select * from Professeur where id_prof=?";
            $stmt = $this->con->prepare($req);
            $res = $stmt->execute(array($id_prof));
            return $stmt->fetch();
        }

        public function findByMail(string $mail) {         
            $req = "select * from Professeur where mail=?";
            $stmt = $this->con->prepare($req);
            $res = $stmt->execute(array($mail));
            return $stmt->fetch();
        }

        public function deleteById(int $id_prof){
            $stmt = $this->con->prepare("delete from Professeur where id_prof=:id");
            $stmt->bindParam(":id",$id_prof);
            return $stmt->execute();
        }

        /**
         * @param array $tab;
         */
        public function addProf(array $tab){
            $stmt = $this->con->prepare("insert into Professeur(nom_prof,prenom_prof,mail) values
                                        (:a,:b,:c)");
                                        //pas besoin de l'id
            $res = $stmt->execute([":a"=>$tab[0],":b"=>$tab[1],":c"=>$tab[2]]);
            return $res;
        }

        public function finfAll(){
            $res = $this->con->query("select * from Professeur");
            return $res->fetchAll();
        }
    }