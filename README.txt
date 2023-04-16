Webshop beüzemelésének menete:

A waboldal hostolása XAMMP segítségével valósítható meg

1, Az egész webterv1 (nem csak a tartalma) a XAMMP htdocs mappában való elhelyezése
2, XAMMP Apache és MySQL szerverek elindítása
3, Adatbázis létrehozása az alábbi paranccsal:

    CREATE DATABASE ohmic_shop CHARACTER SET utf8 COLLATE utf8_hungarian_ci;

4, Az adatbázis kezelésere szolgáló felhasználó létrehozása az alábbi paranccsal:

    GRANT SELECT, INSERT, UPDATE, DELETE ON `ohmic\_shop`.* TO `client`@`%` IDENTIFIED BY PASSWORD '*B576E5914CDB76E949D4B5244447210F7CF44853';

5, Az ohmic_shop.sql fájl beimportálása az adatbázisba


Az oldal a http://localhost/webterv1/html/index.php címen érhető el

admin login: 
    email: admin@admin.com 
    pass:  adminadmin


Jó tesztelést