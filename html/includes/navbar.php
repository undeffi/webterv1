<nav class="navbar">
<?php
    if (basename($_SERVER['SCRIPT_FILENAME']) == 'index.php') {
        echo '<a id="active" class="navlinks" href="index.php">Kezdőlap</a>';
    } else {
        echo '<a class="navlinks" href="index.php">Kezdőlap</a>';
    }
    if (basename($_SERVER['SCRIPT_FILENAME']) == 'shop.php') {
        echo '<a id="active" class="navlinks" href="shop.php">Áruház</a>';
    } else {
        echo '<a class="navlinks" href="shop.php">Áruház</a>';
    }
    if (basename($_SERVER['SCRIPT_FILENAME']) == 'infos.php') {
        echo '<a id="active" class="navlinks" href="infos.php">Kapcsolat</a>';
    } else {
        echo '<a class="navlinks" href="infos.php">Kapcsolat</a>';
    }
    if(isset($_SESSION["userData"])){
        if (basename($_SERVER['SCRIPT_FILENAME']) == 'cart.php') {
            echo '<a id="active" class="navlinks" href="cart.php">Kosár</a>';
        } else {
            echo '<a class="navlinks" href="cart.php">Kosár</a>';
        }
        if (basename($_SERVER['SCRIPT_FILENAME']) == 'profile.php') {
            echo '<a id="active" class="navlinks" href="profile.php">Profil</a>';
        } else {
            echo '<a class="navlinks" href="profile.php">Profil</a>';
        }

        if($_SESSION["userData"]->getPrivLevel() > 1){
            if (basename($_SERVER['SCRIPT_FILENAME']) == 'adminDashboard.php' || basename($_SERVER['SCRIPT_FILENAME'])== 'productAdd.php') {
                echo '<a id="active" class="navlinks" href="adminDashboard.php">Dashboard</a>';
            } else {
                echo '<a class="navlinks" href="adminDashboard.php">Dashboard</a>';
            }
        }
        
        echo '<a id="logout" class="navlinks" href="logout.php">Kilépés</a>';
    } else {
        if (basename($_SERVER['SCRIPT_FILENAME']) == 'login.php') {
            echo '<a id="active" class="navlinks" href="login.php">Bejelentkezés</a>';
        } else {
            echo '<a class="navlinks" href="login.php">Bejelentkezés</a>';
            }
        if (basename($_SERVER['SCRIPT_FILENAME']) == 'register.php') {
            echo '<a id="active" class="navlinks" href="register.php">Regisztráció</a>';
        } else {
            echo '<a class="navlinks" href="register.php">Regisztráció</a>';
        }
    }
    
?>
</nav>