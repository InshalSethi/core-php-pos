<?php 
 session_start();

$username = 'root'; // user name for database

$host = 'localhost';   // host name for database       

$password = ''; // database password

$dbname = 'sairauma_sairauma_madina_clubroad'; // database name


$db = new MysqliDb ($host, $username, $password, $dbname);



?>