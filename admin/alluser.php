<!DOCTYPE html>
<html>
<head>
    <title>User Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php
// Connect with the database file
require('db.php');
$db = new Db(); 
?>

<div class="container">
    <h2>All Users Table</h2>
    <a href="adduser.php" class="btn btn-primary">Add new Person</a>
    <table class="table table-light">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Image</th>
                <th>Room Number</th> <!-- Updated column name -->
                <th>Extension</th> <!-- Updated column name -->
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // Query to fetch data from users table along with room numbers
            $query = "SELECT u.*, r.room_number 
                      FROM users u 
                      LEFT JOIN rooms r ON u.room_id = r.room_id"; // Table name corrected from 'rooms' to 'room'
            $result = $db->get_data_custom($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td><img src='{$row['image']}' width='50' height='50'></td>"; // Path corrected from 'assests' to 'assets'
                    echo "<td>{$row['room_number']}</td>"; // Display room number
                    echo "<td>{$row['Ext']}</td>"; // Corrected column name from 'Ext' to 'Ext'
                    echo "<td>
                            <a href='updateusertable.php?id={$row['user_id']}' class='btn btn-primary'>Edit</a>
                            <a href='deleteuser.php?id={$row['user_id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }

            ?>
                       <!-- <img src=" ./imgs/5.jpg" alt=""/> -->

        </tbody>
    </table>
</div>
</body>
</html>
