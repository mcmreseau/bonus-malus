<?php 
    include_once("../db/connect.php");
    include_once("etudiant.php");
     class matiere {
        private $con;
        function __construct(){
            //$this->con = new PDO("mysql:host=localhost;dbname=base_test","root","root");
            $this->con = connexion();
        }

        public function findById($id_mat) {         
            $req = "select * from Matiere where id_matiere=:id";
            $stmt = $this->con->prepare($req);
            $res = $stmt->execute([":id"=>$id_mat]);
            return $stmt->fetch();
        }

        public function findMatiere($id_etud){
            $e = new etudiant();
            $e=$e->findById($id_etud);
            $stmt="select Groupe.id_groupe, Etudiant.id_etudiant, Etudiant.nom_etudiant, Matiere.id_matiere, Matiere.intitule
             from Groupe join Etudiant on Groupe.id_groupe = Etudiant.id_groupe 
             join Seance on Groupe.id_groupe = Seance.id_groupe 
             join Matiere on Seance.id_matiere = Matiere.id_matiere 
             where Etudiant.id_etudiant = :id ";
            $req = $this->con->prepare($stmt);
            $req->execute([":id"=>$e["id_groupe"]]);
            $res =  $req->fetchAll();

            $tabilou=[];
            foreach($res as $row){
                if( !in_array($row,$tabilou)){
                    $tabilou[] = $row;
                }
            }

            return $tabilou;
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

        public function findMatBonusForEtud($id_mat, $id_etud  ){
            $stmt  = "select Bonus.id_etudiant,Matiere.id_matiere, Matiere.intitule, Bonus.note, Seance.date_seance
             from Matiere left join Seance on Matiere.id_matiere = Seance.id_matiere 
             left join Bonus on Seance.id_seance = Bonus.id_seance 
             where Matiere.id_matiere = :id_mat AND Bonus.id_etudiant =:id_etud";
            // $stmt  = "select bonus.id_etudiant, matiere.intitule, SUM(bonus.note) as note , seance.date_seance from matiere left join seance on matiere.id_matiere = seance.id_matiere left join bonus on seance.id_seance = bonus.id_seance where bonus.id_etudiant = 3 group by matiere.id_matiere, matiere.intitule";
            // print_r($stmt);
            $req = $this->con->prepare($stmt);
            $req->execute([":id_mat"=>$id_mat, ":id_etud"=>$id_etud]);
            // $req->execute();

            return $req->fetchAll();
        }
    }