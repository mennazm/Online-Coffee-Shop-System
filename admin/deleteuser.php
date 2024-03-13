<?php 
require("db.php");

// Create a new instance of the DB class
$db = new DB();

// Call the delete_row method to delete the user
$result = $db->delete_row("users", "user_id = {$_GET['id']}");

// Check if deletion was successful
if ($result) {
    // Redirect to the alluser.php page
    header("Location: alluser.php");
    exit();
} else {
    echo "Failed to delete user";
}
?>
