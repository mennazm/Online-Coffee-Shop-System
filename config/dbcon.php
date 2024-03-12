<?php
class db{
    private $host = "localhost";
    private $dbname = "cafeteria_project";
    private $username = "root";
    private $password = ""; 
    private $connection = null;

function __construct() {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
    }
}

function getconnection(){
    return $this->connection;
}

function delete($tablename , $condition){
  return  $this->connection->query("DELETE FROM $tablename WHERE  $condition");
}

function getdata($cols, $tablename, $condition){
    $query = "SELECT $cols FROM $tablename";
    if ($condition !== '') {
        $query .= " WHERE $condition";
    }
    $result = $this->connection->query($query);
    if (!$result) {
        // Error handling - log the error message
        error_log("Database error: " . $this->connection->error);
        return false;
    }
    return $result;
}




function insert_data($tableName, $columns, $values){ 
    $columnsStr = implode(', ', $columns); 
    $valuesStr = implode(', ', array_map(function($value) { 
        return "'$value'"; 
    }, $values)); 
    return $this->connection->query("INSERT INTO $tableName ($columnsStr) VALUES ($valuesStr)"); 
} 
 

function update_data($tableName, $columns_values, $condition) { 
    $setClause = implode(', ', array_map(function ($column, $value) { 
        return "$column='$value'"; 
    }, array_keys($columns_values), $columns_values)); 
    
    return $this->connection->query("UPDATE $tableName SET $setClause WHERE $condition"); 
}

function getbyid($tableName , $id){
    // Execute SQL query to fetch the record with the specified ID
    $result = $this->connection->query("SELECT * FROM $tableName WHERE id=$id");
    
   
    if ($result) {
       
        return $result;
    } else {
       
        echo "Error: " . $this->connection->error;
        return null;
    }
}

}