<?php
    class Seance{
        private int $id_seance;
        private string $nom_seance;
        private datetime $date_seance;
        private int $id_groupe;
        private int $id_matiere;
        private int $id_prof;
        
        /**
         * @param int $id_seance
         * @param string $nom_seance
         * @param datetime $date_seance
         * @param int $id_groupe
         * @param int $id_matiere
         * @param int $id_prof
         */
        public function __construct(int $id_seance, string $nom_seance, datetime $date_seance, int $id_groupe, int $id_matiere, int $id_prof) {
            $this->id_seance = $id_seance;
            $this->nom_seance = $nom_seance;
            $this->date_seance = $date_seance;
            $this->id_groupe = $id_groupe;
            $this->id_matiere = $id_matiere;
            $this->id_prof = $id_prof;
        }
    
        /**
         * @return int
         */
        public function getId_seance(): int {
            return $this->id_seance;
        }
        
        /**
         * @param int $id_seance 
         * @return self
         */
        public function setId_seance(int $id_seance): self {
            $this->id_seance = $id_seance;
            return $this;
        }

        /**
         * @return string
         */
        public function getNom_seance(): string {
            return $this->nom_seance;
        }
        
        /**
         * @param string $nom_seance 
         * @return self
         */
        public function setNom_seance(string $nom_seance): self {
            $this->nom_seance = $nom_seance;
            return $this;
        }

        /**
         * @return datetime
         */
        public function getDate_seance(): datetime {
            return $this->date_seance;
        }
        
        /**
         * @param datetime $date_seance 
         * @return self
         */
        public function setDate_seance(datetime $date_seance): self {
            $this->date_seance = $date_seance;
            return $this;
        }

        /**
         * @return int
         */
        public function getId_matiere(): int {
            return $this->id_matiere;
        }
        
        /**
         * @param int $id_matiere 
         * @return self
         */
        public function setId_matiere(int $id_matiere): self {
            $this->id_matiere = $id_matiere;
            return $this;
        }

        /**
         * @return int
         */
        public function getId_prof(): int {
            return $this->id_prof;
        }
        
        /**
         * @param int $id_prof 
         * @return self
         */
        public function setId_prof(int $id_prof): self {
            $this->id_prof = $id_prof;
            return $this;
        }
        /**
         * @return int
         */
        public function getId_groupe(): int {
            return $this->id_groupe;
        }
        
        /**
         * @param int $id_groupe
         * @return self
         */
        public function setId_groupe(int $id_groupe): self {
            $this->id_groupe = $id_groupe;
            return $this;
        }

}

?>