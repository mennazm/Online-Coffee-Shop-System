<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
        <i class="fas fa-gem me-3"></i><span c>Cafeteria</span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  mx-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="../user/userhome.php">Home</a>
                    </li>  
                    <li class="nav-item">
                    <a class="nav-link" href="../user/user-orders.php">My Orders</a>
                    </li>
                </ul>
                <div class="user-info" style="margin-left:600px;">
                <div class="d-flex align-items-center">
                <?php
                echo "<img class='img-fluid w-30' src='../assests/images/$image' alt='$username' title='$username' width='50' height='50'/>";
				echo "<p class='mt-3 mx-2'>$username</p>";
                ?>
                </div>
          
        </div>
            </div>
        </div>
    </nav>
