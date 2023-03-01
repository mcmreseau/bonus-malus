CREATE TABLE Bonus (
id_bonus INTEGER AUTO_INCREMENT,
note float not null,
date_seance Datetime ,
id_etudiant integer NOT NULL REFERENCES Etudiant(id_etudiant),
id_seance INTEGER NOT NULL REFERENCES Seance(id_seance),

constraint PK_ID primary key (id_bonus)
);

<?php 
    
    class Bonus{
        private int $id_bonus;
        private float $note;
        private datetime $date_seance;
        private int $id_etudiant;
        private int $id_seance;
        
        /** 
         * @param int $id_bonus
         * @param float $note
         * @param datetime $date_seance
         * @param int $id_etudiant
         * @param int $id_seance
         */
        public function __construct(int $id_bonus, float $note, datetime $date_seance, int $id_etudiant, int $id_seance) {
            $this->id_bonus = $id_bonus;
            $this->note = $note;
            $this->date_seance = $date_seance;
            $this->id_etudiant = $id_etudiant;
            $this->id_seance = $id_seance;
        }

        /**
         * @return int
         */
        public function getId_bonus(): int {
            return $this->id_bonus;
        }
        
        /**
         * @param int $id_bonus 
         * @return self
         */
        public function setId_bonus(int $id_bonus): self {
            $this->id_bonus = $id_bonus;
            return $this;
        }

        /**
         * @return float
         */
        public function getNote(): float {
            return $this->note;
        }
        
        /**
         * @param int $note 
         * @return self
         */
        public function setNote(int $note): self {
            $this->note = $note;
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
        public function getId_etudiant(): int {
            return $this->id_etudiant;
        }
        
        /**
         * @param int $id_etudiant 
         * @return self
         */
        public function setId_etudiant(int $id_etudiant): self {
            $this->id_etudiant = $id_etudiant;
            return $this;
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
}

?>