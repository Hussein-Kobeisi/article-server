<?php
require_once("Model.php");

class Category extends Model{

    private int $id; 
    private string $name;
    
    protected static string $table = "categories";
    protected static string $pivotTable = "pivot";
    protected static string $articleId = "artId";

    public function __construct(array $data){
        $this->id = $data["id"];
        $this->name = $data["name"];
    }
//getters
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }
//setters
    public function setName(string $name){
        $this->name = $name;
    }
//helpers
    public function toArray(){
        return ["id" => $this->id, 
                "name" => $this->name];
    }
//sql
    public static function getByArticleId(mysqli $mysqli, int $id){
        //get catID from pivotTable
        $sql = sprintf("Select * from %s WHERE %s = ?", 
                        static::$pivotTable, 
                        static::$primary_key);

        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();
        
        return $category = Category::find($mysqli, $data["catId"]);
    }
}
