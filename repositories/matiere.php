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
        /**
         * @param array $name
         */
        public function addMat(array $tab){
            $req = "insert into Matiere(id_matiere,intitule)values 
                                        (:a,:b)";
            $stmt = $this->con->prepare($req);
            $res = $stmt->execute([":a"=>$tab[0],":b"=>$tab[1]]);
            return $res;
        }
        
        public function finfAll(){
            $res = $this->con->query("select * from Matiere");
            return $res->fetchAll();
        }
    }