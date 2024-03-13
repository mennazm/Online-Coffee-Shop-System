<?php
// calling database and make connection
require("db.php");
$db = new Db();
$connection = $db->get_connection();

// checks if there are any errors
$errors = [];
if ($connection->connect_error){
    die("error....".$connection->connect_error);
}

// Get data from POST and sanitize
$name = validate_data($_POST['name'] ?? '');
$email = validate_data($_POST['email'] ?? '');
$password = validate_data($_POST['password_hash'] ?? ''); 
$confirm_password = validate_data($_POST['confirm_password'] ?? '');
$room_number = validate_data($_POST['room_number'] ?? ''); // Updated to room number instead of room ID
$Ext = validate_data($_POST['Ext'] ?? '');

// Validate form inputs
if (strlen($name) < 5) {
    $errors["name"] = "Name must be more than five characters";
}
// Validation on password
if (empty($password)) {
    $errors["password_hash"] = "Please enter your password";
} elseif (strlen($password) < 2) {
    $errors["password_hash"] = "Your Password must be at least 2 characters long";
}

// Check if passwords match
if ($password !== $confirm_password) {
    $errors["confirm_password"] = "Passwords do not match";
}
// Validation on email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Enter a valid email address";
}

// Validate room number
$room_number = validate_data($_POST['room_number'] ?? '');
if (!preg_match('/^\d{3}$/', $room_number)) {
    $errors["room_number"] = "Room number must be three digits";
}

// Validate Ext
$Ext = validate_data($_POST['Ext'] ?? '');
if (!preg_match('/^\d{3}$/', $Ext)) {
    $errors["Ext"] = "Extension must be three digits";
}


// Validate image
$img = $_FILES['image'] ?? '';
$targetDirectory = "./imgs/";
$targetFile = $targetDirectory . $img['name'];
if (move_uploaded_file($img['tmp_name'], $targetFile)) {
    $imagePath = $targetFile;
} else {
    $errors['img_upload'] = "Failed to upload image";
}

// Check if there are any errors
if (empty($errors)) {
    // Get the room ID from the 'rooms' table
    $room_id_result = $db->get_data_custom("SELECT room_id FROM rooms WHERE room_number = '$room_number' AND Ext = '$Ext'");
    if ($room_id_result && $room_id_result->num_rows > 0) {
        $room_data = $room_id_result->fetch_assoc();
        $room_id = $room_data['room_id'];

        // Process data and insert into the database
        $data = array(
            'name' => $name,
            'email' => $email,
            'password_hash' => $password, 
            'room_number' => $room_number, // Updated to room number instead of room ID
            'Ext' => $Ext,
            'room_id' => $room_id, // Include the room_id in the data array
            'image' => $imagePath
        );

        // Insert data into the 'users' table
        $result = $db->insert_row("users", $data);
        if (!$result) {
            $errors[] = "Failed to insert data";
        } else {
            // Redirect to success page or appropriate location
            header("Location: alluser.php");
            exit();
        }
    } else {
        $errors[] = "Room number and extension not found in the 'rooms' table";
    }
}

// If there are any errors, redirect back to the registration form with error messages
$error_string = json_encode($errors);
header("Location: adduser.php?errors=$error_string");
exit();

$connection->close();

function validate_data($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
