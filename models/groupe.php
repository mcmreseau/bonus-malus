<?php

    class Groupe {
        private int $id_groupe;
        private string $nom_groupe;

        public function __construct(int $id_groupe, string $nom_groupe){
            $this->id_groupe = $id_groupe;
            $this->nom_groupe = $nom_groupe;
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

        /**
         * @return string
         */
        public function getNom_groupe(): string {
            return $this->nom_groupe;
        }
        
        /**
         * @param string $nom_groupe 
         * @return self
         */
        public function setNom_groupe(string $nom_groupe): self {
            $this->nom_groupe = $nom_groupe;
            return $this;
        }
}
