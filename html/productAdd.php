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

        if (isset($_POST["rating"]) && trim($_POST["rating"]) != "") {
            $rating = trim($_POST["rating"]);
            if (is_numeric($rating)) {
                # code...
            } else {
                $err = $err . "Értékelés illegális karaktereket tartalmaz\n";
            }
        } else {
            $err = $err . "Értékelés kitöltetlen\n";
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
            $fileManager->uploadImage("image");
            //$filePath = $fileManager->
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
    <title>Webshop - Termékek kezelése</title>
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
        <a class="navlinks" href="shop.php">Áruház</a>
        <a class="navlinks" href="login.php">Bejelentkezés</a>
        <a class="navlinks" href="register.php">Regisztráció</a>
        <a class="navlinks" href="cart.php">Kosár</a>
        <a class="navlinks" href="profile.php">Profil</a>
        <a class="navlinks" href="infos.php">Kapcsolat</a>
        <a id="active" class="navlinks" href="adminDashboard.php">Dashboard</a>
    </nav>
    <!-- tartalom -->
    <main>
        <div id="scroll-to-top">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})">▲</button>
        </div>
        <div id="formbox">
            <form method="post" action="productAdd.php" enctype="multipart/form-data"> <!-- action="login"-->
                <label class="formname">Új termék</label>
                <div class="forms">
                    <label for="pTitle">Leírás</title>
                    <textarea id="pTitle" name="pTitle" cols="30" rows="10" maxlength="90" style="resize:none"></textarea>
                    <label for="type">Típus</label>
                    <select id="type" name="type">
                        <?php
                            while($row = $productTypes->fetch_assoc()) {
                                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                            }
                        ?>
                    </select>
                    <label for="price">Ár</label>
                    <input type="text" name="price" id="price">
                    <label for="rating">Értékelés</label>
                    <select name="rating" id="rating">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                    </select>
                    <label for="supply">Készleten</label>
                    <input type="number" name="supply" id="supply">
                    <label for="image">Kép</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    <input type="file" name="image" id="image">
                    <input type="submit" value="Termék hozzáadása">
                    <span class="error"><?php echo $err ?></span>

                </div>
            </form>
        </div>
    </main>
</body>