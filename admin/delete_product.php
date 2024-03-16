 <?php

require('../config/dbcon.php');

// Check if the 'delete_product_btn' form button is set
if(isset($_POST['delete_product_btn'])) {
    
    $db = new db();
    
    
    $product_id = $_POST['product_id']; 
    echo "Product ID: $product_id"; // Debugging statement
 
    
    $product_orders = $db->getProductOrders($product_id);
    echo "Number of Product Orders: " . $product_orders->num_rows; // Debugging statement
    
    // If the product has orders, delete them first
    if ($product_orders->num_rows > 0) {
        while ($order = $product_orders->fetch_assoc()) {
            $order_id = $order['order_id'];
            
            // Delete order items associated with this order
            $result_order_items = $db->delete('order_items', "order_id = $order_id");
            
            
            // Delete the order
            $result_orders = $db->delete('orders', "order_id = $order_id");
        }
    }
    
    
    $result_product = $db->delete("products", "product_id = $product_id");
   
    if ($result_product) {
        echo "Product deleted successfully";
        
        // Redirect the user back to the products page
        header('Location: products.php');
        exit(); 
    } else {
        echo "Failed to delete product.";
        
    }
} else {
    echo "Delete button is not set in the POST data.";
}
?>








