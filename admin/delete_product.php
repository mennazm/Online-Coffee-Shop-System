
 <?php
//Include the file containing the db class
require('../config/dbcon.php');

// Create database object
$database = new db();

if(isset($_POST['delete_product_btn'])) 
{
    $id = $_POST['product_id']; 
    $result = $database->delete("products", "id = $id");
    if ($result) {
        echo "Product deleted successfully";
        
        
        header( 'Location: products.php' ) ;    
    } else {
        echo "Failed to delete product.";
    }
} 
else {
    echo "ID is missing from the URL.";
}
?>   


