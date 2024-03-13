<?php
session_start();
include 'db_connection.php'; 
$errors = []; // Define an array to hold validation errors

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate email and password
    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required!";
    } 
     else {
         // Validate email format
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }
        // Prepare and execute the query to select email and password from users table
        $sql = "SELECT * FROM users WHERE email = ? AND password_hash = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if($row['role'] == 'admin'){
              $_SESSION['email'] = $row['email'];
              header('location:admin.php');
              exit();
           } elseif($row['role'] == 'user'){
              $_SESSION['email'] = $row['email'];
              header('location:user.php');
              exit();
           } 
       
      }
       
        
      else{
        $errors[] = "error password or User does not exist";
        // exit();

    }
        $stmt->close();

    }
    

    $conn->close();
}

// If there are validation errors or if the form is not submitted, redirect to login page
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->



  <style>
   .image {
  background-image: url('images/background.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat; /* Set background image to not repeat */
}

.card {
  border-radius: 1rem;
  max-width: 500px;
  margin: auto;
  margin-top:60px;
  margin-right:34%;
  box-shadow: 0 4px 7px rgba(0, 0, 0, 0.3);
  color: #fff;
  background-color: rgba(0, 0, 0, 0.7);
}

.card-body {
  padding: 2rem;
}

input[type="email"],
input[type="password"] {
  padding: 12px;
  margin-bottom: 15px;
  width: 100%;
  border: none;
  background-color: rgba(255, 255, 255, 0.1);
  color: #fff;
  border-radius: 10px;
}

input[type="email"]::placeholder,
input[type="password"]::placeholder {
  color: rgba(255, 255, 255, 255);
}

button.btn {
      border-radius: 15px;
      color:white;
      width:35%;
      background-color:rgba(0,0,0,0.7);
      border:none;
      border-radius:10px;
      box-shadow:inset -3px -3px rgba(0,0,0,0.7);
    }

.login-heading {
  text-align: center;
  margin-bottom: 2rem;
  color: #fff;
}

a {
  color: #fff;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

  </style>
</head>
<body>
  <section class="vh-100 image">
    <div class="container py-5">
      <div class="row d-flex justify-content-center">
        <div class="col">
          <div class="card">
            <div class="card-body p-3">
              <h1 class="login-heading fw-bold mb-3 ">Cafeteria</h1>

<!-- ظظظظظظظظظظظظظظظظظظظظظظظظظظظظظ -->

              <!-- Display error messages -->
              <?php
              // Check if there are any error messages stored in the session
              if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
                  // Display each error message as a Bootstrap alert
                  foreach ($_SESSION['errors'] as $error) {
                      echo '<div class="alert alert-danger" role="alert">';
                      echo $error;
                      echo '</div>';
                  }

                  // Clear the errors from the session
                  unset($_SESSION['errors']);
              }
              ?>
   <!-- ظظظظظظظظظظظظظظظظظظظظظظظظظظظظظظظظظظظظ -->


              <form class="p-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              
                  <div  role="alert">
                      
                  </div>
               

                <div class="form-outline mb-4">
                  <input type="email" id="email" name="email" placeholder="Enter Your Email" />
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="password" name="password" placeholder="Enter Your Password" />
                </div>

                <div class="pt-1 mb-4">
                  <button class="btn btn-success btn-lg d-block mx-auto" type="submit" value="Login">Login</button>
                </div>

                <a href="reset_password.php">Forget password?</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
