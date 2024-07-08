<?php
require 'Currensy.php';

$currency = new Currency();
$convertedAmount = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = (float)($_POST['amount'] ?? 0);
    $fromCurrency = $_POST['from_currency'] ?? '';
    $toCurrency = $_POST['to_currency'] ?? '';

    try {
        $exchangeResult = $currency->exchange($amount, $fromCurrency, $toCurrency);
        $convertedAmount = number_format((float) $exchangeResult, 2);
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="index.php" method="post">
                <fieldset>
                    <legend class="legend">Currency Converter</legend>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="from_currency" class="form-label">From:</label>
                            <select id="from_currency" name="from_currency" class="form-select">
                                <?php
                                foreach ($currency->customCurrencies() as $currencyName => $rate) {
                                    $selected = isset($fromCurrency) && $fromCurrency === $currencyName ? 'selected' : '';
                                    echo "<option value=\"$currencyName\" $selected>$currencyName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="to_currency" class="form-label">To:</label>
                            <select id="to_currency" name="to_currency" class="form-select">
                                <?php
                                foreach ($currency->customCurrencies() as $currencyName => $rate) {
                                    $selected = isset($toCurrency) && $toCurrency === $currencyName ? 'selected' : '';
                                    echo "<option value=\"$currencyName\" $selected>$currencyName</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="amount" class="form-label">Amount:</label>
                            <input type="text" id="amount" name="amount" class="form-control" placeholder="Enter amount"
                                   value="<?php echo htmlspecialchars($amount); ?>">
                        </div>
                        <div class="input-group">
                            <label for="converted_amount" class="form-label">Converted Amount:</label>
                            <input type="text" id="converted_amount" class="form-control" value="<?php echo htmlspecialchars($convertedAmount); ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-submit">Convert</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</body>
</html>
