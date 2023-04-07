<?php
    include('utility/DBConnection.php');
    include('utility/FileManager.php');

    session_start();
    $conn = new DBConnection();

    $fileManager = new FileManager();
    //$fileManager->path();

    $productTypes = $conn->getProductTypes();

    if (!isset($_SESSION["userData"])) {
        header("Location: login.php");
    } elseif ($_SESSION["userData"]->getPrivLevel() < 2) {
        header("Location: shop.php");
    }

    $err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pTitle = $type = $price = $rating = $supply = "";

        if (isset($_POST["pTitle"]) && trim($_POST["pTitle"]) != "") {
            $pTitle = trim($_POST["pTitle"]);
            if (filter_var($pTitle, FILTER_SANITIZE_STRING)) {
                # code...
            } else {
                $err = $err . "Termékcím illegális karaktereket tartalmaz\n";
            }
        } else {
            $err = $err . "Termékcím kitöltetlen\n";
        }

        if (isset($_POST["type"]) && is_numeric($_POST["type"])) {
            $type = $_POST["type"];


        } else {
            $err = $err . "Típus kitöltetlen\n";
        }

        if (isset($_POST["price"]) && trim($_POST["price"]) != "") {
            $price = trim($_POST["price"]);
            if (is_numeric($price)) {
                # code...
            } else {
                $err = $err . "Ár betűket tartalmaz\n";
            }
        } else {
            $err = $err . "Ár kitöltetlen\n";
        }


        if (isset($_POST["supply"]) && trim($_POST["supply"]) != "") {
            $supply = trim($_POST["supply"]);
            if (is_numeric($supply)) {
                # code...
            } else {
                $err = $err . "Készlet illegális karaktereket tartalmaz\n";
            }
        } else {
            $err = $err . "Készlet kitöltetlen\n";
        }

        if (isset($_FILES["image"])) {
            //echo $_FILES["image"]["tmp_name"];
        } else {
            $err = $err . "Nincs kép\n";
        }

        if (empty($err)) {
            $imagePath = $fileManager->uploadImage("image");
            
            if ($fileManager->err) {
                $err . $fileManager->err;
            } else {
                $conn->addProduct($pTitle, $price, $type, $imagePath, $supply);
            }
        }
    
    }
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Webshop - Termékek hozzáadása</title>
    <link rel="icon" type="image/x-icon" href="../img/32px-Electronic_circuit.png">
</head>

<body>
    <!-- header -->
    <?php include_once "includes/header.html"; ?>
    <!-- navbar -->
    <?php include_once "includes/navbar.php"; ?>
    <!-- tartalom -->
    <main>
        <div id="formbox">
            <form method="post" action="productAdd.php" enctype="multipart/form-data"> <!-- action="login"-->
                <label class="formname">Új termék</label>
                <div class="forms">
                    <label for="pTitle">Leírás</title><br>
                    <textarea id="pTitle" name="pTitle" cols="30" rows="10" maxlength="90" style="resize:none"></textarea><br>
                    <label for="type">Típus</label><br>
                    <select id="type" name="type">
                        <?php
                            while($row = $productTypes->fetch_assoc()) {
                                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                            }
                        ?>
                    </select><br>
                    <label for="price">Ár</label><br>
                    <input type="text" name="price" id="price"><br>
                    <label for="supply">Készleten</label><br>
                    <input type="number" name="supply" id="supply"><br>
                    <label for="image">Kép</label><br>
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" /><br>
                    <input type="file" name="image" id="image"><br>
                    <input type="submit" value="Termék hozzáadása">
                    <span class="error"><?php echo $err ?></span>

                </div>
            </form>
        </div>
    </main>
</body>