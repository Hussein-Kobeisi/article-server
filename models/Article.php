<?php
require_once("Model.php");

class Article extends Model{

    private int $id; 
    private string $name; 
    private string $author; 
    private string $description; 
    
    protected static string $table = "articles";
    protected static string $pivotTable = "pivot";
    protected static string $categoryId = "catId";

    public function __construct(array $data){
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->author = $data["author"];
        $this->description = $data["description"];
    }
//getters
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getDescription(): string {
        return $this->description;
    }
//setters
    public function setName(string $name){
        $this->name = $name;
    }

    public function setAuthor(string $author){
        $this->author = $author;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }
//helpers
    public function toArray(){
        return [$this->id, $this->name, $this->author, $this->description];
    }
//sql
    public static function getByCategoryId(mysqli $mysqli, int $id){
        //get artID from pivotTable
        $sql = sprintf("Select * from %s WHERE %s = ?", 
                        static::$pivotTable, 
                        static::$categoryId);
                        
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();
        $articles = [];
        while ($row = $result->fetch_assoc()) {
            if($a = Article::find($mysqli, $row["artId"]))
            $articles[] = $a;
        }   
        return $articles;
    }
}
