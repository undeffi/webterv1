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
<?php include_once "includes/header.html"; ?>
<!-- navbar -->
  <?php include_once "includes/navbar.php"; ?>
<!-- tartalom -->
<main>
  <div id="scroll-to-top">
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})">▲</button>
  </div>
  <div style="text-align: center;"><h1> Majd PHP után :/ </h1></div>
</main>
<!-- footer -->
<?php include_once "includes/footer.html"; ?>
</body>
</html>