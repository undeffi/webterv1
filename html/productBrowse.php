<?php

include('utility/DBConnection.php');
  
 session_start();

 if (!isset($_SESSION["userData"])) {
    header("Location: login.php");
  } elseif ($_SESSION["userData"]->getPrivLevel() < 2) {
      header("Location: shop.php");
  }

 $conn = new DBConnection();



 ?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Webshop - Termékek módosítása</title>
    <link rel="icon" type="image/x-icon" href="../img/32px-Electronic_circuit.png">
</head>

<body>
    <!-- header -->
    <?php include_once "includes/header.html"; ?>
    <!-- navbar -->
  <?php include_once "includes/navbar.php"; ?>
    <!-- tartalom -->
    <main>
        <div id="scroll-to-top">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})">▲</button>
        </div>

        <div>
            <?php
                $productTypes = $conn->getProductTypes();
                

                echo '<div class="search"> <form style="width = 100%" action="productBrowse.php" method="get">
                <p style="font-size: small"><a style="color: orange" href="adminDashboard.php">Vissza az előző oldalra</a></p>

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
                <input type="text" placeholder="Keresés"';
                
                if (isset($_GET["textFilter"])) {
                    echo 'value="' . $_GET["textFilter"] . '"';
                }

                echo 'name="textFilter" id="textFilter">';
                

            ?>
                <input type="submit" value="Keresés">
                </form>
            </div>
        </div>

    <div class="contentContainer">

    <?php

        $type = false;

        if (isset($_GET["type"]) && is_numeric($_GET["type"]) && $_GET["type"] >= 0) {
            $type = $_GET["type"];
        }

        $textFilter = "";

        if (isset($_GET["textFilter"])) {
            $textFilter = $_GET["textFilter"];
        }

        $products = $conn->getProducts($type, $textFilter);


        while ($row = $products->fetch_assoc()) {

            echo '<div class="productBrowseRow">
            <div>
                <img class="productBrowseImage" src="' . $row["imagePath"] . '" alt="' . $row["type"] . '" title="' . $row["type"] . '">
            </div>
            <div style="height: 100%; width: 15%;">
            ' . $row["title"] . '
            </div>
            <div>
                <div style="height: 33%; width: 100px;">
                ' . 'ertekeles' . '
                </div>
                <div style="height: 33%; width: 100px;">
                ' . $row["price"] . '
                </div>
                <div style="height: 33%; width: 100px;">
                ' . $row["supply"] . '
                </div>
            </div>
            <div style="height: 100%; width: 15%;">
            <a href="productModify.php?productID=' . $row["id"] . '">Módosítás</a>
            </div>';


        }

        ?>
        
    </div>
    </main>
    <!-- footer -->
    <?php include_once "includes/footer.html"; ?>
</body>

</html>