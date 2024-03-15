<?php
class DB {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "cafeteria_project";
    private $connection = "";

    //open connection
    function __construct() {
        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
    }

    //get connection
    function get_connection(){
        return  $this->connection;
    }

    //take data from table of database
    function getdata($cols, $tablename, $condition=1){
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

    // Insert a row into a table
    function insert_row($table_name, $data) {
        $keys = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $query = "INSERT INTO $table_name ($keys) VALUES ($values)";
        return $this->connection->query($query);
    }

    // Execute custom SQL query and fetch data
    function get_data_custom($query) {
        $result = $this->connection->query($query);
        if (!$result) {
            // Error handling - log the error message
            error_log("Database error: " . $this->connection->error);
            return false;
        }
        return $result;
    }

    // Delete a row from a table based on a condition
    function delete_row($table_name, $condition){
      return $this->connection -> query("delete from $table_name where $condition") ;

  }


  function update_row($table_name, $data, $condition) {
    $query = "UPDATE $table_name SET ";
    foreach ($data as $key => $value) {
        $query .= "$key = '$value', ";
    }
    
    // Check if 'room_number' and 'Ext' are set in the $data array
    $room_number = isset($data['room_number']) ? $data['room_number'] : 0;
    $ext = isset($data['Ext']) ? $data['Ext'] : 0;

    // Append the room number and extension
    $query .= "room_number = '{$room_number}', Ext = '{$ext}' ";
    // Add the condition
    $query .= "WHERE $condition";
    
    // Execute the update query
    return $this->connection->query($query);
}

}
?>
