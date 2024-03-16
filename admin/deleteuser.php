<?php 
require('../config/dbcon.php');
session_start();
// Create a new instance of the DB class
$db = new db();

// Get the user ID from the URL parameter
$user_id = $_GET['id'];

// Check if the user has any orders
$user_orders = $db->getUserOrders($user_id);
if ($user_orders->num_rows > 0) {
    // User has orders, so delete them first
    while ($order = $user_orders->fetch_assoc()) {
        $order_id = $order['order_id'];
        
        // Delete order items associated with this order
        $db->deleteuser('order_items', "order_id = $order_id");
        
        // Delete the order
        $db->deleteuser('orders', "order_id = $order_id");
    }
}

// Call the delete method to delete the user
$result = $db->deleteuser("users", "user_id = $user_id");

// Check if deletion was successful
if ($result) {
    // Redirect to the alluser.php page
    header("Location: alluser.php");
    exit();
} else {
    echo "Failed to delete user";
}
?>
