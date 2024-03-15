<?php 
require('../config/dbcon.php');

// Create a new instance of the DB class
$db = new db();

// Call the delete_row method to delete the user
$result = $db->delete("users", "user_id = {$_GET['id']}");

// Check if deletion was successful
if ($result) {
    // Redirect to the alluser.php page
    header("Location: alluser.php");
    exit();
} else {
    echo "Failed to delete user";
}
?>
