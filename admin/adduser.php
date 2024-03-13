<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <script>
    function validate() {
      var a = document.getElementById("password").value;
      var b = document.getElementById("confirm_password").value;
      if (a != b) {
        alert("Passwords do not match");
        return false;
      }

      var roomNumber = document.getElementById("room_number").value;
      var extension = document.getElementById("Ext").value;

      if (roomNumber !== extension) {
        alert("Room Number and Extension must have the same ID");
        return false;
      }
    }
  </script>
</head>
<body>
  <?php
  $errors = [];
  if(isset($_GET['errors'])){
    $errors = json_decode($_GET['errors'], true);
  }
  ?>  

  <div class="container">
    <h1 class="m-2 p-2">User Registration</h1>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
    <div class="container">
      <form class="p-3 m-4" action="insertuser.php" method="POST" enctype="multipart/form-data" onsubmit="return validate()">
        <div class="row">
          <div class="mb-3 col-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
            <?php if(isset($errors['name'])): ?>
              <div class="text-danger"><?= $errors['name'] ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3 col-6">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email">
            <?php if(isset($errors['email'])): ?>
              <div class="text-danger"><?= $errors['email'] ?></div>
            <?php endif; ?>
          </div>
        </div>
        <div class="row">
          <div class="mb-3 col-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password_hash">
          </div>
          <div class="mb-3 col-6">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
          </div>
        </div>
        <div class="row">
          <div class="mb-3">
            <label for="room_number" class="form-label">Room Number:</label>
            <select class="form-select" id="room_number" name="room_number" required>
              <option selected disabled>Select Room Number</option>
              <?php 
              require("db.php"); // Include database connection file
              $db = new Db(); // Create Db instance
              $rooms = $db->getdata("room_number", "rooms", ""); // Fetch room numbers from rooms table
              while ($row = $rooms->fetch_assoc()) { // Loop through room numbers
                echo "<option value=\"{$row['room_number']}\">{$row['room_number']}</option>"; // Display room number as option
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="Ext" class="form-label">Extension:</label>
            <select class="form-select" id="Ext" name="Ext" required>
              <option selected disabled>Select Ext</option>
              <?php 
              $exts = $db->getdata("Ext", "rooms", ""); // Fetch Ext values from rooms table
              while ($row = $exts->fetch_assoc()) { // Loop through Ext values
                echo "<option value=\"{$row['Ext']}\">{$row['Ext']}</option>"; // Display Ext value as option
              }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="mb-3 col-6">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if(isset($errors['image_type'])): ?>
              <div class="text-danger"><?= $errors['image_type'] ?></div>
            <?php endif; ?>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</body>
</html>
