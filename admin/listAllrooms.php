<?php 
session_start();
include('../includes/header.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Rooms</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

  <div class="container mt-5">
    <!-- Room Table -->
    <div>

      <h2>Existing Rooms</h2>
      <a href="addroom.php" class="btn btn-primary">Add New Room</a>
      <table class="table">
        <thead>
          <tr>
            <th>Room Number</th>
            <th>Extension</th>
            <th>Actions</th>
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
                  echo "<td>
                  <a href='deleteroom.php?id={$row['room_id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                </td>";
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

</body>
</html>
<?php include('../includes/footer.php')?>

