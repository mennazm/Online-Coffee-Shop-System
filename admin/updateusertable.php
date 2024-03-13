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

    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6">
                <div class="card p-3">
                    <form method="post" enctype="multipart/form-data" action="updateuser.php" onsubmit="return validateForm()">
                    <?php
                    // Include the database connection file
                    require("db.php");

                    // Get the user ID from the URL parameter
                    $user_id = $_GET['id'];

                    // Create a new instance of the DB class
                    $db = new DB();

                    // Get the user data from the database
                    $user = $db->getdata("*", "users", "user_id = $user_id");

                    if ($user) {
                        $row = mysqli_fetch_assoc($user); // Fetch the user data as an associative array
                    } else {
                        echo "User not found";
                        exit(); // Exit if user not found
                    }
                    ?>

                        <input type="hidden" name="id" value="<?php echo $user_id; ?>"> <!-- Hidden field to store the user ID -->

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="img">Image</label>
                            <input type="file" class="form-control" id="img" name="image">
                            <input type="hidden" name="image" value="<?php echo $row['image'] ?>"> <!-- Hidden field to store the current image path -->
                        </div>
                        <div class="mb-3">
                            <label for="room_number" class="form-label">Room Number:</label>
                            <select class="form-select" id="room_number" name="room_number">
                                <option selected disabled>Select Room Number</option>
                                <?php 
                                // Fetch room numbers from rooms table
                                $roomsResult = $db->getdata("room_number", "rooms", ""); 
                                while ($room = $roomsResult->fetch_assoc()) { 
                                    echo "<option value=\"{$room['room_number']}\"";
                                    if ($room['room_number'] == $row['room_number']) {
                                        echo " selected";
                                    }
                                    echo ">{$room['room_number']}</option>"; 
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Dropdown list for Ext -->
                        <div class="mb-3">
                            <label for="Ext" class="form-label">Extension:</label>
                            <select class="form-select" id="Ext" name="Ext">
                                <option selected disabled>Select Ext</option>
                                <?php 
                                // Fetch Ext values from rooms table
                                $extsResult = $db->getdata("Ext", "rooms", ""); 
                                while ($ext = $extsResult->fetch_assoc()) { 
                                    echo "<option value=\"{$ext['Ext']}\"";
                                    if ($ext['Ext'] == $row['Ext']) {
                                        echo " selected";
                                    }
                                    echo ">{$ext['Ext']}</option>"; 
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-lg btn-danger">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var roomNumber = document.getElementById("room_number").value;
            var extension = document.getElementById("Ext").value;

            if (roomNumber !== extension) {
                alert("Room Number and Extension must have the same ID");
                return false;
            }
        }
    </script>

</body>
</html>
