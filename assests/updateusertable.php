<?php
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

header("Location: ../login_page/login.php");
exit();
}
//var_dump($_SESSION);
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"];
include('includes/navbar.php');
?>
<?php
//session_start();
$errors = $_SESSION['errors'] ?? [];
include('includes/navbar.php');

// Move the unset after displaying errors
unset($_SESSION['errors']); // Clear the errors array after displaying errors

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <!-- Assuming you have Bootstrap CSS included -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php
  $errors = [];
  if(isset($_GET['errors'])){
    $errors = json_decode($_GET['errors'], true);
  }
  ?>

    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6">
                <div class="card p-3">
                    <form method="post" enctype="multipart/form-data" action="updateuser.php" onsubmit="return validateForm()">
                        <?php
                        // Include the database connection file
                        require('../config/dbcon.php');
                        $db = new db();

                        // Get the user ID from the URL parameter
                        $user_id = $_GET['id'];

                        // Get the user data from the database using the user_id directly in the SQL query
                        $user = $db->getdata("*", "users", "user_id = $user_id");

                        if ($user) {
                            $row = mysqli_fetch_assoc($user); // Fetch the user data as an associative array
                            // Now you can access the user data using $row['column_name']
                        } else {
                            echo "User not found";
                            exit();
                        }
                        ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name'] ?>">
                            <?php if(isset($errors['name'])): ?>
                            <div class="text-danger"><?= $errors['name'] ?></div>
                            <?php endif; ?>       
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>">
                            <?php if(isset($errors['email'])): ?>
                            <div class="text-danger"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="img">Image</label>
                            <input type="file" class="form-control" id="img" name="image">
                            <input type="hidden" name="image" value="<?php echo $row['image'] ?>"> <!-- Hidden field to store the current image path -->
                            <?php if(isset($errors['img_upload'])) echo '<div class="text-danger">'.$errors['img_upload'].'</div>'; ?> <!-- Display image upload error -->
                        </div>
                        <div class="mb-3">
                            <label for="room_number" class="form-label">Room Number:</label>
                            <select class="form-select" id="room_number" name="room_number">
                                <option selected disabled>Select Room Number</option>
                                <?php 
                        $query = "SELECT u.*, r.room_number ,
                        FROM users u 
                        LEFT JOIN rooms r ON u.room_id = r.room_id";
              
              
                        $rooms = $db->getdata("room_number", "rooms", ""); 
                        while ($row = $rooms->fetch_assoc()) { // Loop through room numbers
                            echo "<option value=\"{$row['room_number']}\">{$row['room_number']}</option>"; // Display room number as option
                        }
                        ?>
                                     
                            </select>
                            <?php if(isset($errors['matching'])) echo '<div class="text-danger">'.$errors['matching'].'</div>'; ?> <!-- Display matching validation error -->
                        </div>
                        <!-- Dropdown list for Ext -->
                        <div class="mb-3">
                            <label for="Ext" class="form-label">Extension:</label>
                            <select class="form-select" id="Ext" name="Ext">
                                <option selected disabled>Select Ext</option>
                                <?php 
                        $exts = $db->getdata("Ext", "rooms", ""); // Fetch Ext values from rooms table
                        while ($row = $exts->fetch_assoc()) { // Loop through Ext values
                            echo "<option value=\"{$row['Ext']}\">{$row['Ext']}</option>"; // Display Ext value as option
                        }
                        ?>
                            </select>
                            <?php if(isset($errors['matching'])) echo '<div class="text-danger">'.$errors['matching'].'</div>'; ?> <!-- Display matching validation error -->

                        </div>
                        <button type="submit" class="btn btn-lg btn-danger">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>
        function validateForm() {
            var roomNumber = document.getElementById("room_number").value;
            var extension = document.getElementById("Ext").value;

            if (roomNumber !== extension) {
                alert("Room Number and Extension must have the same ID");
                return false;
            }
        }
    </script> -->

</body>
</html>
