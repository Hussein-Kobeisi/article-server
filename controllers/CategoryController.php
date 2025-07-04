<?php 

require(__DIR__ . "/../models/Category.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/CategoryService.php");
require(__DIR__ . "/../services/ResponseService.php");

class CategoryController{
    
    public static function getCategories(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $categories = Category::all($mysqli);
            $categories_array = CategoryService::categoriesToArray($categories); 
            echo ResponseService::response($categories_array);
            return;
        }

        $id = $_GET["id"];
        $category = Category::find($mysqli, $id)->toArray();
        echo ResponseService::response($category);
        return;
    }

    public static function seedCategory($data){
        global $mysqli;
        echo Category::create($mysqli, $data);
    }

    public static function insertCategory(){
        global $mysqli;
        $data = CategoryService::getCategoryFromURL();

        echo Category::create($mysqli, $data);
    }

    public static function deleteCategories(){
        global $mysqli;
        $data = CategoryService::getCategoryFromURL();
        
        if(!isset($data["id"])){
            echo Category::TOTAL_EXTERMINATION($mysqli);
            return;
        }
        $id = $data["id"];
        echo Category::deleteById($mysqli, $id);
    }

    public static function updateCategory(){
        global $mysqli;
        $data = CategoryService::getCategoryFromURL();

        echo Category::update($mysqli, $data);
    }

    public static function getCategoryByArticleId(){
        global $mysqli;
        $id = $_GET["id"];

        $category = Category::getByArticleId($mysqli, $id);
        $category = $category->toArray();
        echo ResponseService::response($category);
        return;
    }
}