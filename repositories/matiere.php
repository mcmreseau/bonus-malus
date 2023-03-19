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
            $stmt="select groupe.id_groupe, etudiant.id_etudiant, etudiant.nom_etudiant, matiere.id_matiere, matiere.intitule from groupe join etudiant on groupe.id_groupe = etudiant.id_groupe join seance on groupe.id_groupe = seance.id_groupe join matiere on seance.id_matiere = matiere.id_matiere where etudiant.id_etudiant = :id ";
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
            $stmt  = "select bonus.id_etudiant,matiere.id_matiere, matiere.intitule, bonus.note, seance.date_seance from matiere left join seance on matiere.id_matiere = seance.id_matiere left join bonus on seance.id_seance = bonus.id_seance where matiere.id_matiere = :id_mat AND bonus.id_etudiant =:id_etud";
            // $stmt  = "select bonus.id_etudiant, matiere.intitule, SUM(bonus.note) as note , seance.date_seance from matiere left join seance on matiere.id_matiere = seance.id_matiere left join bonus on seance.id_seance = bonus.id_seance where bonus.id_etudiant = 3 group by matiere.id_matiere, matiere.intitule";
            // print_r($stmt);
            $req = $this->con->prepare($stmt);
            $req->execute([":id_mat"=>$id_mat, ":id_etud"=>$id_etud]);
            // $req->execute();

            return $req->fetchAll();
        }
    }