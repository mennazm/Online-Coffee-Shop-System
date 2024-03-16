<?php
require('../config/dbcon.php');
$db = new db();
$connection = $db->getconnection();

$errors = [];
if ($connection->connect_error){
    die("error....".$connection->connect_error);
}

$name = validate_data($_POST['name'] ?? '');
$email = validate_data($_POST['email'] ?? '');
$password = validate_data($_POST['password_hash'] ?? ''); 
$confirm_password = validate_data($_POST['confirm_password'] ?? '');
$room_number = validate_data($_POST['room_number'] ?? '');
$Ext = validate_data($_POST['Ext'] ?? '');

if (strlen($name) < 5) {
    $errors["name"] = "Name must be more than five characters";
}

if (empty($password)) {
    $errors["password_hash"] = "Please enter your password";
} elseif (strlen($password) < 2) {
    $errors["password_hash"] = "Your Password must be at least 2 characters long";
}

if ($password !== $confirm_password) {
    $errors["confirm_password"] = "Passwords do not match";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Enter a valid email address";
}

if (!preg_match('/^\d{3}$/', $room_number)) {
    $errors["room_number"] = "Room number must be three digits";
}

if (!preg_match('/^\d{3}$/', $Ext)) {
    $errors["Ext"] = "Extension must be three digits";
}

$img = $_FILES['image'] ?? '';
$targetDirectory = "../assests/images/";
$targetFile = $targetDirectory . basename($img['name']);
if (move_uploaded_file($img['tmp_name'], $targetFile)) {
    $imagePath = $targetFile;
} else {
    $errors['img_upload'] = "Failed to upload image";
}

if (empty($errors)) {
    $data = array(
        'name' => $name,
        'email' => $email,
        'password_hash' => $password, 
        'room_number' => $room_number,
        'Ext' => $Ext,
        'image' => $imagePath
    );

    $result = $db->insert_row("users", $data);
    if (!$result) {
        $errors[] = "Failed to insert data";
    } else {
        header("Location: alluser.php");
        exit();
    }
} else {
    $error_string = json_encode($errors);
    header("Location: adduser.php?errors=$error_string");
    exit();
}

$connection->close();

function validate_data($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
