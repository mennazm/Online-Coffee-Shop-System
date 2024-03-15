<?php
// Include your database connection file
require_once('../config/dbcon.php');
$db = new DB();
$connection = $db->getconnection();

// Check if the cancel order button is clicked

if(isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];

    // Delete order items associated with this order
    $sql_delete_items = "DELETE FROM order_items WHERE order_id = $order_id";
    $result_delete_items = $connection->query($sql_delete_items);

    if($result_delete_items) {
        // Delete the order
        $sql_delete_order = "DELETE FROM orders WHERE order_id = $order_id";
        $result_delete_order = $connection->query($sql_delete_order);

        if($result_delete_order) {
            // Order and its items deleted successfully
            // Redirect to the user-order.php page
            header("Location: user-orders.php");
            exit();
        } else {
            // Error in deleting the order
            echo "Error: Unable to delete the order.";
        }
    } else {
        // Error in deleting order items
        echo "Error: Unable to delete order items.";
    }
} else {
    // Redirect to the user-order.php page if cancel_order is not set
    header("Location: user-orders.php");
    exit();
}
?>
