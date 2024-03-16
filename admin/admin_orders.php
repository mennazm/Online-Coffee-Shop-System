<?php
session_start(); 
require_once('../config/dbcon.php');
$db = new db(); 

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

    header("Location: ../login_page/login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"];

?>
<!DOCTYPE html>
<html>
<?php include('./includes/header.php')?>


<body>
<?php include('./includes/navbar.php')?>


<main class="admin-orders">
    <section class="main-padding">
        <div class="container">
            <h1 class="my-5">Orders</h1>
            <!-- Table to display orders -->
            <?php
            
            $deliveredOrdersFound = false; // Flag variable to track if any delivered orders are found
            $result = $db->getOrdersWithDetails();
            
            if ($result->num_rows > 0) {  
                 echo "
                        <table class='table'>
                            <thead class='thead-light'>
                                <tr>
                                    <th scope='col'>Order Date</th>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Room</th>
                                    <th scope='col'>Ext</th>
                                    <th scope='col'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        ";
                       /*  echo "<pre>";
                        var_dump($result->fetch_assoc());
                echo "</pre>"; */
       
                   while ($row = $result->fetch_assoc()) {
                    
                    if ($row['order_status'] == "Done") {
                       
                        echo "<tr class='order'>";
                        echo "<td><span>{$row['order_date']}</span><button class='toggle-details btn btn-link'><i class='fas fa-plus-square'></i></button></td>";
                        echo "<td>{$row['username']}</td>";

                        $rooms=$db->getdata("*","rooms","room_id={$row['room_id']}");
                       /*  echo "<pre>";
                       var_dump($rooms->fetch_assoc());
                       echo "</pre>"; */
                        $room=$rooms->fetch_assoc(); 
                         echo "<td>{$room['room_number']}</td>";
                        echo "<td>{$room['Ext']}</td>";
                        echo "<td>deliver</td>";
                        echo "</tr>";
                        echo "<tr class='order-details' style='display: none;'>";
                        echo "<td colspan='5'>";
                        echo "<div class='row order-items col-md-12'>";
                        // Fetch order details for the current order
                        $orderProducts = $db->getOrderProducts($row['order_id']);
                        $totalPrice = 0; // Initialize total price
                        if ($orderProducts->num_rows > 0) {
                            while ($order_detail = $orderProducts->fetch_assoc()) {
                                // Fetch order item for the current product
                                $orderItem = $db->getdata("*", "order_items", "order_id={$row['order_id']} AND product_id={$order_detail['product_id']}")->fetch_assoc();
                                
                                echo "<div class='col-sm-3'>";
                                echo "<div class='each-order'>";
                                echo "<img src='./assests/images/{$order_detail['image']}' class='img-fluid w-75 w-md-75 ' alt='{$order_detail['name']}' />";
                                echo "<h4>{$order_detail['name']}</h4>";
                                echo "<h6> Price: <span>{$order_detail['price']} LE</span></h6>";
                                echo "<h6> Quantity: <span>{$orderItem['quantity']}</span></h6>";
                                $totalPrice += $order_detail['price'] * $orderItem['quantity']; // Add the price of each item to the total
                                echo "</div>";
                                echo "</div>";
                            }
                        } 
                             // Display total price
		                  echo "<div class='total-price d-flex justify-content-evenly my-3'>";
	                  	echo "<h3>Total</h3>";
	
		                echo "<h3>{$totalPrice} EGP</h3>"; 
	                  	echo "</div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        
                        $deliveredOrdersFound = true; // Set the flag to true if delivered orders are found
                    }
                }
                   echo "</tbody>";
                        echo "</table>";
            } 
            if (!$deliveredOrdersFound) { // Display message if no delivered orders are found
                echo "<h3 class='text-center'>No delivered orders yet....</h3>";
            }
            ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<script src="../assests/js/orders.js"></script>
</body>
</html>
