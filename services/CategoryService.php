<?php 

class CategoryService {

    public static function categoriesToArray($categories_db){
        $results = [];

        foreach($categories_db as $c){
             $results[] = $c->toArray();
        } 

        return $results;
    }

    public static function getCategoryFromURL(){
        $raw = file_get_contents("php://input");
        $json = json_decode($raw, true);
        return $json["category"] ?? [];
    }


}