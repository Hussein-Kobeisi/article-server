<?php 

require(__DIR__ . "/../controllers/CategoryController.php");




$categories = [["name" => 'Technology'],
               ["name" => 'Health'],
               ["name" => 'Finance'],
               ["name" => 'Entertainment'],
               ["name" => 'Lifestyle'],
               ["name" => 'Science'],
               ["name" => 'Education'],
               ];

foreach($categories as $c){
    CategoryController::seedCategory($c);
}