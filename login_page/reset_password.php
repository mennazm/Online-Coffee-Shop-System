<?php
session_start();
include 'db_connection.php';

$errors = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (empty($email)) {
        $errors = "Email is required!";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $_SESSION['reset_user_id'] = $row['user_id'];
                header("Location: confirm_password.php");
            } else {
                $errors = "No user found with that email.";
            }
        } else {
            $errors = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
    margin-right:7%;
    
}

label {
    font-weight: bold;
    margin-bottom: 8px;
    color: #555;
    display: block; /* Ensure label appears on a new line */
    border: 3px solid #ccc;
}

input[type="text"] {
    padding: 12px;
    margin-bottom: 16px;
    border: 3px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%; /* Make input field fill the container */
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
        <h2>Reset Password</h2>
        <?php if(!empty($errors)): ?>
            <div class="error"><?php echo $errors; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="email" id="email" placeholder="Enter your email">
            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>
