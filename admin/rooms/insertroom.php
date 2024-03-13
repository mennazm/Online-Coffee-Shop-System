<?php
require("../db.php");

$errors = []; // Initialize an empty array to store validation errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get room_number and Ext from POST data
    $room_number = validate_data($_POST['room_number'] ?? '');
    $Ext = validate_data($_POST['Ext'] ?? '');

    // Validate room_number and Ext (assuming they should be unique)
    if (!preg_match('/^\d{3}$/', $room_number)) {
        $errors['room_number'] = "Room number must consist of three digits";
    }

    if (!preg_match('/^\d{3}$/', $Ext)) {
        $errors['Ext'] = "Extension must consist of three digits";
    }

    // Create a new instance of the Db class to connect to the database
    $db = new Db();
    $connection = $db->get_connection();

    // Check if there are any errors in database connection
    if ($connection->connect_error) {
        die("Error in database connection: " . $connection->connect_error);
    }

    // Check if room_number already exists
    $existing_room = $db->getdata("*", "rooms", "room_number = '$room_number'");
    if ($existing_room && $existing_room->num_rows > 0) {
        $errors['room_number'] = "Room number already exists";
    }

    // Check if Ext already exists
    $existing_ext = $db->getdata("*", "rooms", "Ext = '$Ext'");
    if ($existing_ext && $existing_ext->num_rows > 0) {
        $errors['Ext'] = "Extension already exists";
    }

    // If there are no validation errors, proceed with insertion
    if (empty($errors)) {
        // Prepare data for insertion
        $data = array(
            'room_number' => $room_number,
            'Ext' => $Ext
        );

        // Insert data into the 'rooms' table
        $result = $db->insert_row("rooms", $data);

        // Check if insertion was successful
        if ($result) {
            // Redirect to the page listing all rooms
            header("Location: listAllrooms.php");
            exit();
        } else {
            $errors['database'] = "Failed to insert room into database";
        }
    }
}

function validate_data($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

