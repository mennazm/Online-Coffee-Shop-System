<?php
require('../config/dbcon.php');

// Get the room_id from the URL
$room_id = $_GET['id'] ?? '';

// Check if $room_id is empty or not a valid integer
if (!isset($room_id) || !filter_var($room_id, FILTER_VALIDATE_INT)) {
    die("Invalid room ID provided");
}

// Create a new instance of the Db class to connect to the database
$db = new db();
$connection = $db->getconnection();

// Check if there are any errors in database connection
if ($connection->connect_error) {
    die("Error in database connection: " . $connection->connect_error);
}

// Start transaction
$connection->begin_transaction();

try {
        // Delete the room row from the 'rooms' table
        $delete_room_query = $db->delete("rooms", "room_id = $room_id");

        // Check if deletion from 'rooms' table was successful
        if (!$delete_room_query) {
            throw new Exception("Failed to delete room row");
        }
    
    // Update associated rows in the 'users' table
    $update_query = $db->update_data("users", array("room_id" => NULL, "room_number" => 111, "Ext" => 111), "room_id = $room_id");
    
    // Check if update was successful
    if (!$update_query) {
        throw new Exception("Failed to update values in users table");
    }


    
    // Commit the transaction
    $connection->commit();

    // Success message
    header("Location: listAllrooms.php");
    exit();
} catch (Exception $e) {
    $connection->rollback();
    die($e->getMessage());
}

// Close the database connection
$connection->close();
?>
