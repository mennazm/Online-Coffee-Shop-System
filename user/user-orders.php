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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="../assests/css/orders.css";
</head>

<body>

<nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Cafeteria</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">My Orders</a>
                    
                </li>
            </ul>
            <div class="d-flex align-items-center">
           
		    <?php
       		     try {
                  
                    echo "<img class='img-fluid w-30' src='../assests/images/$image' alt='$username' title='$username' width='50' height='50'/>";
					echo "<p class='mt-3 mx-2'>$username</p>";
        
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } 
           
            ?>
			 
			</div>
        </div>
    </div>
</nav>

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
    <section class="main-padding" class="mt-5">
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
                                    //echo "<button class='cancel btn btn-danger'>Cancel</button>";
									echo "<form method='post'>";
									echo "<input type='hidden' name='order_id' value='{$order['order_id']}' />";
									echo "<input type='submit' class='cancel btn btn-danger' name='cancel_order' value='Cancel'/>";
									echo "</form>";
                                }

                                echo "</td>";
                                echo "</tr>";

                                // Fetch order items for the current order
                                $orderProducts = $db->getOrderProducts($order['order_id']);
								$orderitems=$db->getdata("*","order_items","order_id={$order['order_id']}")->fetch_assoc();
								//var_dump($orderitems);
                                echo "<tr class='order-details' style='display: none;'>";
                                echo "<td colspan='4'>";
                                echo "<div class='row order-items'>";
                                foreach ($orderProducts as $product) {
                                    //each-item
                                    echo "<div class='col-sm-3'>";
                                    echo " <div class='each-order'>";
                                    echo "<img src='../assests/images/{$product['image']}' alt='{$product['name']}' />";
                                    echo "<h5>{$product['name']}</h5>";
                                    echo "<p>{$product['price']} LE</p>";
									$totalPriceOrder += $product['price']; // Add the price of each item to the total for this order
                                    echo "<p>Quantity: {$orderitems['quantity']}</p>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                echo "</div>";
								echo "<div class='total-price d-flex justify-content-evenly my-3'>";
								echo "<h5>Order price</h5>";
								echo "<h5>{$totalPriceOrder} EGP</h5>"; 
								echo "</div>";
                                echo "</td>";
								
                                echo "</tr>";
								
								$totalPriceAllOrders += $totalPriceOrder;
								
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
                    } else {
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
                                echo "<form method=''>";
                                echo "<input type='hidden' name='order_id' value='{$order['order_id']}' />";
	
                                echo "<button class='cancel btn btn-danger'> Cancel</button>";
                                echo "</form>";
                            }
                            echo "</td>";
                            echo "</tr>";

                            echo "<tr class='order-details' style='display: none;'>";
                            echo "<td colspan='4'>";
                            echo "<div class='row order-items'>";
                            // Fetch order items for the current order
                            $orderProducts = $db->getOrderProducts($order['order_id']);
							$orderitems=$db->getdata("*","order_items","order_id={$order['order_id']}")->fetch_assoc();

                            foreach ($orderProducts as $product) {
                                //each-item
                                echo "<div class='col-sm-3'>";
                                echo " <div class='each-order'>";
                                echo "<img src='../assests/images/{$product['image']}' alt='{$product['name']}' />";
                                echo "<h5>{$product['name']}</h5>";
                                echo "<p>{$product['price']} LE</p>";
								$totalPriceOrder += $product['price']; // Add the price of each item to the total for this order

                                echo "<p>Quantity: {$orderitems['quantity']}</p>";
                                echo "</div>";
                                echo "</div>";
                            }
                            echo "</div>";
							echo "<div class='total-price d-flex justify-content-evenly my-3'>";
							echo "<h5>Order price</h5>";
								echo "<h5>{$totalPriceOrder} EGP</h5>";
							echo "</div>";

                            echo "</td>";
                            echo "</tr>";
                          
							$totalPriceAllOrders += $totalPriceOrder;
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
