<?php
session_start(); 
require_once('../config/dbcon.php');

$db = new db(); 
$connection = $db->getconnection();

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

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Checks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
body {
    background-color: rgba(250, 229, 212, 0.43);
}

nav {
    background-color: #93634c;
    color: #fbf8f2;
}

.navbar a {
    color: #fbf8f2;
}

.navbar a:hover {
    color: #fbf8f2;
}

h1,
h2,
h3,
h4,
h5,
th {
    color: #4b281e;
}

.each-order img {
    width: 60vw;
    height: 30vh;
}

#users {
    margin-left: 7.9%;
    width: 58vh;
    height: 40px;
    border: #c4c3c0 1px solid;
    border-radius: 4px;

}

h1 {
    text-align: center;
}

nav {
    font-weight: bold;

}

.navbar-nav .nav-link:hover {
    color: brown;
}

.row {
    margin-left: 200px;
}
</style>
</head>

<body>
<?php require('./includes/navbar.php')?>


    <main class="my-orders mt-5">
        <section class="main-padding d-flex justify-content-center align-items-center">
            <div class="container col-md-12">
                <h1>Checks</h1>
                <!-- date-picker -->
                <div class="card-body">
                    <form action="" method="post" class="mt-4">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="start">Date from:</label>
                                    <input type="date" class="form-control start" name="start"
                                        value="<?php if(isset($_POST['start'])){echo $_POST['start']; }?>" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="end">Date to:</label>
                                    <input type="date" class="form-control end" name="end"
                                        value="<?php if(isset($_POST['end'])){echo $_POST['end']; }?>" />
                                </div>
                            </div>
                            <div class="col-sm-4 mt-4">
                                <div class="form-group">
                                    <button id="filter" type="submit" class="btn btn-primary">filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- ./date-picker -->

                <div class="row mt-4">
                    <div>
                        <!-- Add this class to make the table responsive -->
                        <table class="table table-bordered table striped" style="background-color:white;">
                            <!-- <thead>
        <tr>
          <th scope="col">OrderDate</th>
          <th scope="col">Total Amount</th>
        </tr>
      </thead> -->

                        </table>
                    </div>
                </div>
<?php
               
?>
                <!-- HTML code with dropdown menu -->
                <div class="container" style="margin-left:-165px;">
                    <div class="row justify-content-center">
                        <div class="col-md-6 mt-4">
                            <form method="post" action="" class="d-flex align-items-center">
                                <div class="form-group flex-grow-1 mr-2">
                                    <select class="form-select" name="selected_user" id="selected_user">
                                        <option value="">Select User</option>
                                        <?php
                        // Fetch users from the database

                   //     $query = "SELECT * FROM users";
                        //$result = mysqli_query($connection, $query);
                        $result=$db->getdata("*","users","role='user'");
                       

                        if(mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['name']; ?>
                                        </option>
                                        <?php
                            }
                        }
                     
                        ?>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-left:60px;">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <br>

                <div class="box">
                    <div class="form-group">
                    </div>
                    <table class="table table-bordered table striped">
                        <!-- <thead style="background-color:#e3a53a;">
<tr>
  <th>Name</th>
  <th>Total Amount</th>
 </tr>
</thead> -->
                        <tbody id="result">

                            <?php

// $query= "SELECT * FROM orders WHERE order_date BETWEEN '$start' AND '$end'";


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  
  // Check if a user is selected
  if (isset($_POST['selected_user']) && !empty($_POST['selected_user'])) {
      // Get the selected user's ID
      $selected_user_id = $_POST['selected_user'];

      $query = "SELECT users.name, orders.user_id, SUM(orders.total_price) AS total_order_price
                FROM orders AS orders
                JOIN users ON orders.user_id = users.user_id
                WHERE users.user_id = ?
                GROUP BY orders.user_id;";

      $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $selected_user_id);
      $stmt->execute();
      $result = $stmt->get_result();
  } 

  elseif(isset($_POST['start']) && isset($_POST['end']) && !empty($_POST['start']) && !empty($_POST['end'])) {
    $start = $_POST['start'];
    $end = $_POST['end'];
    $query = "SELECT users.name, orders.user_id, SUM(orders.total_price) AS total_order_price
    FROM orders AS orders
    JOIN users ON orders.user_id = users.user_id
    WHERE order_date BETWEEN '$start' AND '$end' 
    GROUP BY orders.user_id;";

$stmt = $connection->prepare($query);
// $stmt->bind_param("i", $selected_user_id);
$stmt->execute();
$result = $stmt->get_result();

  }
}


