<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Webshop - Termékek kezelése</title>
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
        <a class="navlinks" href="register.php">Regisztráció</a>
        <a class="navlinks" href="cart.php">Kosár</a>
        <a class="navlinks" href="profile.php">Profil</a>
        <a class="navlinks" href="infos.php">Kapcsolat</a>
        <a id="active" class="navlinks" href="adminDashboard.php">Dashboard</a>
    </nav>
    <!-- tartalom -->
    <main>
        <div id="scroll-to-top">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})">▲</button>
            <a href="productAdd.php">Termékek kezelése</a>
        </div>
    </main>
</body>
</html>