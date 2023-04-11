<?php
    include('utility/DBConnection.php');
    session_start();
    

    if (!isset($_SESSION["userData"])) {
    header("Location: login.php");
    }

    
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


        $cleanemail = "";
        if (isset($_POST["email"]) && trim($_POST["email"]) != "") {
            $_POST["email"] = trim($_POST["email"]);

            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                 
                 $cleanemail = $_POST["email"];
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
                        if (password_verify($pass, $_SESSION["userData"]->getPasswordHash())) {
                            # code...
                        } else {
                            $pwErr = "Hibás jelszó.<br>";
                            $err = true;
                        }
                        
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
            $conn->updateUserInfo($cleanfname, $cleanlname, $cleanemail);
            
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
    <title>Webshop - Adatfrissítés</title>
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
            <form class="normalForm" method="post" action="userInfoUpdate.php">
                <label class="formname">Adatok módosítása</label>
                <div class="forms">
                    <label for="fname" class="required-label">Vezetéknév:</label><br>
                    <input type="text" id="fname" name="fname"  placeholder="Vezetéknév" required
                    <?php
                        if (isset($_POST["fname"])) {
                            echo 'value="' . $_POST["fname"] . '"';
                        } else {
                            echo 'value="' . $_SESSION["userData"]->getFname() . '"';
                        }
                    ?>
                    ><br>
                    <span class="error"><?php echo $fNameErr; ?></span>
                    <label for="lname" class="required-label">Keresztnév:</label><br>
                    <input type="text" id="lname" name="lname"  placeholder="Keresztnév" required 
                    <?php
                        if (isset($_POST["lname"])) {
                            echo 'value="' . $_POST["lname"] . '"';
                        } else {
                            echo 'value="' . $_SESSION["userData"]->getLname() . '"';
                        }
                    ?>
                    ><br>
                    <span class="error"><?php echo $lNameErr; ?></span>
                    <label for="email" class="required-label">Email cím:</label><br>
                    <input type="text" id="email" name="email"  placeholder="Email cím" required 
                    <?php
                        if (isset($_POST["email"])) {
                            echo 'value="' . $_POST["email"] . '"';
                        } else {
                            echo 'value="' . $_SESSION["userData"]->getEmail() . '"';
                        }
                    ?>
                    ><br>
                    <span class="error"><?php echo $emailErr; ?></span>
                    <label for="pw" class="required-label">Jelszó a megerősítéshez:</label><br>
                    <input type="password" id="pw" name="pw"  placeholder="Jelszó" required><br>
                    <span class="error"><?php echo $pwErr; ?></span>
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

