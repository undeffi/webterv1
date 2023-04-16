<?php
include('utility/UserData.php');

class DBConnection
{

    private $servername;
    private $username;
    private $password;
    private $dbName;
    private $connection;


    public function __construct()
    {
        $this->servername = "localhost";
        $this->username = "client";
        $this->password = "VeryHardPassword";
        $this->dbName = "ohmic_shop";
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbName);

    }

    public function __destruct()
    {
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
        $passwd = password_hash(trim($passwd), PASSWORD_DEFAULT);


        $stmt = $this->connection->prepare("INSERT INTO `users` (`fname`, `lname`, `email`, `passwd`, `priviligeLevel`) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param("ssssi", $fname, $lname, $email, $passwd, $plevel);
        $stmt->execute();

        return $stmt->errno == 0;
    }

    public function login($email, $passwd)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $stmt = $this->connection->prepare("SELECT `users`.`id`, `users`.`fname`, `users`.`lname`, `users`.`email`, `users`.`passwd`, `users`.`priviligeLevel` FROM `users` WHERE `users`.`email` LIKE ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if (mysqli_num_rows($result) == 1 && password_verify($passwd, $data["passwd"])) {

            return new UserData($data["id"], $data["fname"], $data["lname"], $data["email"], $data["passwd"], $data["priviligeLevel"]);
        }

        return false;
    }

    public function getProductTypes()
    {
        $stmt = $this->connection->prepare("SELECT `producttypes`.*, `producttypes`.`name` FROM `producttypes`;");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function addProduct($title, $price, $type, $imagePath, $supply)
    {

        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
        $type = filter_var($type, FILTER_SANITIZE_NUMBER_INT);
        $imagePath = filter_var($imagePath, FILTER_SANITIZE_STRING);
        $supply = filter_var($supply, FILTER_SANITIZE_NUMBER_INT);


        $stmt = $this->connection->prepare("INSERT INTO `products` (`title`, `price`, `type`, `imagePath`, `supply`) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param("siisi", $title, $price, $type, $imagePath, $supply);
        $stmt->execute();

        $result = $stmt->get_result();

        return $stmt->errno == 0;
    }

    public function getProducts($typeFilter, $textFilter)
    {
        $textFilter = filter_var($textFilter, FILTER_SANITIZE_STRING);

        if ($typeFilter !== false) {
            $stmt = $this->connection->prepare("SELECT `products`.`id`, `products`.`title`, `products`.`price`, `products`.`imagePath`, `products`.`supply`, `producttypes`.`name` AS `type`
                FROM `products` 
                    LEFT JOIN `producttypes` ON `products`.`type` = `producttypes`.`id`
                    WHERE `producttypes`.`id` = ? AND `products`.`title` LIKE Concat('%', ?, '%') 
                    ORDER BY `products`.`type`;");
            $stmt->bind_param("is", $typeFilter, $textFilter);
        } else {
            $stmt = $this->connection->prepare("SELECT `products`.`id`, `products`.`title`, `products`.`price`, `products`.`imagePath`, `products`.`supply`, `producttypes`.`name` AS `type`
                FROM `products` 
                    LEFT JOIN `producttypes` ON `products`.`type` = `producttypes`.`id`
                    WHERE `products`.`title` LIKE Concat('%', ?, '%') 
                    ORDER BY `products`.`type`;");
            $stmt->bind_param("s", $textFilter);
        }

        $stmt->execute();

        return $stmt->get_result();

    }

    public function updateProduct($title, $price, $type, $imagePath, $supply)
    {
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
        $type = filter_var($type, FILTER_SANITIZE_NUMBER_INT);
        $supply = filter_var($supply, FILTER_SANITIZE_NUMBER_INT);
        if ($imagePath === false) {
            $imagePath = $_SESSION["productInfo"]["imagePath"];
        } else {
            $imagePath = filter_var($imagePath, FILTER_SANITIZE_STRING);
        }

        $stmt = $this->connection->prepare("UPDATE `products` 
                SET  `title` = ?, `price` = ?, `type` = ?, `supply` = ?, `imagePath` = ?
                WHERE `id` = ?;");

        $id = $_SESSION["productInfo"]["id"];
        $stmt->bind_param("siiisi", $title, $price, $type, $supply, $imagePath, $id);

        $stmt->execute();
        unset($_SESSION["productInfo"]);

    }

    public function getProductByID($id)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $stmt = $this->connection->prepare("SELECT `products`.`id`, `products`.`title`, `products`.`price`, `products`.`imagePath`, `products`.`supply`, `producttypes`.`name` AS `type`
            FROM `products` 
                LEFT JOIN `producttypes` ON `products`.`type` = `producttypes`.`id`
                WHERE `products`.`id` = ? 
                ORDER BY `products`.`type`;");

        $stmt->bind_param("i", $id);

        $stmt->execute();

        return $stmt->get_result();
    }

    public function updateUserInfo($fname, $lname, $email)
    {
        $fname = filter_var($fname, FILTER_SANITIZE_STRING);
        $lname = filter_var($lname, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $user_id = $_SESSION["userData"]->getId();
        $stmt = $this->connection->prepare("UPDATE `users` SET `fname` = ?, `lname` = ?, `email` = ? WHERE `id` = ? ;");
        $stmt->bind_param("sssi", $fname, $lname, $email, $user_id);
        $stmt->execute();

        if ($stmt->errno == 0) {
            $_SESSION["userData"] = new UserData($_SESSION["userData"]->getId(), $fname, $lname, $email, $_SESSION["userData"]->getPasswordHash(), $_SESSION["userData"]->getPrivLevel());
        }

        return $stmt->errno == 0;
    }

    public function updatePassword($passwd)
    {
        //echo $passwd . "<br>";
        $passwd = password_hash(trim($passwd), PASSWORD_DEFAULT);
        $id = $_SESSION["userData"]->getId();


        $stmt = $this->connection->prepare("UPDATE `users` SET passwd = ? WHERE `id` = ? ;");
        $stmt->bind_param("si", $passwd, $id);
        $stmt->execute();

        $_SESSION["userData"]->setPasswordHash($passwd);

        return $stmt->errno == 0;
    }

    public function getUsers()
    {
        $id = $_SESSION["userData"]->getId();
        $stmt = $this->connection->prepare("SELECT * FROM `users` WHERE `id` != ? ;");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        //echo $stmt->fullQuery . "<br>";

        if ($stmt->errno == 0) {
            return $stmt->get_result();
        }

        return false;
    }

    public function deleteUser($id)
    {
        $order_id = $this->getOrderByUserID($id);
        while($row = $order_id->fetch_assoc()){
            $this->deleteOrder($row['order_id']);
        }
        $stmt = $this->connection->prepare("DELETE FROM `users` WHERE `id` = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function addOrder($total_price, $postcode, $city, $line1, $line2)
    {
        $user_id = $_SESSION["userData"]->getId();
        $stmt = $this->connection->prepare("INSERT INTO `orders` (`user_id`, `total_price`)VALUES (?, ?);");
        $stmt->bind_param("ii", $user_id, $total_price);
        $stmt->execute();

        $order_id = $stmt->insert_id;

        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['id'];
            $stmt = $this->connection->prepare("SELECT title FROM products WHERE id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $product_title = $row['title'];
            $quantity = $item['quantity'];
            $stmt = $this->connection->prepare("INSERT INTO order_items (order_id, product_id, product_title, quantity) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iisi", $order_id, $product_id, $product_title, $quantity);
            $stmt->execute();
        }

        $stmt = $this->connection->prepare("INSERT INTO order_shipping (order_id, postcode, city, line1, line2) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $order_id, $postcode, $city, $line1, $line2);
        $stmt->execute();
    }

    public function getOrderByUserID($user_id){
        $stmt = $this->connection->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        if ($stmt) {
            return $stmt->get_result();
        }
    }
    public function getOrderAdmin()
    {
        $stmt = $this->connection->prepare("SELECT * FROM `orders`;");
        $stmt->execute();

        if ($stmt) {
            return $stmt->get_result();
        }
        return "Nincs rendelés!";
    }

    public function getShipping($order_id){
        $stmt = $this->connection->prepare("SELECT * FROM `order_shipping` WHERE `order_id` = ?;");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        if ($stmt) {
            return $stmt->get_result();
        }
        return "Nincs rendelés!";
    }

    public function getOrderItemsByOrderId($order_id)
    {
        if (!is_numeric($order_id)) {
            return false;
        }

        $stmt = $this->connection->prepare("SELECT * FROM `order_items` WHERE `order_id` = ? ORDER BY `order_id`;");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getUserById($user_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM `users` WHERE `id` = ? ;");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        if ($stmt) {
            return $stmt->get_result();
        }

        return "Nem létezik ilyen felhasználó!";
    }

    public function deleteOrder($order_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM `order_items` WHERE `order_id` = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $stmt = $this->connection->prepare("DELETE FROM `order_shipping` WHERE `order_id` = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $stmt = $this->connection->prepare("DELETE FROM `orders` WHERE `order_id` = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
    }

    public function deleteOrderProduct($product_id, $order_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM `order_items` WHERE `order_id` = ? AND `product_id` = ?");
        $stmt->bind_param("ii", $order_id, $product_id);
        $stmt->execute();
    }

    public function orderPriceUpdate($order_id, $product_id)
    {
        $stmt = $this->connection->prepare("SELECT total_price FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $order = $stmt->get_result()->fetch_assoc();
        $price = $order['total_price'];

        $product = $this->getProductByID($product_id)->fetch_assoc();
        $productPrice = $product['price'];

        $price -= $productPrice;

        $stmt = $this->connection->prepare("UPDATE `orders` SET `total_price` = ? WHERE `order_id` = ? ;");
        $stmt->bind_param("ii", $price, $order_id);
        $stmt->execute();
    }

    public function existingRating($user_id, $product_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM ratings WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $rating = $stmt->get_result();
        if ($rating->num_rows === 0) {
            return false;
        }
        return true;
    }

    public function newRating($user_id, $product_id, $rating)
    {
        $stmt = $this->connection->prepare("INSERT INTO ratings (user_id, product_id, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $rating);
        $stmt->execute();
    }

    public function updateRating($user_id, $product_id, $rating){
        $stmt = $this->connection->prepare("UPDATE `ratings` SET `rating` = ? WHERE `user_id` = ? AND `product_id` = ?;");
        $stmt->bind_param("iii", $rating, $user_id, $product_id);
        $stmt->execute();

        return $stmt->errno == 0;
    }

    public function getAvarageRating($product_id)
    {
        $stmt = $this->connection->prepare("SELECT rating FROM ratings WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $rating = $stmt->get_result();
        $i = 0;
        if ($rating->num_rows === 0) {
            return 0;
        } else {
            while ($rating_row = $rating->fetch_assoc()) {
                $i += $rating_row['rating'];

            }
            return $i / $rating->num_rows;
        }
    }
}

?>

