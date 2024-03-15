<?php
 //var_dump($_SESSION);
 ob_start();
include('includes/header.php')?>

<?php
require('../config/dbcon.php');
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

    header("Location: ../login_page/login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"];

if(isset($_POST['submit'])) {
    // Validation
    $errors = array();

    // Name validation
    if(empty($_POST['name'])) {
        $errors[] = 'Name field is required';
    } else {
        $name = $_POST['name'];
        // Check if name is within the allowed length
        if(strlen($name) < 2 || strlen($name) > 50) {
            $errors[] = 'Name must be between 2 and 50 characters';
        }
    }

    // If no validation errors, proceed with database insertion
    if(empty($errors)) {
        // Create database object
        $database = new db();
        
        // Insert data into the database
        $tableName = 'categories';
        $columns = ['name'];
        $values = [$name];
        $result = $database->insert_data($tableName, $columns, $values);
        
          
        if($result) {
            $_SESSION['message'] = "Category added successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to add category";
            $_SESSION['message_type'] = "error";
        }
    }

     else {
        // If there are validation errors, display them
        foreach($errors as $error) {
            $_SESSION['message'] = $error;
            $_SESSION['message_type'] = "error";
        }
    }


}

?>
<div class="container mt-3">
    <div class="row">
      <div class ="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Add Category</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form method="post">  
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control">
                            <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
<?php ob_end_flush()?>
<?php include('includes/footer.php')?>





