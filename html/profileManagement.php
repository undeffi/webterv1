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
    <div class="adminContainer">
    <?php $users = $conn->getUsers();
        // $users = $conn->getUsers();


        // while ($row = $users->fetch_assoc()) {
        //     $content = '<div style="width: 100%">';
        //     $content .= '<p>Azonosító: ' . $row["id"] . ' Vezetéknév: ' .
        //     $row["fname"] . ' Keresztnév: ' . $row["lname"] . ' Email cím: ' . $row["email"] . '</p>';
        //     $content .= '<a href="userDelete.php?id=' . $row["id"] . '">Törlés</a></div>';
        //     echo $content;
        // }
?>
        <table class="assignment">
        <thead>
          <tr>
              <th>Azonosító (ID)</th>
              <th>Vezetéknév</th>
              <th>Keresztnév</th>
              <th>Email cím</th>
              <th><a style="color: orange" href="adminDashboard.php">Vissza az előző oldalra</a></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $total = 0;
            while ($row = $users->fetch_assoc()) {?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['fname']; ?></td>
                <td><?php echo $row['lname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                <?php echo '<a style="color:red"href="userDelete.php?id=' . $row["id"] . '">Törlés</a></div>'; ?>
                </td>
              </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    </main>
</body>
</html>