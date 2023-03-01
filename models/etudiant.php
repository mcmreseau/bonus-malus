<?php
    class Etudiant {
        private int $id_etudiant;
        private string $nom_etudiant;
        private string $mail;
        private int $id_groupe;

        public function __construct(int $id_etudiant, string $nom_etudiant, string $mail_etudiant, int $id_groupe) {
            $this->id_etudiant = $id_etudiant;
            $this->nom_etudiant = $nom_etudiant;
            $this->mail = $mail_etudiant;
            $this->id_groupe = $id_groupe;
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
         * @return string
         */
        public function getNom_etudiant(): string {
            return $this->nom_etudiant;
        }
        
        /**
         * @param string $nom_etudiant 
         * @return self
         */
        public function setNom_etudiant(string $nom_etudiant): self {
            $this->nom_etudiant = $nom_etudiant;
            return $this;
        }

        /**
         * @return string
         */
        public function getMail(): string {
            return $this->mail;
        }
        
        /**
         * @param string $mail 
         * @return self
         */
        public function setMail(string $mail): self {
            $this->mail = $mail;
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

