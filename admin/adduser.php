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
include('includes/header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .error-message {
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <?php
    $errors = [];
    if(isset($_GET['errors'])){
        $errors = json_decode($_GET['errors'], true);
    }

    ?>

    <div class="container">
        <h1 class="mt-4">User Registration</h1>
        <div class="container mt-4">
            <form class="row g-3" action="insertuser.php" method="POST" enctype="multipart/form-data" onsubmit="return validate()">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <?php if(isset($errors['name'])): ?>
                        <div class="error-message"><?= $errors['name'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                    <?php if(isset($errors['email'])): ?>
                        <div class="error-message"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password_hash">
                    <?php if(isset($errors['password_hash'])): ?>
                        <div class="error-message"><?= $errors['password_hash'] ?></div>
                    <?php endif; ?>
                    <?php if(isset($errors['match'])): ?>
                        <div class="error-message"><?= $errors['match'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <?php if(isset($errors['password_hash'])): ?>
                        <div class="error-message"><?= $errors['password_hash'] ?></div>
                    <?php endif; ?>
                    <?php if(isset($errors['match'])): ?>
                        <div class="error-message"><?= $errors['match'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="room_number" class="form-label">Room Number</label>
                    <select class="form-select" id="room_number" name="room_number" required>
                        <option selected disabled>Select Room Number</option>
                        <?php 
                             require('../config/dbcon.php');
                                $db = new db();
                        $query = "SELECT u.*, r.room_number ,
                        FROM users u 
                        LEFT JOIN rooms r ON u.room_id = r.room_id";
              
              
                        $rooms = $db->getdata("room_number", "rooms", ""); // Fetch room numbers from rooms table
                        while ($row = $rooms->fetch_assoc()) { // Loop through room numbers
                            echo "<option value=\"{$row['room_number']}\">{$row['room_number']}</option>"; // Display room number as option
                        }
                        ?>
                    </select>
                    <?php if(isset($errors['room_number'])): ?>
                        <div class="error-message"><?= $errors['room_number'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Ext" class="form-label">Extension</label>
                    <select class="form-select" id="Ext" name="Ext" required>
                        <option selected disabled>Select Extension</option>
                        <?php 
                        $exts = $db->getdata("Ext", "rooms", ""); // Fetch Ext values from rooms table
                        while ($row = $exts->fetch_assoc()) { // Loop through Ext values
                            echo "<option value=\"{$row['Ext']}\">{$row['Ext']}</option>"; // Display Ext value as option
                        }
                        ?>
                    </select>
                    <?php if(isset($errors['Ext'])): ?>
                        <div class="error-message"><?= $errors['Ext'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <?php if(isset($errors['img_upload'])): ?>
                        <div class="error-message"><?= $errors['img_upload'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                   <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

