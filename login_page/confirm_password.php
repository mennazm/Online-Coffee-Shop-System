<?php
session_start();
include ('../config/dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['reset_user_id'];
    $password = $_POST['password'];

    if (empty($password)) {
        $errors = "Password is required!";
    } else {
        $db = new db(); // Create an instance of the db class
        $result = $db->update_data('users', ['password_hash' => $password], "user_id = '$user_id'");

        if ($result) {
            header("Location: login.php");
        } else {
            $error = "Error: " . $db->getconnection()->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Confirm Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center; /* Center the content */
        }

        form {
            display: inline-block; /* To make form elements display inline */
            margin-right: 7%;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
            display: block;
            border: 3px solid #ccc;
        }

        input[type="password"] {
            padding: 12px;
            margin-bottom: 16px;
            border: 3px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            width: 100%; 
        }

        input[type="submit"] {
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Bootstrap error message styling */
        .error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid transparent;
            border-radius: .25rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>New Password</h2>
        <?php if(!empty($errors)): ?>
            <div class="error"><?php echo $errors; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="password" name="password"><br>
            <input type="submit" value="Confirm" class="btn btn-primary">
        </form>
    </div>
</body>
</html>
