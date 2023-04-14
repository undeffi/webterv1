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
    <?php
    $order_id = $_GET['order_id'];
    if (!$_GET['order_id']) {
        header("Location: orderManagement.php");
    } else {
        $orderInfo = $conn->getOrderItemsByOrderId($_GET['order_id']);
        if (!$orderInfo) {
            header("Location: orderManagement.php");
        }
    } ?>
</head>

<body>
<!-- header -->
<?php include_once "includes/header.html"; ?>
<!-- navbar -->
<?php include_once "includes/navbar.php"; ?>
<!-- tartalom -->
<main>
    <div class="adminContainer">
        <table class="assignment">
            <thead>
            <tr>
                <th colspan="2">Termék</th>
                <th>Rendelt mennyiség</th>
                <th><a style="color: orange" href="orderManagement.php">Vissza az előző oldalra</a></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = $orderInfo->fetch_assoc()) {
                ?>
                <tr>
                    <td colspan="2"><?php echo $row['product_title'] ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>
                        <?php echo '<a style="color:red" href="orderItemDelete.php?product_id=' . $row["product_id"] . '&order_id=' . $_GET['order_id'] . '">Termék törlése</a>'; ?>                    </td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>