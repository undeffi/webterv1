<?php
    include('utility/DBConnection.php');
    session_start();
    

    if (!isset($_SESSION["userData"])) {
    header("Location: login.php");
    }

    $pwErr = false;
    $fnameLenErr = $fnameContentErr = $lnameLenErr = $lnameContentErr = $emailErr = $emailAlreadyUsedErr = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cleanfname = $cleanlname = $cleanemail = $pass = "";

        $err = false;

        $conn = new DBConnection();

        if (isset($_POST["fname"]) && trim($_POST["fname"]) != "") {
            $_POST["fname"] = trim($_POST["fname"]);
            if (strlen(utf8_decode($_POST["fname"])) >= 2) {
                if (strlen(utf8_decode($_POST["fname"])) <= 50) {
                    if (preg_match("/^[a-zA-ZáÁéÉíÍóÓőŐúÚűŰ' ]*$/",$_POST["fname"])) {
                        $cleanfname = $_POST["fname"];
                    } else {
                        $fnameContentErr = true;
                        $err = true;
                    }
                } else {
                    $fnameLenErr = true;
                    $err = true;
                }
            } else {
                $fnameLenErr = true;
                $err = true;
            }
            
        } else {
            $fnameLenErr = true;
            $err = true;
        }

        if (isset($_POST["lname"]) && trim($_POST["lname"]) != "") {
            $_POST["lname"] = trim($_POST["lname"]);
            if (strlen(utf8_decode($_POST["lname"])) >= 2) {
                if (strlen(utf8_decode($_POST["lname"])) <= 50) {
                    if (preg_match("/^[a-zA-ZáÁéÉíÍóÓőŐúÚűŰ' ]*$/",$_POST["lname"])) {
                        $cleanlname = $_POST["lname"];
                    } else {
                        $lnameContentErr = true;
                        $err = true;
                    }
                } else {
                    $lnameLenErr = true;
                    $err = true;
                }
            } else {
                $lnameLenErr = true;
                $err = true;
            }
            
        } else {
            $lnameLenErr = true;
            $err = true;
        }

        if (isset($_POST["email"]) && trim($_POST["email"]) != "") {
            $_POST["email"] = trim($_POST["email"]);

            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                 if (!$conn->doesUserExist(trim($_POST["email"]))) {
                    $cleanemail = $_POST["email"];
                    
                 } else {
                    $emailAlreadyUsedErr = true;
                    $err = true;
                 }
            } else {
                $emailErr = true;
                $err = true;
            }
        } else {
            $emailErr = true;
            $err = true;
        }

        if (isset($_POST["pw"]) && trim($_POST["pw"]) != "") {
            $_POST["pw"] = trim($_POST["pw"]);
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
                    <span class= <?php echo $fnameLenErr ? '"error"' : '"success"' ?>>2-50 karakter</span>
                    <span class= <?php echo $fnameContentErr ? '"error"' : '"success"' ?>>Magyar kis és nagybetűk</span>
                    <input type="text" id="fname" name="fname"  placeholder="Vezetéknév" required
                    <?php
                        if (isset($_POST["fname"])) {
                            echo 'value="' . filter_var($_POST["fname"], FILTER_SANITIZE_STRING) . '"';
                        } else {
                            echo 'value="' . $_SESSION["userData"]->getFname() . '"';
                        }
                    ?>
                    ><br>
                    <label for="lname" class="required-label">Keresztnév:</label><br>
                    <span class= <?php echo $lnameLenErr ? '"error"' : '"success"' ?>>2-50 karakter</span>
                    <span class= <?php echo $lnameContentErr ? '"error"' : '"success"' ?>>Magyar kis és nagybetűk</span>
                    <input type="text" id="lname" name="lname"  placeholder="Keresztnév" required 
                    <?php
                        if (isset($_POST["lname"])) {
                            echo 'value="' . filter_var($_POST["lname"], FILTER_SANITIZE_STRING)  . '"';
                        } else {
                            echo 'value="' . $_SESSION["userData"]->getLname() . '"';
                        }
                    ?>
                    ><br>
                    <label for="email" class="required-label">Email cím:</label><br>
                    <span class= <?php echo $emailErr ? '"error"' : '"success"' ?>>Érvényes email cím</span>
                    <span class= <?php echo $emailAlreadyUsedErr ? '"error"' : '"success"' ?>>Az oldalon még nem használt email cím</span>
                    <input type="text" id="email" name="email"  placeholder="Email cím" required 
                    <?php
                        if (isset($_POST["email"])) {
                            echo 'value="' . filter_var($_POST["email"], FILTER_SANITIZE_STRING)  . '"';
                        } else {
                            echo 'value="' . $_SESSION["userData"]->getEmail() . '"';
                        }
                    ?>
                    ><br>
                    <label for="pw" class="required-label">Jelszó a megerősítéshez:</label><br>
                    <input type="password" id="pw" name="pw"  placeholder="Jelszó" required><br>
                    <?php 
                    if ($pwErr !== false) {
                        echo '<span class="error">' . $pwErr . '</span>';
                    }
                    ?>
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

