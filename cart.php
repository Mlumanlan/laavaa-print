<?php
include('connection.php');

// Fetch cart items for display
$query = "SELECT name, types, style, quantity, price FROM cart";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data from the request
    $product_name = $_POST['product_name'];
    $types = $_POST['types'];
    $style = $_POST['style'];
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $total = $quantity * $price;

    // Create an array for the current item
    $item = [
        'product_name' => $product_name,
        'types' => $types,
        'style' => $style,
        'quantity' => $quantity,
        'price' => $price,
        'total' => $total,
    ];

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the current item to the cart session
    $_SESSION['cart'][] = $item;
}

// Display cart items
$cartItems = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css"> <!-- Link your CSS file here -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cartIcon = document.querySelector(".icons a[href='cart.php']");
            const addToCartButton = document.querySelector(".add-to-cart");

            cartIcon.addEventListener("click", function (event) {
                event.preventDefault();
                document.getElementById("cartModal").style.display = "block";
            });

            if (addToCartButton) {
                addToCartButton.addEventListener("click", function (event) {
                    event.preventDefault();
                    document.getElementById("cartModal").style.display = "block";
                });
            }
            
            // Close modal functionality
            document.querySelector(".close-cart").addEventListener("click", function() {
                document.getElementById("cartModal").style.display = "none";
            });
        });
    </script>
</head>
<body>

    <!-- Your existing cart page content goes here -->
    <!-- Example icon to trigger the cart modal -->
    <div class="icons">
        <a href ="cart.php"></a>
    </div>

    <!-- Cart Modal HTML -->
    <div id="cartModal">
        <button class="close-cart">&times;</button>
        <h2>Your Cart</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                foreach ($cartItems as $item) {
                    $grandTotal += $item['total'];
                    ?>
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center;">
                                <img src="pen1.png <?php echo htmlspecialchars($item['product_name']); ?>.png" alt="<?php echo htmlspecialchars($item['product_name']); ?>" style="width:50px; height:auto; margin-right:10px;">
                                <div>
                                    <strong><?php echo htmlspecialchars($item['product_name']); ?></strong><br>
                                    Category: <?php echo htmlspecialchars($item['types']); ?><br>
                                    Style: <?php echo htmlspecialchars($item['style']); ?><br>
                                    Quantity: <?php echo htmlspecialchars($item['quantity']); ?>
                                </div>
                            </div>
                        </td>
                        <td>₱<?php echo number_format($item['total'], 2); ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="1"><strong>Subtotal:</strong></td>
                    <td><strong>₱<?php echo number_format($grandTotal, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-warning">Check out</button>
    </div>

</body>
</html>
