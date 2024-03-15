<?php 
session_start(); 

// Check if the user is logged in
require_once('../config/dbcon.php');
$db = new DB();
$connection = $db->getconnection();
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "user") {

    header("Location: ../login_page/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"]; 

?>
<?php require('./header.php')?>

<body>
    <?php require('../includes/navbar.php')?>
<main class="my-orders mt-5">
    <section class="main-padding">
        <div class="container">
            <h1>My Orders</h1>

            <!-- date-picker -->
            <form action="" method="post" class="mt-5">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="from-group">
                            <label for="start">Date from:</label>
                            <input type="date" class="form-control start" name="start" pattern="\d{4}-\d{2}-\d{2}" placeholder="YYYY-MM-DD" />
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="end">Date to:</label>
                            <input type="date" class="form-control end" name="end" pattern="\d{4}-\d{2}-\d{2}" placeholder="YYYY-MM-DD"/>
                        </div>
                    </div>
                    <div class="col-sm-2 mt-4">
                        <input type="submit" class="btn text-light w-50" value="Filter" name="filter"/>
                    </div>
                </div>
            </form> 
        </div>
    </section>
    <!-- orders -->
    <section class="main-padding my-5">
        <div class="container">
            <!-- user-orders -->
            <div class="user-orders">
                <!-- order -->
                <?php
                try {
                    $totalPriceAllOrders = 0; // Initialize total price for all orders
                    // Check if start and end dates are provided
                    if (!empty($_POST['start']) && !empty($_POST['end'])) {
                        $dateFrom = $_POST['start'];
                        $dateTo = $_POST['end'];

                        // Fetch orders for the logged-in user within the specified date range
                        $result = $db->getOrdersByDateRangeForUser($user_id, $dateFrom, $dateTo);

                        if ($result->num_rows > 0) {
                            // Output orders and items
							echo "<table class='table'>";
                        echo "<thead class='thead-light'>";
                        echo "<tr>";
                        echo "<th scope='col'>Order Date</th>";
                        echo "<th scope='col'>Status</th>";
                        echo "<th scope='col'>Amount</th>";
                        echo "<th scope='col'>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                            while ($order =  $result->fetch_assoc()) {
								// Initialize total price for each order
                                $totalPriceOrder = 0;
                                // Display table structure
                               

                                echo "<tr class='order'>";
                                echo "<td>";
                                echo "<span>{$order['order_date']}</span>";
                                echo "<button class='toggle-details btn btn-link'><i class='fas fa-plus-square'></i></button>";
                                echo "</td>";
                                echo "<td>{$order['order_status']}</td>";
                                echo "<td>{$order['total_price']} EGP</td>";
                                echo "<td>";
                                // Cancel button if order status is 'Processing'
                                if ($order['order_status'] == "Processing") {
                                    echo "<form method='post' action='cancel_order.php' onsubmit='return confirmDelete()'>";
                                    echo "<input type='hidden' name='order_id' value='{$order['order_id']}' />";
                                    echo "<button type='submit' class='cancel btn btn-danger' name='cancel_order'>Cancel</button>";
                                    echo "</form>";
                                 }

                                echo "</td>";
                                echo "</tr>";

                                // Fetch order items for the current order
                              //  $orderProducts = $db->getOrderProducts($order['order_id']);
								//$orderitems=$db->getdata("*","order_items","order_id={$order['order_id']}")->fetch_assoc();
								//var_dump($orderitems);
                                echo "<tr class='order-details' style='display: none;'>";
                                echo "<td colspan='4'>";
                                echo "<div class='row order-items'>";

            ///////////////////////////////////////////////
                                  // Fetch order items for the current order
                            $orderProducts = $db->getOrderProducts($order['order_id']);
							//$orderitems=$db->getdata("*","order_items","order_id={$order['order_id']}")->fetch_assoc();
                            
                            //var_dump($orderitems);
                            foreach ($orderProducts as $product) {
                                // Fetch order items for the current product
                                $orderItem = $db->getdata("*", "order_items", "order_id={$order['order_id']} AND product_id={$product['product_id']}")->fetch_assoc();
                            
                                // Check if order item exists
                                if ($orderItem) {
                                    echo "<div class='col-sm-3'>";
                                    echo " <div class='each-order'>";
                                    echo "<img src='../assests/images/{$product['image']}' alt='{$product['name']}' />";
                                    echo "<h5>{$product['name']}</h5>";
                            
                                    $totalPriceProduct = $product['price'] * $orderItem['quantity']; // Calculate total price for this product
                                    echo "<h6> Price: <span>{$product['price']} LE</span></h6>";
                                    echo "<h6> Quantity: <span>{$orderItem['quantity']}</span></h6>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                                echo "</div>";
								
                                echo "</td>";
								
                                echo "</tr>";
								
                                $totalPriceAllOrders += $order['total_price'];
								
                            }
							
							echo "</tbody>";
							echo "</table>";
							echo "<div class='total-price d-flex justify-content-evenly my-3'>";
								echo "<h3>Total for all orders</h3>";
								echo "<h3>{$totalPriceAllOrders} EGP</h3>"; 
							echo "</div>";
						
                        } else {
                            // No orders found for the user
                            echo "<p>No orders found.</p>";
							
                        }
                    } 
                    
          else {
                        // If start and end dates are not provided, fetch all orders
                        // Output orders and items
                        $orders = $db->getUserOrders($user_id);
                        
						echo "<table class='table'>";
                            echo "<thead class='thead-light'>";
                            echo "<tr>";
                            echo "<th scope='col'>Order Date</th>";
                            echo "<th scope='col'>Status</th>";
                            echo "<th scope='col'>Amount</th>";
                            echo "<th scope='col'>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
              
                        while ($order = $orders->fetch_assoc()) {
                            
							// Initialize total price for each order
							$totalPriceOrder = 0;
                            
                            echo "<tr class='order'>";
                            echo "<td>";
                            echo "<span>{$order['order_date']}</span>";
                            echo "<button class='toggle-details btn btn-link'><i class='fas fa-plus-square'></i></button>";
                            echo "</td>";
                            echo "<td>{$order['order_status']}</td>";
                            echo "<td>{$order['total_price']} EGP</td>";
                            // Cancel button if order status is 'Processing'
                            echo "<td>";
						
                            if ($order['order_status'] == "Processing") {
                                echo "<form method='post' action='cancel_order.php' onsubmit='return confirmDelete()'>";
                                echo "<input type='hidden' name='order_id' value='{$order['order_id']}' />";
                                echo "<button type='submit' class='cancel btn btn-danger' name='cancel_order'>Cancel</button>";
                                echo "</form>";
                             }
                            echo "</td>";
                            echo "</tr>";

                            echo "<tr class='order-details' style='display: none;'>";
                            echo "<td colspan='4'>";
                            echo "<div class='row order-items'>";
                            // Fetch order items for the current order
                            $orderProducts = $db->getOrderProducts($order['order_id']);
							//$orderitems=$db->getdata("*","order_items","order_id={$order['order_id']}")->fetch_assoc();
                            
                            //var_dump($orderitems);
                            foreach ($orderProducts as $product) {
                                // Fetch order items for the current product
                                $orderItem = $db->getdata("*", "order_items", "order_id={$order['order_id']} AND product_id={$product['product_id']}")->fetch_assoc();
                            
                                // Check if order item exists
                                if ($orderItem) {
                                    echo "<div class='col-sm-3'>";
                                    echo " <div class='each-order'>";
                                    echo "<img src='../assests/images/{$product['image']}' alt='{$product['name']}' />";
                                    echo "<h5>{$product['name']}</h5>";
                            
                                  //  $totalPriceProduct = $product['price'] * $orderItem['quantity']; // Calculate total price for this product
                                    echo "<h6> Price: <span>{$product['price']} LE</span></h6>";
                                    echo "<h6> Quantity: <span>{$orderItem['quantity']}</span></h6>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                            echo "</div>";
							

                            echo "</td>";
                            echo "</tr>";
                          
                            $totalPriceAllOrders += $order['total_price'];
                        }
						echo "</tbody>";
						echo "</table>";
						// Display total price
						echo "<div class='total-price d-flex justify-content-evenly my-3'>";
						echo "<h3>Total</h3>";
						echo "<h3>{$totalPriceAllOrders} EGP</h3>"; 
						echo "</div>";
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </section>
</main>
<script src="../assests/js/orders.js"></script>
<?php include('footer.php');?>
</body>
</html>