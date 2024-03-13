<?php
require("../db.php");

// Get the room_id from the URL
$room_id = $_GET['id'] ?? '';

// Debugging: Output the value of $room_id to check if it's received correctly
//echo "Room ID: " . $room_id . "<br>";

// Check if $room_id is empty or not a valid integer
if (!isset($room_id) || !filter_var($room_id, FILTER_VALIDATE_INT)) {
    die("Invalid room ID provided");
}

// Create a new instance of the Db class to connect to the database
$db = new DB();
$connection = $db->get_connection();

// Check if there are any errors in database connection
if ($connection->connect_error) {
    die("Error in database connection: " . $connection->connect_error);
}

// Escape $room_id to prevent SQL injection
//$room_id = $connection->real_escape_string($room_id);

// Delete associated rows in the 'users' table
$delete_users_query = "DELETE FROM users WHERE room_id = $room_id";
$result_users = $connection->query($delete_users_query);

// Check if deletion from 'users' table was successful
if (!$result_users) {
    die("Failed to delete associated user rows");
}

// Delete the room row from the 'rooms' table
$delete_room_query = "DELETE FROM rooms WHERE room_id = $room_id";
$result_room = $connection->query($delete_room_query);

// Check if deletion from 'rooms' table was successful
if (!$result_room) {
    die("Failed to delete room row");
}

// Success message
//echo "Room deleted successfully";
header("Location: listAllrooms.php");
exit();


// Close the database connection
$connection->close();
?>
