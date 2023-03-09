<?php
include_once("role.php");
    class Identifiant{
        private string $mail;
        private string $pwd;
        private string $role_id;

         /**
         * @param string $mail
         * @param string $pwd
         * @param string $role_id
         */
        public function __construct(string $mail, string $pwd, string $role_id) {
            $this->mail = $mail;
            $this->pwd = $pwd;
            $this->role_id = $role_id;
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
         * @return string
         */
        public function getPwd(): string {
            return $this->pwd;
        }
        
        /**
         * @param string $pwd 
         * @return self
         */
        public function setPwd(string $pwd): self {
            $this->pwd = $pwd;
            return $this;
        }

        /**
         * @return string
         */
        public function getRole(): string {
            return $this->role_id;
        }
        
        /**
         * @param string $role_id
         * @return self
         */
        public function setRole(string $role_id): self {
            $this->role_id = $role_id;
            return $this;
        }
}



?>