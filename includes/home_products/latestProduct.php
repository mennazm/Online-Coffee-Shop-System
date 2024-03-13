<?php
require_once('../config/dbcon.php');
$database = new db();

$user_id = $_SESSION["user_id"];

// Query to retrieve the latest order items for the user 
$latestOrderItemsQuery = "SELECT p.name AS product_name, p.image AS product_image
                          FROM order_items oi
                          JOIN products p ON oi.product_id = p.id
                          WHERE oi.order_id IN (SELECT order_id FROM orders WHERE user_id = ?)
                          ORDER BY oi.order_item_id DESC
                          LIMIT 3"; 

$stmtLatestOrderItems = $database->getConnection()->prepare($latestOrderItemsQuery);

if ($stmtLatestOrderItems) {
    $stmtLatestOrderItems->bind_param("i", $user_id);
    $stmtLatestOrderItems->execute();
    $resultLatestOrderItems = $stmtLatestOrderItems->get_result();

    // Display the latest order items 
    while ($row = $resultLatestOrderItems->fetch_assoc()) {
        echo '<div class="col-md-4">
                <div class="card mb-4">
                    <img src="../assests/images/' . $row['product_image'] . '" class="card-img-top" alt="' . $row['product_name'] . '" style="height: 130px; width:100%">
                    <div class="card-body">
                        <h5 class="card-title">' . $row['product_name'] . '</h5>
                    </div>
                </div>
              </div>';
    }

    $stmtLatestOrderItems->close();
}
?>
