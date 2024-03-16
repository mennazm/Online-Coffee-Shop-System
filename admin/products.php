<?php
ob_start();
session_start();
include('includes/header.php');

?>
<?php
require('../config/dbcon.php');

$db = new db(); 

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

    header("Location: ../login_page/login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"];
include('includes/navbar.php');

?>

<div style="background-color:#FBF8F2" class="container bg-body mt-3">

    <div class="row">
       <div class="div col-md-12">
       
        <div class="card-header">
                <a href="add_product.php" class="btn btn-success mb-3 float-end mt-3 ">Add New product</a>
            </div>
      
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
          
                <?php
                $result = $db->getdata("*", "products", ""); 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['price']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td><img src='assests/images/{$row['image']}'  width='50' height='50'></td>";
                        echo "<td>
                              <a href='edit-product.php?id={$row['id']}' class='btn btn-primary'>Edit</a>
                              <button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
                
                </tbody>
            </table>
        </div>
       </div>
    </div>
</div>

<?php ob_end_flush()?>
<?php include('includes/footer.php')?>



<!-- JavaScript function for SweetAlert confirmation -->
<script>
function confirmDelete(productId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form when user confirms
            document.getElementById('product_id').value = productId;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>

<!-- Form for deleting product -->
<form id='deleteForm' method='post' action='delete_product.php' style='display: none;'>
    <input type='hidden' id='product_id' name='product_id' value=''>
    <input type='hidden' name='delete_product_btn'>
</form>
