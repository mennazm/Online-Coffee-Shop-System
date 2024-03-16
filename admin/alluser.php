<?php session_start();
include('includes/header.php');
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
<html>
<head>
    <title>User and Room Tables</title>
    

<body>
<?php
require('../config/dbcon.php');
$db = new db(); 
?>

<div class="contaner mt-5 ">
<div >
            <div class="card">
                <div class="card-header">
                    <h2>All Users Table</h2>
                    <a href="adduser.php" class="btn btn-primary mb-3">Add New Person</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive"> <!-- Add this div -->
                        <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Room Number</th>
                            <th>Extension</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                                $query = "SELECT u.*, r.room_number, r.Ext 
                                                FROM users u 
                                                LEFT JOIN rooms r ON u.room_id = r.room_id";
                                      
                        $result = $db->get_data_custom($query);




                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td><img src='{$row['image']}' width='50' height='50'></td>";
                                echo "<td>{$row['room_number']}</td>";
                                echo "<td>{$row['Ext']}</td>";
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
                    </tbody>
                </table>
        </div>


</div> 
                    </div>

