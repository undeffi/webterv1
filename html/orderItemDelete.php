<?php
include('utility/DBConnection.php');
$conn = new DBConnection();
session_start();

if (!isset($_SESSION["userData"])) {
    header("Location: login.php");
}
if (isset($_GET["product_id"]) && $_SESSION["userData"]->getPrivLevel() < 2) {
    header("Location: profile.php");
}

if (!$_GET["product_id"] || !$_GET['order_id']) {
    header("Location: orderItems.php");
} else {
    $conn->deleteOrderProduct($_GET["product_id"], $_GET["order_id"]);
    $conn->orderPriceUpdate($_GET["order_id"], $_GET["product_id"]);
    header("Location: orderItems.php");
}
?>