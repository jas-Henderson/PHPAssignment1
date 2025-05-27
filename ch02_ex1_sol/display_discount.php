<!DOCTYPE html>
<html>
<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <h1>Product Discount Summary</h1>

        <?php
            $product_description = filter_input(INPUT_POST, 'product_description', FILTER_SANITIZE_SPECIAL_CHARS);
            $list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);
            $discount_percent = filter_input(INPUT_POST, 'discount_percent', FILTER_VALIDATE_FLOAT);

            // Set default values
            $formatted_list_price = $formatted_discount_percent = '';
            $formatted_discount_amount = $formatted_discount_price = '';
            $formatted_sales_tax_rate = $formatted_sales_tax = $formatted_total_price = '';

            // Define sales tax rate
            $sales_tax_rate = 0.08; // 8%

            // Validate inputs
            if (
                $product_description && $list_price !== false && $discount_percent !== false
                && $list_price > 0 && $discount_percent >= 0 && $discount_percent <= 100
            ) {
                // Calculate discount and final prices
                $discount_amount = $list_price * ($discount_percent / 100);
                $discount_price = $list_price - $discount_amount;

                // Calculate sales tax and total
                $sales_tax = $discount_price * $sales_tax_rate;
                $total_price = $discount_price + $sales_tax;

                // Format for display
                $formatted_list_price = '$' . number_format($list_price, 2);
                $formatted_discount_percent = number_format($discount_percent, 2) . '%';
                $formatted_discount_amount = '$' . number_format($discount_amount, 2);
                $formatted_discount_price = '$' . number_format($discount_price, 2);
                $formatted_sales_tax_rate = number_format($sales_tax_rate * 100, 2) . '%';
                $formatted_sales_tax = '$' . number_format($sales_tax, 2);
                $formatted_total_price = '$' . number_format($total_price, 2);
            } else {
                echo "<p style='color: red;'>Please enter valid product description, list price, and discount percent (0–100).</p>";
            }
        ?>

        <label>Product Description:</label>
        <span><?php echo $product_description; ?></span><br>

        <label>List Price:</label>
        <span><?php echo $formatted_list_price; ?></span><br>

        <label>Discount Percent:</label>
        <span><?php echo $formatted_discount_percent; ?></span><br>

        <label>Discount Amount:</label>
        <span><?php echo $formatted_discount_amount; ?></span><br>

        <label>Discount Price:</label>
        <span><?php echo $formatted_discount_price; ?></span><br>

        <label>Sales Tax Rate:</label>
        <span><?php echo $formatted_sales_tax_rate; ?></span><br>

        <label>Sales Tax Amount:</label>
        <span><?php echo $formatted_sales_tax; ?></span><br>

        <label>Total Price After Tax:</label>
        <span><?php echo $formatted_total_price; ?></span><br>
    </main>
</body>
</html>