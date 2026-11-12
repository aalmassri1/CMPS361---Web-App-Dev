<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$fields = [
    'first_name' => 'First name',
    'last_name'  => 'Last name',
    'product'    => 'Product name',
    'price'      => 'Price (USD)',
];

$values = array_fill_keys(array_keys($fields), '');
$error = '';
$success = $_SESSION['product_saved'] ?? '';
unset($_SESSION['product_saved']);

$_SESSION['product_csrf'] ??= bin2hex(random_bytes(32));

function escapeProductText($value) {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf'] ?? '';

    if (!is_string($token) || !hash_equals($_SESSION['product_csrf'], $token)) {
        http_response_code(403);
        exit('Reload the form and try again.');
    }

    foreach ($fields as $name => $label) {
        $value = $_POST[$name] ?? '';
        $values[$name] = is_string($value) ? trim($value) : '';
    }

    foreach (['first_name', 'last_name', 'product'] as $name) {
        if (!preg_match('/\A[^\p{Cc}]{1,80}\z/u', $values[$name])) {
            $error = $fields[$name] . ' must be between 1 and 80 characters.';
            break;
        }
    }

    if ($error === '' && !preg_match('/\A(\d{1,6})(?:\.(\d{1,2}))?\z/', $values['price'], $parts)) {
        $error = 'Enter a price from 0.00 to 999999.99, with up to two decimal places.';
    }

    if ($error === '') {
        $priceCents = (int) $parts[1] * 100
            + (int) str_pad($parts[2] ?? '', 2, '0');

        require __DIR__ . '/db.php';

        $result = pg_query_params(
            $conn,
            'INSERT INTO inventory (first_name, last_name, product, price_cents)
             VALUES ($1, $2, $3, $4)',
            [$values['first_name'], $values['last_name'], $values['product'], $priceCents]
        );

        if ($result === false) {
            $error = 'The product could not be saved. Please try again.';
        } else {
            $_SESSION['product_saved'] = $values['product'] . ' was saved.';
            header('Location: products.php', true, 303);
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Study Planner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f8;
            color: #243247;
        }
        main { max-width: 520px; margin: auto; }
        form {
            display: grid;
            gap: 8px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: white;
        }
        input, button { font: inherit; padding: 9px; }
        input { border: 1px solid #7d8da2; border-radius: 4px; }
        label { margin-top: 6px; font-weight: bold; }
        button {
            justify-self: start;
            margin-top: 8px;
            background: #174b8a;
            color: white;
            border: 0;
            border-radius: 4px;
            cursor: pointer;
        }
        a { color: #174b8a; }
        .error { color: #8f2431; }
        .success { color: #18553c; }
    </style>
</head>
<body>
<main>
    <nav aria-label="Main navigation">
        <a href="services.php">Study Planner</a> |
        <a href="products.php">Add Product</a> |
        <a href="searchview.php">View Inventory</a>
    </nav>
    <p><a href="services.php">Back to Study Planner</a></p>
    <h1>Add Product</h1>
    <p>Enter the customer and product details below.</p>

    <?php if ($error !== ''): ?>
        <p class="error" role="alert"><?= escapeProductText($error) ?></p>
    <?php endif; ?>

    <?php if ($success !== ''): ?>
        <p class="success" role="status"><?= escapeProductText($success) ?></p>
    <?php endif; ?>

    <form method="post" action="products.php">
        <input type="hidden" name="csrf"
               value="<?= escapeProductText($_SESSION['product_csrf']) ?>">

        <?php foreach ($fields as $name => $label): ?>
            <label for="<?= $name ?>"><?= $label ?></label>
            <input type="text" id="<?= $name ?>" name="<?= $name ?>"
                   value="<?= escapeProductText($values[$name]) ?>"
                   maxlength="<?= $name === 'price' ? 9 : 80 ?>"
                   <?= $name === 'price' ? 'inputmode="decimal" placeholder="49.99"' : '' ?>
                   required>
        <?php endforeach; ?>

        <button type="submit">Save Product</button>
    </form>
</main>
</body>
</html>