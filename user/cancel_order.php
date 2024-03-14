<?php
session_start();
require_once('../config/dbcon.php');
$db = new db();
$connection = $db->getconnection();

if (isset($_POST["order_id"])) {
    $order_id = $_POST["order_id"];
        // Delete the order item from order_items table
    $deleteOrderItemsQuery = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $connection->prepare($deleteOrderItemsQuery);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    // Delete the order from orders table
    $deleteOrderQuery = "DELETE FROM  order_items WHERE order_id = ?";
    $stmt = $connection->prepare($deleteOrderQuery);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    echo "<h1>successfullay delete this : {$order['order_id']}</h1>";
 
    // Redirect back to the user's orders page after cancellation
    header("Location: user-orders.php");
    exit();
} else {

   echo "<script>
   console.log('hiiiiiii');
   </script>";
    exit();
}
?>
