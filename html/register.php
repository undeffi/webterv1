<?php
    include('utility/DBConnection.php');
    session_start();
    

    
    $fNameErr = $lNameErr = $emailErr = $pwErr = $pw2Err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cleanfname = $cleanlname = $cleanemail = $pass = "";

        $err = false;

        $conn = new DBConnection();

        if (isset($_POST["fname"]) && trim($_POST["fname"]) != "") {
            $_POST["fname"] = trim($_POST["fname"]);
            if (strlen($_POST["fname"]) >= 5) {
                if (strlen($_POST["fname"]) <= 50) {
                    if (preg_match("/^[a-zA-Z-' ]*$/",$_POST["fname"])) {
                        $cleanfname = $_POST["fname"];
                    } else {
                        $fNameErr = "Ide csak betűket írhatsz";
                        $err = true;
                    }
                } else {
                    $fNameErr = "A maximum hossz 50 karakter";
                    $err = true;
                }
            } else {
                $fNameErr = "A minimum hossz 5 karakter";
                $err = true;
            }
            
        } else {
            $fNameErr = "Ezt a mezőt kötelező kitölteni";
            $err = true;
        }

        if (isset($_POST["lname"]) && trim($_POST["lname"]) != "") {
            $_POST["lname"] = trim($_POST["lname"]);
            if (strlen($_POST["lname"]) >= 5) {
                if (strlen($_POST["lname"]) <= 50) {
                    if (preg_match("/^[a-zA-Z-' ]*$/",$_POST["lname"])) {
                        $cleanlname = $_POST["lname"];
                    } else {
                        $lNameErr = "Ide csak betűket írhatsz" . "<br>";
                        $err = true;
                    }
                } else {
                    $lNameErr = "A maximum hossz 50 karakter" . "<br>";
                    $err = true;
                }
            } else {
                $lNameErr = "A minimum hossz 5 karakter" . "<br>";
                $err = true;
            }
            
        } else {
            $lNameErr = "Ezt a mezőt kötelező kitölteni" . "<br>";
            $err = true;
        }

        if (isset($_POST["email"]) && trim($_POST["email"]) != "") {
            $_POST["email"] = trim($_POST["email"]);

            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                 if (!$conn->doesUserExist(trim($_POST["email"]))) {
                    $cleanemail = $_POST["email"];
                    
                 } else {
                    $emailErr = "Ez az email cím foglalt";
                    $err = true;
                 }
            } else {
                $emailErr = "Érvénytelen email cím";
                $err = true;
            }
        } else {
            $emailErr = "Ezt a mezőt kötelező kitölteni";
            $err = true;
        }

        if (isset($_POST["pw"]) && trim($_POST["pw"]) != "") {
            $_POST["pw"] = trim($_POST["pw"]);
            if (strlen($_POST["pw"]) >= 8) {
                if (strlen($_POST["pw"]) <= 50) {
                    if (filter_var($_POST["pw"], FILTER_SANITIZE_STRING)) {
                        $pass = $_POST["pw"];
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

        if (isset($_POST["pw2"]) && trim($_POST["pw2"]) != "") {
            if (trim($_POST["pw2"]) === trim($_POST["pw"])) {

            } else {
                $pw2Err = "A két jelszó nem egyezik";
                $err = true;
            }
        } else {
            $pw2Err = "Ezt a mezőt kötelező kitölteni";
            $err = true;
        }

        if (!$err) {
            if ($conn->addUser($cleanfname, $cleanlname, $cleanemail, $pass, 0)) {
                header("Location: login.php");
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
    <title>Webshop - Regisztráció</title>
    <link rel="icon" type="image/x-icon" href="../img/32px-Electronic_circuit.png">
</head>
<body>
    <!-- header -->
    <header id="header">
        <h1> Ohmic Shop </h1>
    </header>
    <!-- navbar -->
    <nav class="navbar">
        <a class="navlinks" href="index.php">Kezdőlap</a>
        <a class="navlinks" href="shop.php">Áruház</a>
        <a class="navlinks" href="login.php">Bejelentkezés</a>
        <a class="navlinks" id="active" href="register.php">Regisztráció</a>
        <a class="navlinks" href="cart.php">Kosár</a>
        <a class="navlinks" href="profile.php">Profil</a>
        <a class="navlinks" href="infos.php">Kapcsolat</a>
        <?php if (isset($_SESSION["userData"]) && $_SESSION["userData"]->getPrivLevel() > 1) {
        echo "<a class='navlinks' href='adminDashboard.php'>Dashboard</a>";
  }  ?>
    </nav>
    <!-- tartalom -->
    <main>
        <div id="scroll-to-top">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})">▲</button>
        </div>
        <div id="formbox">
            <form method="post" action="register.php">
                <label class="formname"> Regisztráció</label>
                <div class="forms">
                    <label for="fname" class="required-label">Vezetéknév:</label><br>
                    <input type="text" id="fname" name="fname"  placeholder="Vezetéknév" required><br>
                    <span class="error"><?php echo $fNameErr; ?></span>
                    <label for="lname" class="required-label">Keresztnév:</label><br>
                    <input type="text" id="lname" name="lname"  placeholder="Keresztnév" required><br>
                    <span class="error"><?php echo $lNameErr; ?></span>
                    <label for="email" class="required-label">Email cím:</label><br>
                    <input type="text" id="email" name="email"  placeholder="Email cím" required><br>
                    <span class="error"><?php echo $emailErr; ?></span>
                    <label for="pw" class="required-label">Jelszó:</label><br>
                    <input type="password" id="pw" name="pw"  placeholder="Jelszó" required><br>
                    <span class="error"><?php echo $pwErr; ?></span>
                    <label for="pw2" class="required-label">Jelszó újra:</label><br>
                    <input type="password" id="pw2" name="pw2"  placeholder="Jelszó újra" required><br>
                    <span class="error"><?php echo $pw2Err; ?></span>
                    <input type="submit" value="Regisztáció">
                    <input type="reset" value="Törlés">
                    <a class="notyet" href="login.php"> Már regisztráltam.</a>
                </div>
            </form>
        </div>

    </main>
    <!-- footer -->
    <footer>
        <div id="right">
            <p>Email cím: ohmic@gmail.com</p>
            <p>Telefonszám: +36301234567</p>
            <p>Ohmic Shop &copy; </p>
        </div>
        <div id="left">
            <p>Hétfő - Péntek: 8:00 - 16:00</p>
            <p>Szombat: 10:00 - 14:00</p>
            <p>Vasárnap: Zárva</p>
        </div>
    </footer>
</body>
</html>

