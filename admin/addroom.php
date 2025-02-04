<?php session_start()
?>
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
$errors = $_SESSION['errors'] ?? [];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
   #thebutton{
        background-color: #4b281e;
        color:#FBF8F2;
    }
</style>
</head>
<body>
    <div class="container mt-5">
        <h1>Add Room</h1>
        <form action="insertroom.php" method="POST" onsubmit="return validateForm();">
            <div class="mb-3">
                <label for="room_number" class="form-label">Room Number:</label>
                <input type="text" class="form-control <?= isset($errors['room_number']) ? 'is-invalid' : '' ?>" id="room_number" name="room_number" value="<?= isset($_POST['room_number']) ? htmlspecialchars($_POST['room_number']) : '' ?>">
                <?php if (isset($errors['room_number'])): ?>
                    <div class="invalid-feedback"><?= $errors['room_number'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="Ext" class="form-label">Extension:</label>
                <input type="text" class="form-control <?= isset($errors['Ext']) ? 'is-invalid' : '' ?>" id="Ext" name="Ext" value="<?= isset($_POST['Ext']) ? htmlspecialchars($_POST['Ext']) : '' ?>">
                <?php if (isset($errors['Ext'])): ?>
                    <div class="invalid-feedback"><?= $errors['Ext'] ?></div>
                <?php endif; ?>
            </div>
            <?php if (isset($errors['database'])): ?>
                <div class="alert alert-danger"><?= $errors['database'] ?></div>
            <?php endif; ?>
            <button type="submit" class="btn" id='thebutton'>Add Room</button>
        </form>
    </div>
 
<?php 
// Clear the errors
$_SESSION['errors'] = [];
include('../includes/footer.php');
?>
