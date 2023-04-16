<?php
    include('utility/DBConnection.php');
    
    session_start();
    $conn = new DBConnection();
    $message = "";
    $emailErr = $pwErr = $email = $pw = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $err = false;

        if (isset($_POST["email"]) && trim($_POST["email"]) != "") {
            $email = trim($_POST["email"]);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                 
            } else {
                $emailErr = "Érvénytelen email cím";
                $err = true;
            }
        } else {
            $emailErr = "Ezt a mezőt kötelező kitölteni";
            $err = true;
        }

        if (isset($_POST["pw"]) && trim($_POST["pw"]) != "") {
            $pw = trim($_POST["pw"]);
            if (strlen($pw) >= 8) {
                if (strlen($pw) <= 50) {
                    if (filter_var($pw, FILTER_SANITIZE_STRING)) {

                    } else {
                        $pwErr = "Érvénytelen jelszó. Megengedett karakterek: aA-zZ 0-9 -_!%/=()<>#" . "<br>";
                        $err = true;
                    }
                } else {
                    $pwErr = "A maximum hossz 50 karakter";
                    $err = true;
                }
            } else {
                $pwErr = "A minimum hossz 8 karakter";
                $err = true;
            }
            
        } else {
            $pwErr = "Ezt a mezőt kötelező kitölteni";
            $err = true;
        }

        if (!$err) {
            
            $user = $conn->login($email, $pw);
            if ($user) {
                if (isset($_SESSION["userData"])) {
                    session_unset();
                    session_destroy();
                    session_start();
                }
                $message = "Sikeres bejelentkezés. Üdv " . $user->getLname();
                $_SESSION["userData"] = $user;
                header("Location: profile.php");
            } else {
                $message = "Hibás felhasználónév vagy jelszó";
            }
            
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
    <title>Webshop - Bejelentkezés</title>
    <link rel="icon" type="image/x-icon" href="../img/32px-Electronic_circuit.png">
</head>
<body>
    <!-- header -->
    <?php include_once "includes/header.html"; ?>
    <!-- navbar -->
    <?php include_once "includes/navbar.php"; ?>
    <!-- tartalom -->
    <main>
        <div id="formbox">
            <form class="normalForm" method="post" action="login.php"> <!-- action="login"-->
                <label class="formname"> Bejelentkezés</label>
                <div class="forms">
                    <label for="email" class="required-label">Email cím:</label><br>
                    <input type="text" id="email" name="email"  placeholder="Email cím"><br>
                    <span class="error"><?php echo $emailErr ?></span>
                    <label for="pw" class="required-label">Jelszó:</label><br>
                    <input type="password" id="pw" name="pw"  placeholder="Jelszó"><br>
                    <span class="error"><?php echo $pwErr ?></span>
                    <span class="error"><?php echo $message ?></span>
                    <input type="submit" value="Bejelentkezés">
                    <a class="notyet" href="register.php"> Még nem regisztráltam.</a>
                </div>
            </form>
        </div>
    </main>
    <!-- footer -->
    <?php include_once "includes/footer.html"; ?>

</body>
</html>