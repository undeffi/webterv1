<?php

    class dbConnection{

        private $servername;
        private $username;
        private $password;
        private $dbName;
        private $connection;


        public function __construct() {
            $this->servername = "localhost";
            $this->username = "client";
            $this->password = "VeryHardPassword";
            $this->dbName = "ohmic_shop";
            $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbName);

        }

        public function __destruct(){
            $this->connection->close();
        }

        public function doesUserExist($email)
        {
            $sql = "SELECT 1
            FROM `users`
            WHERE `users`.`email` = '$email';";
            
            $result = $this->connection->query($sql);

            return mysqli_num_rows($result) > 0;
        }

        public function addUser($fname, $lname, $email, $passwd, $plevel)
        {

            $passwd = password_hash($passwd, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`fname`, `lname`, `email`, `passwd`, `priviligeLevel`) VALUES ('$fname', '$lname', '$email', '$passwd', '$plevel');";
            $this->connection->query($sql);
        }
    }

?>