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
        <div class="contentContainer">
            <?php
                $type = false;                
                if (isset($_POST['product_id'])) {
                    $product_id = $_POST['product_id'];                  
                    // Retrieve product information from the database
                    $product = $conn->getProductById($product_id);
                    if ($product) {
                        $row = mysqli_fetch_assoc($product);           
                    }
                }
                $rating = $conn->getAvarageRating($product_id); 
            ?>
            <div class="productBox">
                <div class="popup">
                    <img src="<?php echo $row["imagePath"]?>" class="productBoxImage" title="<?php echo $row["type"] ?>" alt="<?php echo $row["type"]?>">
                    <div class="productName">
                        <?php echo $row["title"] ?>
                    </div>
                </div>                
                <div class="productCost">
                    <?php echo number_format($row["price"]) . "Ft"?>
                </div>
                <div class="productRating">
                    <?php echo str_repeat(html_entity_decode('&starf;'), round($rating)) . str_repeat(html_entity_decode('&star;'), 5-round($rating)); ?>
                </div>
                <div class="ratingForm">
                    <form method="post" action="productRating.php">
                        <label for="rating">Értékeld a terméket:</label>
                        <select name="rating" id="rating">
                            <option value="1">1 csillag</option>
                            <option value="2">2 csillag</option>
                            <option value="3">3 csillag</option>
                            <option value="4">4 csillag</option>
                            <option value="5">5 csillag</option>
                        </select>
                        <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                        <input type="submit" value="Értékelés">
                        <?php 
                            if (isset($_POST['product_id']) && isset($_POST['rating'])) {
                                $product_id = $_POST['product_id'];
                                $rating = $_POST['rating'];
                                $user_id = $_SESSION["userData"]->getId();
                                
                                // check if the user has already rated the product
                                if (!$conn->existingRating($user_id, $product_id)) {
                                    // insert new rating into the ratings table
                                    $conn->newRating($user_id, $product_id, $rating);
                                    header("Location: shop.php");
                                }else{
                                    echo "Egy terméket csak egyszer lehet értékelni!";
                                }
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!-- footer -->
    <?php include_once "includes/footer.html"; ?>
</body>

</html>