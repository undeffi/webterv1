<?php
  include('utility/dbConnection.php');
  $conn = new DBConnection();
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
    <table class="assignment">
      <tr>
        <td colspan="2" >Név:</td>
        <td colspan="2" ><?php echo $_SESSION["userData"]->getFname() . " " . $_SESSION["userData"]->getLname() ?> </td>
      </tr>
      <tr>
        <td colspan="2" >Email cím:</td>
        <td colspan="2" ><?php echo $_SESSION["userData"]->getEmail()?></td>
      </tr>
      <tr>
        <td><a class='options' href='userInfoUpdate.php'>Adatfrissítés</a></td>
        <td><a class='options' href='changePassword.php'>Jelszó megváltoztatása</a></td>
        <td><a class='options' href='userDelete.php'>Fiók deaktiválása</a></td>
        <td><a class='options' style='color:red;' href='logout.php'>Kilépés</a></td>
        
      </tr>
    </table>

    <table class="assignment">
      <h1><strong>Rendeléseim<strong></h1>
      <thead>
        <tr>
          <th>Termék megnevezése:</th>
          <th>Darab:</th>
        </tr>
      </thead>
      <tbody>
        <?php $orders = $conn->getOrder() ?>
      </tbody>    
    </table>
  </div>
</main>
<!-- footer -->
<?php include_once "includes/footer.html"; ?>
</body>
</html>