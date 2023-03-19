<?php 
    include_once("../db/connect.php");

     class Identifiant{
        private $con;
        public function __construct(){
            $this->con = connexion();
        }

      
        public function findByMail(string $mail) {         
            $req = "select * from Identifiant where mail=?";
            $stmt = $this->con->prepare($req);
            $res = $stmt->execute(array($mail));
            return $stmt->fetch();
        }

        public function update(array $tab){
            $req = $this->con->prepare("update Identifiant set mail=:a,pwd=:b,role_id=:c");
            $pass = password_hash($tab[1],PASSWORD_DEFAULT);
            $res = $req->execute([":a"=>$tab[1],":b"=>$pass,":c"=>$tab[2]]);
            return $res;
        }

        public function deleteByMail(int $mail){
            $stmt = $this->con->prepare("delete from Professeur where mail=:mail");
            $stmt->bindParam(":mail",$mail);
            return $stmt->execute();
            //si on veut supprimer un identifiant on vérifie que ça n'appartient à aucun user ou?
        }
    public function addId($tab){
        $req = "insert into Identifiant(mail,mdp,role_id) values (:a,:b,:c)";
        $stmt = $this->con->prepare($req);
        $stmt->bindParam(":a",$tab[0]);
        $pass = password_hash($tab[1],PASSWORD_DEFAULT);
        $stmt->bindParam(":b",$pass);
        $stmt->bindParam(":c",$tab[2]);
        $res=$stmt->execute();
        return $res;
    }

        
    }