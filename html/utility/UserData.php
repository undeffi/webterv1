<?php

    class UserData {
        private $id;
        private $fname;
        private $lname;
        private $email;
        private $privLevel;

        public function __construct($id, $fname, $lname, $email, $privLevel)
        {
            $this->id = $id;
            $this->fname = $fname;
            $this->lname = $lname;
            $this->email = $email;
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

        public function getPrivLevel()
        {
            return $this->privLevel;
        }

    }

?>