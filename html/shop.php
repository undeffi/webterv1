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
<?php include_once "includes/header.html"; ?>
<!-- navbar -->
<?php include_once "includes/navbar.php"; ?>
<!-- tartalom -->
<main>
    <div id="scroll-to-top">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})">▲</button>
    </div>

    <div class="search">
        <?php
        $productTypes = $conn->getProductTypes();

        echo '<form style="width: 100%" action="shop.php" method="get">
                <label for="type">Típus</label>
                <select name="type" id="type">
                <option value="false">Válassz</option>';

        while ($row = $productTypes->fetch_assoc()) {

            $option = '<option ';
            if (isset($_GET["type"]) && $row["id"] == $_GET["type"]) {
                $option = $option . 'selected="selected" ';
            }
            echo $option . 'value="' . $row["id"] . '">' . $row["name"] . '</option>' . "\n";
        }

        echo '</select>
                <input type="text" placeholder="Keresés" ';

        if (isset($_GET["textFilter"])) {
            echo 'value="' . $_GET["textFilter"] . '"';
        }

        echo 'name="textFilter" id="textFilter">';


        ?>
        <input type="submit" value="Keresés">
        </form>
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
            $rating = $conn->getAvarageRating($row["id"]);
            echo '<div class="productBox">
                    <div>
                        
                            <form class="popup" method="post" action="productRating.php">
                            <input type="hidden" name="product_id" value="' . $row["id"] . '">
                            

                            <button class="productButton" type="submit">
                                <img src="' . $row["imagePath"] . '" class="productBoxImage" title="' . $row["type"] . '" alt="' . $row["type"] . '">
                                
                            </button>
                            <div class="productName">
                                    ' . $row["title"] . '
                                </div>
                        </form>                           
                        
                
                    </div>
                    <div>
                        <div class="productCost">
                        ' . number_format($row["price"], 0, ',', ' ') . "Ft" . '
                        </div>
                        <div class="productRating">
                        ' . str_repeat(html_entity_decode('&starf;'), round($rating)) . str_repeat(html_entity_decode('&star;'), 5 - round($rating)) . ' 
                        </div>
                    </div>
                    <div>
                        <form class="kosarba" method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="' . $row["id"] . '">
                            <input type="number" name="quantity" value="1" min="1">
                            <button type="submit">
                                <img src="../img/shopping-cart-icon.png" alt="Kosárba">
                            </button>
                        </form>
                    </div>
                    </div>';
        }
        ?>
    </div>
</main>
<!-- footer -->
<?php include_once "includes/footer.html"; ?>
</body>

</html>