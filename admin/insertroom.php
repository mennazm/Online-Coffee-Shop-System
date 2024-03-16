<?php

require('../config/dbcon.php');

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize errors array
    $errors = [];

    // Get room_number and Ext
    $room_number = validate_data($_POST['room_number'] ?? '');
    $Ext = validate_data($_POST['Ext'] ?? '');

    // Validate room_number and Ext (they should be unique)
    if ($room_number === '') {
        $errors['room_number'] = "Room number is required";
    } elseif (!preg_match('/^\d{3}$/', $room_number)) {
        $errors['room_number'] = "Room number must consist of three digits";
    }

    if ($Ext === '') {
        $errors['Ext'] = "Extension is required";
    } elseif (!preg_match('/^\d{3}$/', $Ext)) {
        $errors['Ext'] = "Extension must consist of three digits";
    } elseif ($Ext === '111') {
        $errors['Ext'] = "Extension cannot be 111";
    }

    if ($room_number !== $Ext) {
        $errors['matching'] = "Room number and Extension must match";
        $errors['room_number'] = "Room number and Extension must match";
        $errors['Ext'] = "Room number and Extension must match";
    }

    // Create a new instance of the Db class to connect to the database
    $db = new db();
    $connection = $db->getconnection();

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

// Store errors in session
session_start();
$_SESSION['errors'] = $errors;

// Redirect back to the form page
header("Location: addroom.php");
exit();

function validate_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
