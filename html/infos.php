<?php

  include('utility/UserData.php');
  
 session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Webshop - Kapcsolat</title>
  <link rel="icon" type="image/x-icon" href="../img/32px-Electronic_circuit.png">
</head>
<body>
<!-- header -->
<?php include_once "includes/header.html"; ?>
<!-- navbar -->
  <?php include_once "includes/navbar.php"; ?>
<!-- tartalom -->
<main>
  <div style="text-align: center;"><h3> A weboldal üzemeltetői: </h3>
    <p> Varga András Bendegúz, Sántha Ákos</p>
    Logisztikai központ és iroda: <br>
    6725 Szeged, Tisza Lajos krt. 103. <br> <br>

    <strong>Postacím:</strong> <br>
    6725 Szeged, Tisza Lajos krt. 103.<br>
    <strong>Adószám:</strong>
    12345678-9-01<br>
    <strong>Cégjegyzékszám:</strong>
    12-34-5678901<br>
    <strong>Email cím:</strong>
    <a id="email" href="mailto::ohmic@gmail.com">ohmic@gmail.com</a>
  </div>
</main>
<!-- footer -->
<?php include_once "includes/footer.html"; ?>
</body>
</html>