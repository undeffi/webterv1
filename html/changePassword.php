<?php
    include('utility/DBConnection.php');
    session_start();
    

    if (!isset($_SESSION["userData"])) {
    header("Location: login.php");
    }

    
    $pwErr = $pw1Err = $pw2Err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oldPass = $pass = "";

        $err = false;

        $conn = new DBConnection();

        
        

        if (isset($_POST["pw"]) && trim($_POST["pw"]) != "") {
            $oldPass = trim($_POST["pw"]);
            if (password_verify($oldPass, $_SESSION["userData"]->getPasswordHash())) {
                # code...
            } else {
            $pwErr = "Hibás jelszó.<br>";
            $err = true;
        }

            
        } else {
            $pwErr = "Ezt a mezőt kötelező kitölteni";
            $err = true;
        }


        if (isset($_POST["pw1"]) && trim($_POST["pw1"]) != "") {
            $_POST["pw1"] = trim($_POST["pw1"]);
            if (strlen($_POST["pw1"]) >= 8) {
                if (strlen($_POST["pw1"]) <= 50) {
                    if (filter_var($_POST["pw1"], FILTER_SANITIZE_STRING)) {
                        $pass = $_POST["pw1"];
                    } else {
                        $pw1Err = "Érvénytelen jelszó. Megengedett karakterek: aA-zZ 0-9 -_!%/=()<>#" . "<br>";
                        $err = true;
                    }
                } else {
                    $pw1Err = "A maximum hossz 50 karakter";
                    $err = true;
                }
            } else {
                $pw1Err = "A minimum hossz 8 karakter";
                $err = true;
            }
            
        } else {
            $pw1Err = "Ezt a mezőt kötelező kitölteni";
            $err = true;
        }

        if (isset($_POST["pw2"]) && trim($_POST["pw2"]) != "") {
            if (trim($_POST["pw2"]) === trim($_POST["pw1"])) {

            } else {
                $pw2Err = "A két jelszó nem egyezik";
                $err = true;
            }
        } else {
            $pw2Err = "Ezt a mezőt kötelező kitölteni";
            $err = true;
        }


        if (!$err) {

            $conn->updatePassword($pass);
            
            header("Location: profile.php");
            
            

        }

        
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Webshop - Jelszómódosítás</title>
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
            <form class="normalForm" method="post" action="changePassword.php">
                <label class="formname">Jelszó módosítása</label>
                <div class="forms">
                    <label for="pw" class="required-label">Jelenlegi jelszó:</label><br>
                    <input type="password" id="pw" name="pw"  placeholder="Jelenlegi jelszó" required><br>
                    <span class="error"><?php echo $pwErr; ?></span>
                    <label for="pw1" class="required-label">Jelszó:</label><br>
                    <input type="password" id="pw1" name="pw1"  placeholder="Új jelszó" required><br>
                    <span class="error"><?php echo $pw1Err; ?></span>
                    <label for="pw2" class="required-label">Jelszó újra:</label><br>
                    <input type="password" id="pw2" name="pw2"  placeholder="Új jelszó újra" required><br>
                    <span class="error"><?php echo $pw2Err; ?></span>
                    <input type="submit" value="Mentés">
                    <a class="notyet" href="profile.php">Vissza a profilomhoz</a>
                </div>
            </form>
        </div>

    </main>
    <!-- footer -->
    <?php include_once "includes/footer.html"; ?>
</body>
</html>

