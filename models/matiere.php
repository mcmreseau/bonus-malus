<?php
 class Matiere {
    private int $id_matiere;
    private string $intitule;

    /**
     *@param int $id
     *@param string $intitule
     */

    public function __construct(int $id,string $intitule){
        $this->id_matiere = $id;
        $this->intitule = $intitule;
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
         * @return string
         */
        public function getIntitule(): string {
            return $this->intitule;
        }
        
        /**
         * @param string $intitule 
         * @return self
         */
        public function setIntitule(string $intitule): self {
            $this->intitule = $intitule;
            return $this;
        }
 }