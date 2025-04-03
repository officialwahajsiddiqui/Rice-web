<?php
include 'db.php';

if (isset($_GET['p_id'])) {
    $p_id = filter_var($_GET['p_id'], FILTER_VALIDATE_INT);

    if ($p_id) {
        try {
            // Begin a transaction
            $conn->beginTransaction();

            // Delete related order items first
            $stmtDeleteOrderItems = $conn->prepare("DELETE FROM order_items WHERE product_id = :product_id");
            $stmtDeleteOrderItems->execute([':product_id' => $p_id]);

            // Delete related entry in the popular_products table
            $stmtDeletePopular = $conn->prepare("DELETE FROM popular_products WHERE p_id = :p_id");
            $stmtDeletePopular->execute([':p_id' => $p_id]);

            // Delete the product image from the server
            $stmt = $conn->prepare("SELECT p_image FROM products WHERE p_id = :p_id");
            $stmt->execute([':p_id' => $p_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $image_path = '../uploads/' . $product['p_image'];
                if (file_exists($image_path)) {
                    unlink($image_path); // Delete the image file
                }
            }

            // Delete the product from the products table
            $stmtDelete = $conn->prepare("DELETE FROM products WHERE p_id = :p_id");
            $stmtDelete->execute([':p_id' => $p_id]);

            // Commit the transaction
            $conn->commit();

            // Redirect back to the product list page with a success message
            header("Location: Allproducts.php?message=Product deleted successfully");
            exit;
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            $conn->rollBack();
            echo "<p style='color:red;'>Failed to delete product: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Invalid product ID.</p>";
    }
} else {
    echo "<p style='color:red;'>Product ID not specified.</p>";
}
?>
