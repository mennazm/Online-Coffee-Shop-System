<?php
require_once('../config/dbcon.php');
$db = new db();
?>

<div class="container">
    <div class="row">
        <?php
        $result = $db->getdata("*", "products", "");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-3">
                    <div class="card each-order position-relative" data-product-id="<?php echo $row['id']; ?>">
                        <img src='../assests/images/<?php echo $row['image']; ?>' class="card-img-top" alt="Product Image" style="height: 130px; width:100%">
                        <div class="card-body">
                            <div class="price-circle">
                                <div class="price"><?php echo $row['price']; ?> LE</div>
                            </div>
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <input type="text" name="<?php echo $row['name']; ?>" value="<?php echo $row['price']; ?>" hidden />
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='col-md-12'><p>No records found</p></div>";
        }
        ?>
    </div>
</div>

<style>
  
</style>
