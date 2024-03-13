<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Update Room</h1>
        <?php
        require("../db.php");
        $db = new Db();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $room_id = $_POST['id'];
            $room_number = $_POST['room_number'];
            $Ext = $_POST['Ext'];

            $update_data = array(
                'room_number' => $room_number,
                'Ext' => $Ext
            );

            $result = $db->update_row("rooms", $update_data, "room_id = $room_id");

            if ($result) {
                header("location: listAllrooms.php");
                echo "<div class='alert alert-success'>Room updated successfully</div>";
            } else {
                echo "<div class='alert alert-danger'>Error updating room</div>";
            }
        } else {
            $room_id = $_GET['id'];
            $room = $db->getdata("*", "rooms", "room_id = $room_id");
            if ($room && $room->num_rows > 0) {
                $row = $room->fetch_assoc();
        ?>
                <form action="updateroom.php" method="POST" onsubmit="return validateForm();">
                    <input type="hidden" name="id" value="<?php echo $room_id; ?>">
                    <div class="mb-3">
                        <label for="room_number" class="form-label">Room Number:</label>
                        <input type="text" class="form-control" id="room_number" name="room_number" value="<?php echo $row['room_number']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Ext" class="form-label">Extension:</label>
                        <input type="text" class="form-control" id="Ext" name="Ext" value="<?php echo $row['Ext']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Room</button>
                </form>
        <?php
            } else {
                echo "Room not found";
            }
        }
        ?>
    </div>
    <script>
        function validateForm() {
            var roomNumber = document.getElementById("room_number").value;
            var extension = document.getElementById("Ext").value;

            if (roomNumber !== extension) {
                alert("Room Number and Extension must have the same ID");
                return false;
            }
            return true; // Return true if validation passes
        }
    </script>
</body>
</html>
