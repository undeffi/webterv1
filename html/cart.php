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
  <?php
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
      
        // Retrieve product information from the database
        $product = $conn->getProductById($product_id);
        if ($product) {
            $row = mysqli_fetch_assoc($product);
            if (isset($_SESSION['cart'][$product_id])) {
              // Update the quantity of the existing item
              $_SESSION['cart'][$product_id]['quantity'] += $quantity;
          } else {
              // Add a new item to the cart
              $_SESSION['cart'][$product_id] = array(
                'id' => $product_id,
                'title' => $row['title'],
                'price' => $row['price'],
                'quantity' => $quantity,
                'imagePath' => $row['imagePath']
            );
          }

        }
    }
?>

<!-- cart content -->
<div class="cart-content">
  <table>
    <thead>
      <tr>
        <th>Termék neve</th>
        <th>Ár</th>
        <th>Mennyiség</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;?>
          <tr>
            <td><?php echo $item['title']; ?></td>
            <td><?php echo number_format($item['price'], 0, '.', ' '); ?> Ft</td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo number_format($subtotal, 0, '.', ' '); ?> Ft</td>
            <td>
              <form style="background: rgb(174, 174, 174);" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                <button type="submit" name="remove_item">Eltávolítás</button>
              </form>
            </td>
          </tr>
      <?php } ?>
      <tr>
        <td colspan="3" class="text-right"> <strong>Összesen: </strong></td>
        <td colspan="2"><strong><?php echo number_format($total, 0, '.', ' '); ?> Ft </strong></td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
if (isset($_POST['remove_item'])) {
  $product_id = $_POST['product_id'];
  unset($_SESSION['cart'][$product_id]);
  header("Location: cart.php");
}
?>
</main>
<!-- footer -->
<?php include_once "includes/footer.html"; ?>
</body>
</html>