<?php

include('utility/UserData.php');

session_start();
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Webshop - Kezdőlap</title>
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
<div class="contentContainer">
    <div style="width: 100%;">
        <div>

                <p>
                    Üdvözöllek az Ohmic Shop online felületén!
                </p>
        </div>
        <p>
            Miért éri meg nálunk vásárolni?
        </p>
        <div>
            <ul>
                <li>
                    Ugyan olyan minőségű termékeket árulunk itt is, mint a boltjainkban,
                </li>
                <li>
                    14 napos pénzvisszafizetési garanciát vállalunk,
                </li>
                <li>
                    Aznapi szállítás,
                </li>
                <li>
                    Nagy választék.
                </li>
            </ul>
        </div>
        <p>
            Az első üzletünket 2003-ban nyitottuk meg Szegeden, mára az egész országban elérhetőek vagyunk. A kiváló
            minőségű termékeink mellett
            kedvező árakkal is próbáljuk minél elérhetőbbé és érdekesebbé tenni a házilag is elkészíthető elektronikai
            eszközöket.
        </p>
    </div>
    <div>
        <table class="resistanceBandTable resistanceAttributeTable">
            <thead>
            <tr>
                <th id="rTableSav">Sáv</th>
                <th id="rTableSav4">4 Sávos</th>
                <th id="rTableSav5">5 Sávos</th>
                <th id="rTableSav6">6 Sávos</th>
            </tr>
            </thead>
            <tr>

                <td headers="rTableSav">
                    #1
                </td>
                <td colspan="3" headers="rTableSav4 rTableSav5 rTableSav6">
                    SZÁMJEGY
                </td>
            </tr>
            <tr>
                <td headers="rTableSav">
                    #2
                </td>
                <td colspan="3" headers="rTableSav4 rTableSav5 rTableSav6">
                    SZÁMJEGY
                </td>
            </tr>
            <tr>
                <td headers="rTableSav">
                    #3
                </td>
                <td headers="rTableSav4">
                    SZORZÓ
                </td>
                <td colspan="2" headers="rTableSav5 rTableSav6">
                    SZÁMJEGY
                </td>
            </tr>
            <tr>
                <td headers="rTableSav">
                    #4
                </td>
                <td headers="rTableSav4">
                    TOLERANCIA
                </td>
                <td colspan="2" headers="rTableSav5 rTableSav6">
                    SZORZÓ
                </td>
            </tr>
            <tr>
                <td headers="rTableSav">
                    #5
                </td>
                <td headers="rTableSav4">

                </td>
                <td colspan="2" headers="rTableSav5 rTableSav6">
                    TOLERANCIA
                </td>
            </tr>
            <tr>
                <td headers="rTableSav">
                    #6
                </td>
                <td colspan="2" headers="rTableSav4 rTableSav5">

                </td>
                <td headers="rTableSav6">
                    HŐM. EGYÜTT.
                </td>
            </tr>
        </table>
    </div>

    <div>
        <table class="resistanceBandTable">
            <thead>
            <tr>
                <th>SZÍNKÓD</th>
                <th>SZÁMJEGY</th>
                <th>SZORZÓ</th>
                <th>TELORANCIA</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="background-color: black; -webkit-text-stroke-width: 1px; -webkit-text-stroke-color: white;"></td>
                <td>0</td>
                <td>0</td>
                <td>1</td>
            </tr>
            <tr>
                <td style="background-color: brown;"></td>
                <td>1</td>
                <td>10</td>
                <td>± 1%</td>
            </tr>
            <tr>
                <td style="background-color: red;"></td>
                <td>2</td>
                <td>100</td>
                <td>± 2%</td>
            </tr>
            <tr>
                <td style="background-color: orange;"></td>
                <td>3</td>
                <td>1 000</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="background-color: yellow;"></td>
                <td>4</td>
                <td>10 000</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="background-color: green;"></td>
                <td>5</td>
                <td>100 000</td>
                <td>± 0,5%</td>
            </tr>
            <tr>
                <td style="background-color: blue;"></td>
                <td>6</td>
                <td>1 000 000</td>
                <td>± 0,25%</td>
            </tr>
            <tr>
                <td style="background-color: violet;"></td>
                <td>7</td>
                <td>10 000 000</td>
                <td>± 0,1%</td>
            </tr>
            <tr>
                <td style="background-color: gray;"></td>
                <td>8</td>
                <td>&nbsp;</td>
                <td>± 0,05%</td>
            </tr>
            <tr>
                <td style="background-color: white;"></td>
                <td>9</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="background-color: gold;"></td>
                <td>&nbsp;</td>
                <td>0,1</td>
                <td>± 5%</td>
            </tr>
            <tr>
                <td style="background-color: silver;"></td>
                <td>&nbsp;</td>
                <td>0,01</td>
                <td>± 10%</td>
            </tr>
            <tr>
                <td>Nincs</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>± 20%</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="videoFrame">
        <iframe src="https://www.youtube-nocookie.com/embed/IOb3-JZPY0Y"
                title="Speed of Electrons – What’s a Resistor (ElectroBOOM101-004)"></iframe>
    </div>
</div>
</main>
<!-- footer -->
<?php include_once "includes/footer.html"; ?>
</body>

</html>