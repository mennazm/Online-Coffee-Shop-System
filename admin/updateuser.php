
<?php
require('../config/dbcon.php');
$db = new db();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $room_number = $_POST['room_number'];
    $Ext = $_POST['Ext'];

    // Get the current image path from the form
    $current_image = $_POST['image'];

  //*********************the validation */
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
// Validate image
$img = $_FILES['image'] ?? '';
$targetDirectory = "./assests/images/";
$targetFile = $targetDirectory . $img['name'];
if (move_uploaded_file($img['tmp_name'], $targetFile)) {
    $imagePath = $targetFile;
} else {
    $errors['img_upload'] = "Failed to upload image";
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
            echo "Sorry, there was an error uploading your file.";
            // Keep the current image path if the upload fails
            $image_path = $current_image;
        }
    } else {
        // If no new image is uploaded, keep the current image path
        $image_path = $current_image;
    }

    $room_id_result = $db->getdata("room_id, room_number, Ext", "rooms" ,"room_number = '$room_number' AND Ext = '$Ext'");
   // $room_id_result = $db->get_data_custom("SELECT room_id, room_number, Ext FROM rooms WHERE room_number = '$room_number' AND Ext = '$Ext'");
    if ($room_id_result && $room_id_result->num_rows > 0) {
        $room_data = $room_id_result->fetch_assoc();
        $room_id = $room_data['room_id'];
        $room_number = $room_data['room_number'];
        $Ext = $room_data['Ext'];
    
        // Debugging: Print room ID for verification
        echo "Room ID found: $room_id<br>";
    
        // Update the user record with the room ID, room_number, and Ext
        $data = $db->update_data("users", [
            'name' => $name,
            'email' => $email,
            'image' => $image_path,
            'room_number' => $room_number,
            'Ext' => $Ext,
            'room_id' => $room_id
        ], "user_id = $user_id");
    
        if ($data) {
            // Redirect to success page or appropriate location
            header("Location: alluser.php");
            exit();
        } else {
            echo "Failed to update user data.";
        }
    } else {
        echo "Invalid room number or extension.";
    }
}
?>
