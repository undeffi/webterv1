<?php

include('utility/DBConnection.php');
  
 session_start();

 $conn = new DBConnection();

 ?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Webshop - Áruház</title>
    <link rel="icon" type="image/x-icon" href="../img/32px-Electronic_circuit.png">
</head>

<body>
    <!-- header -->
    <header id="header">
        <h1> Ohmic Shop </h1>
    </header>
    <!-- navbar -->
    <nav class="navbar">
        <a class="navlinks" href="index.php">Kezdőlap</a>
        <a class="navlinks" id="active" href="shop.php">Áruház</a>
        <a class="navlinks" href="login.php">Bejelentkezés</a>
        <a class="navlinks" href="register.php">Regisztráció</a>
        <a class="navlinks" href="cart.php">Kosár</a>
        <a class="navlinks" href="profile.php">Profil</a>
        <a class="navlinks" href="infos.php">Kapcsolat</a>
        <?php if (isset($_SESSION["userData"]) && $_SESSION["userData"]->getPrivLevel() > 1) {
        echo "<a class='navlinks' href='adminDashboard.php'>Dashboard</a>";
  }  ?>
    </nav>
    <!-- tartalom -->
    <main>
        <div id="scroll-to-top">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})">▲</button>
        </div>

        <div>
            <?php
                $productTypes = $conn->getProductTypes();

                echo '<form style="width = 100%" action="shop.php" method="get">
                <label for="type">Típus</label>
                <select name="type" id="type">
                <option value="false">Válassz</option>';

                while ($row = $productTypes->fetch_assoc()) {

                    $option = '<option ';
                    if (isset($_GET["type"]) && $row["id"] == $_GET["type"]) {
                        $option = $option . 'selected="selected" ';
                    }
                    echo $option .  'value="' . $row["id"] . '">' . $row["name"] . '</option>' . "\n";
                }
                
                echo '</select>
                <input type="submit" value="Keresés">
                </form>';

            ?>
        </div>

    <div class="contentContainer">
        
        <?php
            
                $type = false;

                if (isset($_GET["type"]) && is_numeric($_GET["type"]) && $_GET["type"] >= 0) {
                    $type = $_GET["type"];
                }

                $products = $conn->getProducts($type);

                while ($row = $products->fetch_assoc()) {
                echo '<div class="productBox">
                <div>
                    <a href="cart.html">
                        <img src="' . $row["imagePath"] . '" class="productBoxImage" title="' . $row["type"] . '" alt="' . $row["type"] . '">
                        <div class="productName">
                        ' . $row["title"] . '
                        </div>
                    </a>

                </div>
                <div>
                    <div class="productCost">
                    ' . number_format($row["price"], 0, ',', ' ') . "Ft" . '
                    </div>
                    <div class="productRating">
                        &starf; &starf; &starf; &starf; &star;
                    </div>
                </div>
                <div>
                    <a class="kosarba" href="cart.html">
                        <div>
                            Kosárba

                        </div>
                        <img src="../img/shopping-cart-icon.png" alt="Bevásárlókocsi">
                    </a>
                </div>
                </div>';
                }
        ?>
        
    </div>
    </main>
    <!-- footer -->
    <footer>
        <div id="right">
            <p>Email cím: ohmic@gmail.com</p>
            <p>Telefonszám: +36301234567</p>
            <p>Ohmic Shop &copy; </p>
        </div>
        <div id="left">
            <p>Hétfő - Péntek: 8:00 - 16:00</p>
            <p>Szombat: 10:00 - 14:00</p>
            <p>Vasárnap: Zárva</p>
        </div>
    </footer>
</body>

</html>