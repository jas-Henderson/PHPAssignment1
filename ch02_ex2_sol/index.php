<?php
// Initialize variables
$investment = '';
$interest_rate = '';
$years = '';
$error_message = '';
$future_value_f = '';
$show_results = false;

// Variables to store formatted results
$investment_f = '';
$yearly_rate_f = '';
$years_display = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and trim input values from POST
    $investment_input = trim($_POST['investment'] ?? '');
    $interest_rate_input = trim($_POST['interest_rate'] ?? '');
    $years_input = trim($_POST['years'] ?? '');

    // Validate and filter inputs
    $investment_val = filter_var($investment_input, FILTER_VALIDATE_FLOAT);
    $interest_rate_val = filter_var($interest_rate_input, FILTER_VALIDATE_FLOAT);
    $years_val = filter_var($years_input, FILTER_VALIDATE_INT);

    // Validation checks
    if ($investment_val === false || $investment_input === '') {
        $error_message .= 'Investment must be a valid number.<br>';
    } else if ($investment_val <= 0) {
        $error_message .= 'Investment must be greater than zero.<br>';
    }

    if ($interest_rate_val === false || $interest_rate_input === '') {
        $error_message .= 'Interest rate must be a valid number.<br>';
    } else if ($interest_rate_val <= 0) {
        $error_message .= 'Interest rate must be greater than zero.<br>';
    } else if ($interest_rate_val > 15) {
        $error_message .= 'Interest rate must be less than or equal to 15.<br>';
    }

    if ($years_val === false || $years_input === '') {
        $error_message .= 'Years must be a valid whole number.<br>';
    } else if ($years_val <= 0) {
        $error_message .= 'Years must be greater than zero.<br>';
    } else if ($years_val > 30) {
        $error_message .= 'Years must be less than 31.<br>';
    }

    // If no errors, calculate future value and prepare results
    if ($error_message === '') {
        $future_value = $investment_val;
        for ($i = 1; $i <= $years_val; $i++) {
            $future_value += $future_value * $interest_rate_val * 0.01;
        }

        // Format values for display
        $investment_f = '$' . number_format($investment_val, 2);
        $yearly_rate_f = $interest_rate_val . '%';
        $years_display = $years_val;
        $future_value_f = '$' . number_format($future_value, 2);
        
        $show_results = true;

        // Clear input values after successful calculation
        $investment = '';
        $interest_rate = '';
        $years = '';
    } else {
        // If errors, keep the input values so user can correct them
        $investment = htmlspecialchars($investment_input);
        $interest_rate = htmlspecialchars($interest_rate_input);
        $years = htmlspecialchars($years_input);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <h1>Future Value Calculator</h1>

        <?php if (!empty($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="index.php" method="post">
            <div id="data">
                <label for="investment">Investment Amount:</label>
                <input type="text" id="investment" name="investment" value="<?php echo $investment; ?>">
                <br>

                <label for="interest_rate">Yearly Interest Rate:</label>
                <input type="text" id="interest_rate" name="interest_rate" value="<?php echo $interest_rate; ?>">
                <br>

                <label for="years">Number of Years:</label>
                <input type="text" id="years" name="years" value="<?php echo $years; ?>">
                <br>
            </div>

            <div id="buttons" style="margin-top: 12px;">
                <input type="submit" value="Calculate">
            </div>
        </form>

        <?php if ($show_results && !empty($future_value_f)) : ?>
            <div id="result" style="margin-top: 20px; padding: 15px; border: 1px solid #ccc; background-color: #f9f9f9;">
                <h2>Calculation Results</h2>
                <p><strong>Investment Amount:</strong> <?php echo $investment_f; ?></p>
                <p><strong>Yearly Interest Rate:</strong> <?php echo $yearly_rate_f; ?></p>
                <p><strong>Number of Years:</strong> <?php echo $years_display; ?></p>
                <p><strong>Future Value:</strong> <?php echo $future_value_f; ?></p>
                <p><em>Calculation done on <?php echo date('m/d/Y'); ?>.</em></p>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>