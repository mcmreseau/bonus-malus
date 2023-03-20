<?php
     include_once("../db/connect.php");   
    class Etudiant {
        
        private $con;
        function __construct(){
            $this->con = connexion();
            //$this->con = new PDO("mysql:host=localhost;dbname=base_test","root","root");
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
        public function findByMail($mail) {         
            $req = "select * from Etudiant where mail=:mail";
            $stmt = $this->con->prepare($req);
            $stmt->execute([":mail"=>$mail]);
            return $stmt->fetch();
        }
        
        public function findEtud(int $id_seance){
            $stmt= " select e.nom_etudiant,e.mail,b.note from Etudiant e
                     LEFTER JOIN Bonus b on e.id_etudiant = b.id_etudiant
                     where b.id_seance=:id";
            $req = $this->con->prepare($stmt);
            $req->execute([":id"=>$id_seance]);
            return $req->fetchAll();
        }
        public function findById(int $id_etud) {         
            $req = "select * from Etudiant where id_etudiant=:id ";
            $stmt = $this->con->prepare($req);
            $res = $stmt->execute([":id"=>$id_etud]);
            return $stmt->fetch();
    
        }
        public function findAll() {
            $req = "SELECT * FROM Etudiant INNER JOIN Groupe ON Etudiant.id_groupe = Groupe.id_groupe ORDER BY Etudiant.id_groupe";
            $stmt = $this->con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function findEtudBonus($id_etud){
            $stmt  = "select Bonus.id_etudiant, Matiere.intitule, SUM(Bonus.note) as note, 
            Seance.date_seance from Matiere left join Seance on Matiere.id_matiere = Seance.id_matiere 
            left join Bonus on Seance.id_seance = Bonus.id_seance
            where Bonus.id_etudiant = :id 
            group by Matiere.id_matiere, Matiere.intitule";
            // $stmt  = "select bonus.id_etudiant, matiere.intitule, SUM(bonus.note) as note , seance.date_seance from matiere left join seance on matiere.id_matiere = seance.id_matiere left join bonus on seance.id_seance = bonus.id_seance where bonus.id_etudiant = 3 group by matiere.id_matiere, matiere.intitule";
            // print_r($stmt);
            $req = $this->con->prepare($stmt);
            $req->execute([":id"=>$id_etud]);
            // $req->execute();

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