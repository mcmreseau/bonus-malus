<?php 
    include_once("./db/connect.php");
     class matiere {
        private $con;
        public function __construct(){
            $this->con = connexion();
        }

        public function findById(int $id_mat) {         
            $req = "select * from Matiere where id_matiere=?";
            $stmt = $this->con->prepare($req);
            $res = $stmt->execute(array($id_mat));
            return $stmt->fetch();
        }

        public function deleteById(int $id_mat){
            $stmt = $this->con->prepare("delete from Matiere where id_matiere=:id");
            $stmt->bindParam(":id",$id_mat);
            return $stmt->execute();
        }
    }