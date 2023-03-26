<?php
    include('utility/UserData.php');

    class DBConnection{

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

            $fname = filter_var($fname, FILTER_SANITIZE_STRING);
            $lname = filter_var($lname, FILTER_SANITIZE_STRING);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $passwd = password_hash($passwd . $email, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (`fname`, `lname`, `email`, `passwd`, `priviligeLevel`) VALUES ('$fname', '$lname', '$email', '$passwd', '$plevel');";
            $this->connection->query($sql);
        }

        public function login($email, $passwd)
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            $sql = "SELECT `users`.`id`, `users`.`fname`, `users`.`lname`, `users`.`email`, `users`.`passwd`, `users`.`priviligeLevel`
            FROM `users`
            WHERE `users`.`email` LIKE '$email'";

            $result = $this->connection->query($sql);
            $data = $result->fetch_assoc();

            if (mysqli_num_rows($result) > 0 && password_verify($passwd . $email, $data["passwd"])) {

                return new UserData($data["id"], $data["fname"], $data["lname"], $data["email"], $data["priviligeLevel"]);
            }
         
            return false;
        }
    }

?>