<?php

    class UserData {
        private $id;
        private $fname;
        private $lname;
        private $email;
        private $passhash;
        private $privLevel;

        public function __construct($id, $fname, $lname, $email, $passhash, $privLevel)
        {
            $this->id = $id;
            $this->fname = $fname;
            $this->lname = $lname;
            $this->email = $email;
            $this->passhash = $passhash;
            $this->privLevel = $privLevel;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getFname()
        {
            return $this->fname;
        }

        public function getLname()
        {
            return $this->lname;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function getPasswordHash()
        {
            return $this->passhash;
        }

        public function setPasswordHash($hash)
        {
            $this->passhash = $hash;
        }

        public function getPrivLevel()
        {
            return $this->privLevel;
        }

        

    }

?>