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

// get data by post 
$name = validate_data($_POST['name'] ?? '');
$email = validate_data($_POST['email'] ?? '');
$password = validate_data($_POST['password'] ?? '');
$confirm_password = validate_data($_POST['confirm_password'] ?? '');
$Ext = validate_data($_POST['Ext'] ?? '');
$img = $_FILES['image'] ?? '';

if (!empty($img)) {
    $targetdirectory = "./imgs/";
    $targetfile = $targetdirectory . basename($img['name']);
    if (!move_uploaded_file($img['tmp_name'], $targetfile)) {
        $errors['image_upload'] = "Failed to upload image";
    }
}


// Validate form inputs
if (strlen($name) < 5) {
    $errors["name"] = "Name must be more than five characters";
}
//validation in pass
if (empty($_POST["password"])) {
    $errors["password"] = "Please enter your password";
} elseif (strlen($_POST["password"]) <= 8) {
    $errors["password"] = "Your Password Must Contain At Least 8 Characters";
} elseif (!preg_match("#[0-9]+#", $_POST["password"])) {
    $errors["password"] = "Your Password Must Contain At Least 1 Number";
} elseif (!preg_match("#[A-Z]+#", $_POST["password"])) {
    $errors["password"] = "Your Password Must Contain At Least 1 Capital Letter";
} elseif (!preg_match("#[a-z]+#", $_POST["password"])) {
    $errors["password"] = "Your Password Must Contain At Least 1 Lowercase Letter";
} elseif (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["password"])) {
    $errors["password"] = "Your Password Must Contain At Least 1 Special Character";
}

// Check if passwords match
if ($_POST["password"] !== $_POST["confirm_password"]) {
    $errors["confirm_password"] = "Passwords do not match";
}

//validation on email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Enter a valid email address";
}

//validation on img
if ($img['type'] !== 'image/jpeg') {
    $errors['img_type'] = "Please upload a valid JPG image";
}

// Check if there are any errors
if (empty($errors)) {
    // Add items to the table
    $data = array(
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'Ext' => $Ext,
        'image' => $targetfile ?? '' // store the image path in the database
    );

    // Add items to the table
    $data = $db->insert_row("users", $data);
    if (!$data) {
        $errors[] = "Failed to insert data";
    } else {
        header("Location: alluser.php");
        exit();
    }
}
else {
    $error_string = json_encode($errors);
    header("Location: register.php?errors=$error_string");
    exit();
}

$connection->close();


function validate_data($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>



