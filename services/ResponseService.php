<?php

class ResponseService {

    public static function success_response($payload){
        $response = [];
        $response["status"] = 200;
        $response["payload"] = $payload;
        return json_encode($response);
    }

    public static function response($payload){
        $response = [];
        $response["status"] = ($payload === [] || $payload === NULL) ? 404 : 200;
        $response["payload"] = $payload;
        return json_encode($response);
    }

    public static function objectsToArray($objects_db){
        $results = [];

        foreach($objects_db as $a){
             $results[] = $a->toArray();
        } 

        return $results;
    }
}