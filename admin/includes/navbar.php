<head>

<title>
    Coffee Shop
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link rel="stylesheet" href="../assests/css/home.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link id="pagestyle" href="assests/css/material-dashboard.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

</head>
<style>
    body{
    background-color: #FBF8F2;
}
nav,footer{
    background-color: #93634C;
    color: #FBF8F2;
}
.navbar a{
    color: #FBF8F2;
}
.navbar a:hover{
    color: #FBF8F2;
}
h1,h2,h3,h4,h5,th{
    color: #4b281e;
}
.each-order img{
    width: 20vw;
    height: 30vh;
}
input[name='filter']{
    background-color: #93634C;
}
@media (min-width: 992px) {
        .user-info {
            margin-left: 400px; 
        }
    }
  
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <i class="fas fa-gem me-3"></i><span c>Cafeteria</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-4">
                <li class="nav-item">
                    <a class="nav-link active" href="./adminhome.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./alluser.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./listAllrooms.php">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./admin_orders.php">Manual orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Checks</a>
                </li>  
            </ul>
            
            <div class="user-info ml-auto" >
                <div class="d-flex align-items-center">
                    <?php
                    echo "<img src='../assests/images/$image' alt='$username' title='$username' class='img-fluid' style='width: 60px; height: 60px;border-radius-none' />";
                    echo "<p class='mt-3 mx-2'>$username</p>";
                    ?>
                </div>
            </div>
            
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
