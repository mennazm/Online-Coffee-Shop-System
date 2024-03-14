<?php
session_start();
require_once('../config/dbcon.php');
$db = new db();
$connection = $db->getconnection();
var_dump($_GET["order_id"]);

if (isset($_GET["order_id"])) {
    $order_id = $_GET["order_id"];

        // Delete the order item from order_items table
    $deleteOrderItemsQuery = "DELETE FROM order_items WHERE order_id = ?";
    $stmt = $connection->prepare($deleteOrderItemsQuery);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    // Delete the order from orders table
    $deleteOrderQuery = "DELETE FROM  orders WHERE order_id = ?";
    $stmt = $connection->prepare($deleteOrderQuery);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

  header("Location:user-orders.php");
} 
?>
