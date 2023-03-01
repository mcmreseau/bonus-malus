<?php
    class Professeur {
        private int $id_prof;
        private string $nom_prof;
        private string $prenom_prof;
        private string $mail;

        public function __construct(int $id, string $nom, string $prenom, string $mail){
            $this->id_prof = $id;
            $this->nom_prof = $nom;
            $this->prenom_prof = $prenom;
            $this->mail = $mail;
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
         * @return string
         */
        public function getNom_prof(): string {
            return $this->nom_prof;
        }
        
        /**
         * @param string $nom_prof 
         * @return self
         */
        public function setNom_prof(string $nom_prof): self {
            $this->nom_prof = $nom_prof;
            return $this;
        }

        /**
         * @return string
         */
        public function getPrenom_prof(): string {
            return $this->prenom_prof;
        }
        
        /**
         * @param string $prenom_prof 
         * @return self
         */
        public function setPrenom_prof(string $prenom_prof): self {
            $this->prenom_prof = $prenom_prof;
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
}