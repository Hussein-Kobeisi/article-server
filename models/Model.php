<?php 
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $mysqli, int $id){
        $sql = sprintf("Select * from %s WHERE %s = ?", 
                        static::$table, 
                        static::$primary_key);
        
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();
        return $data ? new static($data) : null;
    }

    public static function all(mysqli $mysqli){
        $sql = sprintf("Select * from %s", static::$table);
        
        $query = $mysqli->prepare($sql);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()){
            $objects[] = new static($row); //creating an object of type "static" / "parent" and adding the object to the array
        }

        return $objects; //we are returning an array of objects!!!!!!!!
    }

    public static function create(mysqli $mysqli, $data){
        
        $cols = array_keys($data);
        $cols_str = "(".implode(", ", $cols).")";

        $sql = sprintf("INSERT INTO %s $cols_str VALUES",
                        static::$table);
        $sql = $sql." (".str_repeat(" ?,", count($data)-1)." ?);";

        $values =  array_values($data);
        $types = static::getArrTypes($data);

        try{
            $query = $mysqli->prepare($sql);
            $query->bind_param($types, ...$values);
            $query->execute();
            return "Success";
        }
        catch(mysqli_sql_exception $error){
            if(strpos($error->getMessage(), 'Duplicate entry') !== false){
                return "Duplicate Entry";
            }
            return $error->getMessage();
        }
    }

    public static function update(mysqli $mysqli, $data){ //data is a dictionary
        $cols = array_keys($data);
        $cols_str = implode(" = ? ,", $cols)." = ?";

        $sql = sprintf("UPDATE %s SET $cols_str WHERE %s = ?;",
                        static::$table,
                        static::$primary_key);
        $values =  array_values($data);
        $values[] = $data["id"];
        $types = static::getArrTypes($data).'i';
        
        $query = $mysqli->prepare($sql);
        $query->bind_param($types, ...$values);
        $query->execute();
        return $query->affected_rows ? "Success" : "No changes applied or Nonexistent ID";
    }

    public function delete(mysqli $mysqli){
        $sql = sprintf("DELETE FROM %s WHERE %S = ?",
                        static::$table,
                        static::$primary_key);
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $this->id);
        $query->execute();
    }

    public static function deleteById(mysqli $mysqli, int $id){
        $sql = sprintf("DELETE FROM %s WHERE %s = ?",
                        static::$table,
                        static::$primary_key);
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();
        return $query->affected_rows ? "Success" : "Nonexistent ID";
    }

    public static function TOTAL_EXTERMINATION(mysqli $mysqli){
        $sql = sprintf("DELETE FROM %s",
                        static::$table);
        $query = $mysqli->prepare($sql);
        $query->execute();
        return $query->affected_rows ? "Success: ".$query->affected_rows." rows deleted" : "Nonexistent ID";
    }
    //you have to continue with the same mindset
    //Find a solution for sending the $mysqli everytime... 
    //Implement the following: 
    //1- update() -> non-static function 
    //2- create() -> static function
    //3- delete() -> static function 


    // helper functions
    protected static function getArrTypes($arr){
        $types = '';
        foreach ($arr as $x) {
            if (is_int($x)) {
                $types .= 'i';
            } elseif (is_float($x)) {
                $types .= 'd';
            } elseif (is_string($x)) {
                $types .= 's';
            } else {
                $types .= 'b'; // fallback for blobs or unsupported types
            }
        }
        return $types;
    }
}