else {
  // If no user is selected, display an error message
  $query = "SELECT users.name, orders.user_id, SUM(orders.total_price) AS total_order_price
            FROM orders AS orders
            JOIN users ON orders.user_id = users.user_id
            GROUP BY orders.user_id;";

  $stmt = $connection->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();
  // var_dump($result);
}

        // Check if any records are returned
        if ($result->num_rows > 0) {
            // Output table headers
            echo "<thead style='background-color:white;'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Total Amount</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='background-color: white;'>";
                echo "<span>" . $row['name'] . "</span>";
                echo "<button class='toggle-details btn btn-link'>";
                echo "<i class='fas fa-plus-square'></i>";
                echo "</button>";
                echo "</td>";
                echo "<td style='background-color: white;'>" . $row['total_order_price'] . "</td>";
                echo "</tr>";

                // Additional row for order details, initially hidden
                 echo "<tr class='order-details' style='display: none;'>";
                 echo "<td colspan='2'>";

// Fetch and display order details dynamically
if(isset($_POST['start']) && isset($_POST['end']) && !empty($_POST['start']) && !empty($_POST['end'])) {
    $start = $_POST['start'];
    $end = $_POST['end'];
    // $condition= "order_date BETWEEN '$start' AND '$end'"
$query_order = "SELECT o.order_date, o.order_id, SUM(p.price) AS total_price
                                FROM products p
                                JOIN order_items oi ON p.product_id = oi.product_id
                                JOIN orders o ON oi.order_id = o.order_id
                                WHERE o.user_id = ? AND order_date BETWEEN '$start' AND '$end'
                                GROUP BY o.order_date , o.order_id";
                                 $stmt = $connection->prepare($query_order);
                                 $stmt->bind_param("i", $row['user_id']);
                                 $stmt->execute();
                                 $order_result = $stmt->get_result();
}

else{

    $query_order = "SELECT o.order_date, o.order_id, SUM(p.price) AS total_price
    FROM products p
    JOIN order_items oi ON p.product_id = oi.product_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE o.user_id = ?
    GROUP BY o.order_date , o.order_id";
     $stmt = $connection->prepare($query_order);
     $stmt->bind_param("i", $row['user_id']);
     $stmt->execute();
     $order_result = $stmt->get_result();

}
if (mysqli_num_rows($order_result) > 0) {
  // Output order details in a table
  echo "<table class='table table-bordered'>";
  echo "<thead style='background-color: white; color: white;'>";
  echo "<tr>";
  echo "<th>Order Date</th>";
  echo "<th>Total Amount</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while ($order_row = mysqli_fetch_assoc($order_result)) {
      echo "<tr>";
      echo "<td style='background-color: white;'>";
      echo "<span>" . $order_row['order_date'] . "</span>";
      echo "<button class='toggle-details btn btn-link'>";
      echo "<i class='fas fa-plus-square'></i>";
      echo "</button>";
      echo "</td>";
      echo "<td style='background-color: white;'>" . $order_row['total_price'] . " EGP</td>";
      echo "</tr>";
       // Additional row for order details, initially hidden
       echo "<tr class='order-details' style='display: none;'>";
       echo "<td colspan='2'>";

       
/// Fetch and display data from the products table
$query_products = "SELECT p.name, p.price, p.image
                                   FROM order_items AS oi
                                   JOIN orders AS o ON oi.order_id = o.order_id 
                                   JOIN products AS p ON p.product_id = oi.product_id
                                   WHERE oi.order_id = ?";

                                      $stmt = $connection->prepare($query_products);
                                      $stmt->bind_param("i", $order_row['order_id']);
                                      $stmt->execute();
                                      $product_result = $stmt->get_result();

if(mysqli_num_rows($product_result) > 0) {
  echo "<table class='table table-bordered'>";
  echo "<thead style='background-color: white; color: white;'>";
  echo "<tr>";
  echo "<th>Name</th>";
  echo "<th>Price</th>";
  echo "<th>Image</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while ($row = mysqli_fetch_assoc($product_result)) {
      echo "<tr style='background-color: white;'>"; // Add style attribute for white background
      echo "<td style='background-color: white;'>" . $row['name'] . "</td>"; // Add style attribute for white background
      echo "<td style='background-color: white;'>" . $row['price'] . "</td>"; // Add style attribute for white background
      // Assuming the image is stored in a folder named "images"
      echo "<td style='background-color: white;'><img src='images/" . $row['image'] . "' width='100' height='100'></td>"; // Add style attribute for white background
      echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
}
else {
    echo "No products found";
}
  }
  echo "</tbody>";
  echo "</table>";
} else {
  // If no orders found, display a message
  echo "No orders found.";
}


echo "</td>";
echo "</tr>";

            }
            echo "</tbody>";
        }
        // Close the database connection
        // $stmt->close();
    
?>



                        </tbody>
                    </table>
                </div>

                <!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->



                <!-- Include jQuery before Bootstrap's JavaScript -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
                    crossorigin="anonymous"></script>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var toggleButtons = document.querySelectorAll(".toggle-details");
                    toggleButtons.forEach(function(button) {
                        button.addEventListener("click", function() {
                            var icon = button.querySelector("i");
                            var detailsRow = button.closest("tr").nextElementSibling;
                            if (icon.classList.contains("fa-plus-square")) {
                                icon.classList.remove("fa-plus-square");
                                icon.classList.add("fa-minus-square");
                                detailsRow.style.display = "table-row";
                            } else {
                                icon.classList.remove("fa-minus-square");
                                icon.classList.add("fa-plus-square");
                                detailsRow.style.display = "none";
                            }
                        });
                    });
                });
                </script>



</body>

</html>