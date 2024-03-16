<?php

session_start();
require('../config/dbcon.php');
$db = new db();
$connection = $db->getconnection();
$errors = [];
if ($connection->connect_error){
    die("error....".$connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   // Get data from POST and sanitize
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$room_number = $_POST['room_number'] ?? ''; 
$Ext = $_POST['Ext'] ?? '';
// Get the current image path from the form
$current_image = $_POST['image'];
$user_id= $_POST['id'];
   
    // Check if room_number and Ext match
    if ($room_number !== $Ext) {
        $errors['matching'] = "Room number and Extension must match";
    }

    // name
    if (strlen($name) < 5) {
        $errors["name"] = "Name must be more than five characters";
    }

    // Validation on email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Enter a valid email address";
    }


    // Check if a new image file has been uploaded
    if (!empty($_FILES['image']['name'])) {
        // Get the new image file from the form
        $image = $_FILES['image']['name'];

        // Specify the path to the 'imgs' folder
        $target_dir = "./assests/images/";

        // Create the full path for the image file
        $target_file = $target_dir . basename($image);

        // Move the uploaded file to your target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Update the image path with the new one
            $image_path = $target_file;
        } else {
            $errors['img_upload'] = "Sorry, there was an error uploading your file.";
            // Keep the current image path if the upload fails
            $image_path = $current_image;
        }
    } else {
        // If no new image is uploaded, keep the current image path
        $image_path = $current_image;
    }

    // If there are no errors, proceed with updating the user data
    if (empty($errors)) {
        $room_id_result = $db->getdata("room_id, room_number, Ext", "rooms" ,"room_number = '$room_number' AND Ext = '$Ext'");
        if ($room_id_result && $room_id_result->num_rows > 0) {
            $room_data = $room_id_result->fetch_assoc();
            $room_id = $room_data['room_id'];
            $room_number = $room_data['room_number'];
            $Ext = $room_data['Ext'];
            $data = array(
                'name' => $name,
                'email' => $email,
                'image' => $image_path,
                'room_number' => $room_number,
                'Ext' => $Ext,
                'room_id' => $room_id


            );

            // Update the user record with the room ID, room_number, and Ext
            $result = $db->update_data("users", $data, "user_id = $user_id");

            if (!$result) {
                $errors[] = "Failed to update data";
            } else {
                // Redirect to success page or appropriate location
                header("Location: alluser.php");
                exit();
            }
    
        }
    }
    
    // If there are any errors, redirect back to the registration form with error messages
    $error_string = json_encode($errors);
    header("Location: updateusertable.php?id={$_POST['id']} && errors=$error_string");
    exit();
    
    $connection->close();
    

    
}
?>
