<?php

  include('utility/UserData.php');
  
 session_start();

 if (!isset($_SESSION["userData"])) {
   header("Location: login.php");
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Webshop - Kosár</title>
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
  <a class="navlinks" id="active" href="cart.php">Kosár</a>
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
  <div style="text-align: center;"><h1> Majd PHP után :/ </h1></div>
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