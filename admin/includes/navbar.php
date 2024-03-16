<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
