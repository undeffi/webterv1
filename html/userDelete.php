<?php
  include('utility/DBConnection.php');

  session_start();

  if (!isset($_SESSION["userData"])) {
    header("Location: login.php");
  }
// || ($_SESSION["userData"]->getPrivLevel() < 2 && (!isset($_GET["id"]) || $_GET["id"] !== $_SESSION["userData"]->getId()))
    $pwErr = "";
    $err = false;  

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["pw"])) {
            if (password_verify(trim($_POST["pw"]), $_SESSION["userData"]->getPasswordHash())) {
                
            } else {
                $pwErr = "Hibás jelszó";
            }
        } else {
            $pwErr = "Ezt a mezőt kötelező kitölteni!";
            $err = true;
        }


        $conn = new DBConnection();

        if (!$err) {
            if ($_SESSION["userData"]->getPrivLevel() < 2) {
                $conn->deleteUser($_SESSION["userData"]->getId());
                header("Location: logout.php");
            } else if(is_numeric($_GET["id"]) && $_GET["id"] != $_SESSION["userData"]->getId()) {
                $conn->deleteUser($_GET["id"]);
            }
            header("Location: adminDashboard.php");
        }
    }

  

  if (!isset($_GET["id"]) && $_SESSION["userData"]->getPrivLevel() < 2) {
    # code...
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Webshop - Fiók törlése</title>
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
  <div id="formbox">
    <?php
        $content = '<form method="post" action="userDelete.php';

        if (isset($_GET["id"])) {
            $content .= '?id=' . $_GET["id"];
        }
        echo $content . '">';
    ?>
            
                <label class="formname">Fiók törlése</label>
                <div class="forms">
                    <label for="pw" class="required-label">Jelszó:</label><br>
                    <input type="password" id="pw" name="pw"  placeholder="Jelszó" required><br>
                    <span class="error"><?php echo $pwErr; ?></span>
                    <input type="submit" value="Megerősítés">
                    <a class="notyet" href="profile.php">Vissza a profilomhoz</a>
                </div>
            </form>
        </div>
</main>
<!-- footer -->
<?php include_once "includes/footer.html"; ?>
</body>
</html>