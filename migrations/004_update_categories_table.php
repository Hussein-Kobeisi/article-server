<?php 
require("../connection/connection.php");


$query = "ALTER TABLE categories
          ADD UNIQUE (name);";

$execute = $mysqli->prepare($query);
$execute->execute();