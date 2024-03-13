<?php 
session_start(); 
//require("../config/dbcon.php");
// Check if the user is logged in
require_once('../config/dbcon.php');
$db = new DB();
$connection = $db->getconnection();

//$database = new db(); 
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "user") {

    header("Location: ../login_page/login.php");
    exit();
}
var_dump($_SESSION);
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"]; 

if ($connection->connect_error){
	die("Failed to connect: " . $connection->connect_error);
}
?>
 <?php include('header.php');?>
<style>
		body{
			background-color: #FBF8F2;
		}
		nav,footer{
			background-color: #93634C;
			color: #FBF8F2;
		}
		.navbar a{
			
			color: #FBF8F2;
		}
		.navbar a:hover{
			color: #FBF8F2;
		}
		h1,h2,h3,h4,h5,th{
			color: #4b281e;
		}
		.my-orders img{
			width: 30vw;
			height: 30vh;

		}
	</style>
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
           <!-- <img "src='./imgs/{$data['image']}'"  width="50" height="50" >-->	
		    <?php
       		     try {
              		//  $result = $db->getdata("*","users",1);
						//var_dump($result->fetch_array(MYSQLI_ASSOC));
            		//    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
                  
                    echo "<img class='img-fluid w-30' src='../admin/assests/images/$image' alt='$username' title='$username' width='50' height='50'/>";
					echo "<p class='mt-3 mx-2'>$username</p>";
            //    }
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
              <div class="col-sm-6">
                <div class="from-group">
                  <label for="start">Date from:</label>
                  <input type="date" class="form-control start" name="start" pattern="\d{4}-\d{2}-\d{2}" placeholder="YYYY-MM-DD" />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="end">Date to:</label>
                  <input type="date" class="form-control end" name="end" pattern="\d{4}-\d{2}-\d{2}" placeholder="YYYY-MM-DD"/>
                </div>
              </div>
            </div>
			<input type="submit" class="btn btn-primary" value="Filter"/>
          </form> 
          
        </div>
      </section>
<!-- orders -->
 <section class="main-padding" class="mt-5">
        <div class="container">
<!-- user-orders -->
          <div class="user-orders">
<!-- ! table -->
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col">Order Date</th>
                  <th scope="col">Status</th>
                  <th scope="col">Amount</th>
<!--                   <th scope="col">Ext</th>
 -->                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- order -->
                
				<?php
       		     try {
					       // Check if start and end dates are provided
    if( !empty($_POST['start']) && !empty($_POST['end'])) {
        $dateFrom = $_POST['start'];
        $dateTo = $_POST['end'];
         
		  // Fetch orders for the logged-in user
		  $orders = $db->getUserOrders($user_id);
		  if ($orders->num_rows > 0) {
			// Display table structure
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

			// Output orders and items
			while ($order = $orders->fetch_assoc()) {
			  echo "<tr>";
			  echo "<td>{$order['order_date']}</td>";
			  echo "<td>{$order['order_status']}</td>";
			  echo "<td>{$order['total_price']} EGP</td>";
			  echo "<td>";
			  // Cancel button if order status is 'Processing'
			  if ($order['order_status'] == "Processing") {
				echo "<button class='cancel btn btn-danger'>Cancel</button>";
			  }
			  echo "</td>";
			  echo "</tr>";

			   // Fetch order items for the current order
			   $orderProducts = $db->getOrderProducts($order['order_id']);
			   foreach ($orderProducts as $product) {
					echo "<tr>";
					echo "<td colspan='4'>";
					echo "<div>";
					echo "<img src='../admin/assests/images/{$product['image']}' alt='{$product['name']}' />";
					echo "<h5>{$product['name']}</h5>";
					echo "<p>{$product['price']} LE</p>";
					echo "</div>";
					echo "</td>";
					echo "</tr>";
				}
			}
			echo "</tbody>";
			echo "</table>";

			// Display total price
			echo "<div class='total-price d-flex justify-content-evenly'>";
			echo "<h3>Total</h3>";
			// Calculate total price here
			echo "<h3>EGP <span>200</span></h3>"; // Example total price
			echo "</div>";
		  } else {
			// No orders found for the user
			echo "<p>No orders found.</p>";
		  }
		} else {
    // If start and end dates are not provided, fetch all orders
				 // Fetch orders for the logged-in user
				 $orders = $db->getUserOrders($user_id);
				 foreach ($orders as $order) {
					 echo "<tr>";
					 echo "<td>{$order['order_date']}</td>";
					 echo "<td>{$order['order_status']}</td>";
					 echo "<td>{$order['total_price']} EGP</td>";
					 echo "<td>";
					 // Cancel button if order status is 'Processing'
					 if ($order['order_status'] == "Processing") {
						 echo "<button class='cancel btn btn-danger'>Cancel</button>";
					 }
					 echo "</td>";
					 echo "</tr>";
 
					 // Fetch order items for the current order
					 $orderProducts = $db->getOrderProducts($order['order_id']);
                    foreach ($orderProducts as $product) {
						 echo "<tr>";
						 echo "<td colspan='4'>";
						 echo "<div>";
						 echo "<img src='../admin/assests/images/{$product['image']}' alt='{$product['name']}' />";
						 echo "<h5>{$product['name']}</h5>";
						 echo "<p>{$product['price']} LE</p>";
						 echo "</div>";
						 echo "</td>";
						 echo "</tr>";
					 }
				 }
				 echo "<div class='total-price d-flex justify-content-evenly'>";
				 echo "<h3>Total</h3>";
				 echo "<h3>EGP <span>200</span></h3>";
				 echo "</div>";
}
              
               } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
              }
            ?>
                  
               
                
              </tbody>
            </table>
<!-- end of table -->
						
<!-- total-price -->
			<!-- <div class="total-price d-flex justify-content-evenly">
					<h3>Total</h3>
					<h3>EGP <span>200</span></h3>
			</div> -->
<!-- end of total-price -->
          </div>
        </div>
      </section>
    </main>
<!-- Include jQuery before Bootstrap's JavaScript -->

<script>
document.addEventListener("DOMContentLoaded", function() {
    var toggleButtons = document.querySelectorAll('.toggle-details');
    toggleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var icon = button.querySelector('i');
            var detailsRow = button.closest('tr').nextElementSibling;
            if (icon.classList.contains('fa-plus-square')) {
                icon.classList.remove('fa-plus-square');
                icon.classList.add('fa-minus-square');
                detailsRow.style.display = 'table-row';
            } else {
                icon.classList.remove('fa-minus-square');
                icon.classList.add('fa-plus-square');
                detailsRow.style.display = 'none';
            }
        });
    });
});

</script>
<?php include('footer.php');?>
 
