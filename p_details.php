<?php
include './connect.php';
session_start();

// Get the product ID from the URL
$productId = isset($_GET['p_id']) ? $_GET['p_id'] : 0;

// Fetch product details along with the category name
$productQuery = "
    SELECT p.*, c.cat_name 
    FROM products p
    JOIN category c ON p.cat_id = c.cat_id
    WHERE p.p_id = $productId
";
$productResult = $conn->query($productQuery);

// If product is found, fetch the details
if ($productResult->num_rows > 0) {
    $product = $productResult->fetch_assoc();
} else {
    // Handle the case where the product is not found
    echo "Product not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="product-details">
        <h2><?= $product['p_name'] ?></h2>
        <img src="<?= $product['p_image'] ?>" alt="<?= $product['p_name'] ?>" style="max-width: 200px;">
        <p><strong>Price:</strong> <?= $product['p_price'] ?></p>
        <p><strong>Description:</strong> <?= $product['p_description'] ?></p>
        <p><strong>Brand:</strong> <?= $product['p_brand'] ?></p>
        <p><strong>Category:</strong> <?= $product['cat_name'] ?></p>

        <!-- Add to Cart Form -->
        <form class="add-to-cart-form" method="post">
            <label for="quantity_<?= $product['p_id'] ?>">Select Quantity (in kg):</label>
            <select id="quantity_<?= $product['p_id'] ?>" name="quantity" onchange="showCustomQuantity(this)">
                <option value="1">1 kg</option>
                <option value="5">5 kg</option>
                <option value="10">10 kg</option>
                <option value="custom">Custom</option>
            </select>
            <input type="number" id="customQuantity_<?= $product['p_id'] ?>" name="customQuantity" placeholder="Enter kg" style="display:none;">
            <input type="hidden" name="product_id" value="<?= $product['p_id'] ?>">
            <button type="submit" class="cr-button" name="add_to_cart">Add to Cart</button>
        </form>
    </div>

    <script>
        function showCustomQuantity(select) {
            var customInput = select.nextElementSibling;
            if (select.value === 'custom') {
                customInput.style.display = 'block';
            } else {
                customInput.style.display = 'none';
            }
        }

        $(document).ready(function() {
            // Handle Add to Cart AJAX submission
            $(document).on('submit', '.add-to-cart-form', function(e) {
                e.preventDefault(); // Prevent the default form submission
                
                let form = $(this);
                let formData = form.serialize(); // Serialize the form data

                $.ajax({
                    url: 'add_to_cart.php', // Path to your add_to_cart.php file
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Show Add to Cart success message
                            alert(response.message); // Show success message
                        } else {
                            // Show error message in notification
                            alert(response.message); // Show error message
                        }
                    },
                    error: function() {
                        alert('An error occurred while adding the product to the cart.');
                    }
                });
            });
        });
    </script>

</body>
</html>
