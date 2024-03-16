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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"></head>
    <style>
   #thebutton{
        background-color: #4b281e;
        color:#FBF8F2;
    }
</style>
    <body>
  
    <div class="container mt-5 p-2">
        <!-- Room Table -->
        <div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>Existing Rooms</h2>
                    <a href="addroom.php" class="btn" id="thebutton">Add New Room</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mt-3">
                            <thead >
                                <tr>
                                    <th>Room Number</th>
                                    <th>Extension</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require('../config/dbcon.php');
                                $db = new db();
                                $rooms = $db->getdata("*", "rooms");
                                if ($rooms && $rooms->num_rows > 0) {
                                    while ($row = $rooms->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['room_number'] . "</td>";
                                        echo "<td>" . $row['Ext'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='2'>No rooms found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php include('../includes/footer.php')?>
