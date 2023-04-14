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
        <?php $orders = $conn->getOrderAdmin();?>
        <table class="assignment">
            <thead>
            <tr>
                <th>Rendelés azonosítója (ID)</th>
                <th>Felhasználó neve</th>
                <th>Rendelési cím</th>
                <th>Rendelés összege</th>
                <th colspan="2"><a style="color: orange" href="adminDashboard.php">Vissza az előző oldalra</a></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            while ($row = $orders->fetch_assoc()) {
                    $shipping = $conn->getShipping($row['order_id']);
                    $shipping = $shipping->fetch_assoc();
                    $user = $conn->getUserById($row['user_id']);
                    $user = $user->fetch_assoc();
                ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $user['fname'] ." ". $user['lname']; ?></td>
                    <td><?php echo $shipping['postcode'] ." ". $shipping['city'] ." ". $shipping['line1'] ." ". $shipping['line2']; ?></td>
                    <td><?php echo $row['total_price']; ?> Ft</td>
                    <td>
                        <?php echo '<a href="orderItems.php?order_id=' . $row["order_id"] . '">Rendelés tartalma</a></div>'; ?>
                    </td>
                    <td>
                        <?php echo '<a style="color:red" href="orderDelete.php?order_id=' . $row["order_id"] . '">Törlés</a></div>'; ?>
                    </td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>