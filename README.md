# About

A mandatory 2 person group project for our web development course.
The project consists of PHP web pages and classes, and uses a MySQL database.


# Setup


The website can be locally hosted with XAMMP

1. Copy the webterv1 folder to xampp/htdocs in its entirety 
2. Start the Apache and MySQL servers in XAMPP
3. Create the database with the command below:

    `CREATE DATABASE ohmic_shop CHARACTER SET utf8 COLLATE utf8_hungarian_ci;`

4. Create the user account that is responsible for managing the database:

    `GRANT SELECT, INSERT, UPDATE, DELETE ON `ohmic\_shop`.* TO `client`@`%` IDENTIFIED BY PASSWORD '*B576E5914CDB76E949D4B5244447210F7CF44853';`

5. Import the ohmic_shop.sql file into the database


The site can be reached via this address: http://localhost/webterv1/html/index.php 

admin login: 
    email: admin@admin.com 
    pass:  adminadmin
