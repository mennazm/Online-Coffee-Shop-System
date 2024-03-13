<?php
session_start(); 
// Check if the user is logged in
require_once('../../config/dbcon.php');
$database = new db(); 

if (isset($_POST['submit'])) {
    // Handle the order confirmation here
    $selected_user_id = $_POST['selected_user_id'];
    $notes = $_POST['notes'];
    $room_id = $_POST['room_id'];
    $amount = $_POST['amount'];

    //Insert into the 'orders' table 
    $insertOrderQuery = "INSERT INTO `orders` (user_id, room_id, total_price, order_status, order_date) VALUES (?, ?, ?, 'Processing', NOW())";
    $stmtOrder = $database->getConnection()->prepare($insertOrderQuery);
    if ($stmtOrder) {
        $stmtOrder->bind_param("iid", $selected_user_id, $room_id, $amount);
        $stmtOrder->execute();
        // Get the order_id of the newly inserted order
        $order_id = $database->getLastInsertedId();
        
        // Iterate through the selected items and save them in the order_items table
        foreach ($_POST['product_id'] as $productId) {
            $quantity = $_POST['quantity'][$productId];
            //Insert into the 'order_items' table 
            $insertOrderItemQuery = "INSERT INTO `order_items` (order_id, product_id, quantity, notes) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
            $stmtOrderItem = $database->getConnection()->prepare($insertOrderItemQuery);
            if ($stmtOrderItem) {
              $stmtOrderItem->bind_param("iiis", $order_id, $productId, $quantity, $notes);
              $stmtOrderItem->execute();
            }
        }
        var_dump($_POST);
        // Redirect to a confirmation page or perform other actions as needed
        //header("Location: success.html");
        exit();
    }
}
?>