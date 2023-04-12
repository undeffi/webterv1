<?php

    include('utility/DBConnection.php');

    session_start();

    if (!isset($_SESSION["userData"])) {
    header("Location: login.php");
  } elseif ($_SESSION["userData"]->getPrivLevel() < 2) {
      header("Location: profile.php");
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
    <title>Webshop - Termékek kezelése</title>
    <link rel="icon" type="image/x-icon" href="../img/32px-Electronic_circuit.png">
</head>

<body>
    <!-- header -->
    <?php include_once "includes/header.html"; ?>
    <!-- navbar -->
    <?php include_once "includes/navbar.php"; ?>
    <!-- tartalom -->
    <main>
    <div class="adminPage">
        <a class="navlinks" href="productAdd.php">Termékek hozzáadása</a>
        <a class="navlinks" href="productBrowse.php">Termékek módosítása</a>
        <a class="navlinks" href="profileManagement.php">Felhasználók kezelése</a>
        <a class="navlinks" href="orderManagement.php">Rendelések kezelése</a>
    </div>
    </main>
</body>
</html>