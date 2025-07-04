<?php 
require("../connection/connection.php");


$query = "CREATE TABLE pivot(
          id INT(11) AUTO_INCREMENT PRIMARY KEY, 
          artId INT(11) REFERENCES articles(id),
          catId INT(11) REFERENCES categories(id))";

$execute = $mysqli->prepare($query);
$execute->execute();