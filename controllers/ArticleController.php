<?php 

require(__DIR__ . "/../models/Article.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ArticleService.php");
require(__DIR__ . "/../services/ResponseService.php");

class ArticleController{
    
    public function getArticles(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $articles = Article::all($mysqli);
            $articles_array = ArticleService::articlesToArray($articles); 
            echo ResponseService::response($articles_array);
            return;
        }

        $id = $_GET["id"];
        $article = Article::find($mysqli, $id);
        $article = $article?->toArray();
        echo ResponseService::response($article);
        return;
    }

    public static function seedArticle($data){
        global $mysqli;
        echo Article::create($mysqli, $data);
    }

    public static function insertArticle(){
        global $mysqli;
        $data = ArticleService::getArticleFromURL();

        echo Article::create($mysqli, $data);
    }

    public static function deleteArticles(){
        global $mysqli;
        $data = ArticleService::getArticleFromURL();
        
        if(!isset($data["id"])){
            echo Article::TOTAL_EXTERMINATION($mysqli);
            return;
        }
        $id = $data["id"];
        echo Article::deleteById($mysqli, $id);
    }

    public static function updateArticle(){
        global $mysqli;
        $data = ArticleService::getArticleFromURL();

        echo Article::update($mysqli, $data);
    }

    public static function getArticleByCategoryId(){
        global $mysqli;
        $id = $_GET["id"];

        $articles = Article::getByCategoryId($mysqli, $id);
        $resp = [];
        foreach($articles as $a){
            $resp[] = $a->toArray();
        }

        echo ResponseService::response($resp);
        return;
    }
}

//To-Do:

//1- Try/Catch in controllers ONLY!!! 
//2- Find a way to remove the hard coded response code (from ResponseService.php)
//3- Include the routes file (api.php) in the (index.php) -- In other words, seperate the routing from the index (which is the engine)
//4- Create a BaseController and clean some imports 