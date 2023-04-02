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
  <title>Webshop - Profilom</title>
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
  <div style="text-align: center;">
    <?php
      echo "<table>
      <tr>
        <td>Név:</td>
        <td>" . $_SESSION["userData"]->getFname() . " " . $_SESSION["userData"]->getLname() . "</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
      
      </table>"
    ?>
    <a href="logout.php">Kijelentkezés</a>
  </div>
</main>
<!-- footer -->
<?php include_once "includes/footer.html"; ?>
</body>
</html>