<?php
// Sample data for the table.
$data = [
    ['customers_id' => 1, 'first_name' => 'Maya', 'last_name' => 'Johnson', 'product' => 'Keyboard', 'price' => 49.99],
    ['customers_id' => 2, 'first_name' => 'Liam', 'last_name' => 'Smith', 'product' => 'Mouse', 'price' => 19.99],
    ['customers_id' => 3, 'first_name' => 'Sofia', 'last_name' => 'Garcia', 'product' => 'Monitor', 'price' => 179.99],
    ['customers_id' => 4, 'first_name' => 'Noah', 'last_name' => 'Brown', 'product' => 'Headphones', 'price' => 64.50],
    ['customers_id' => 5, 'first_name' => 'Emma', 'last_name' => 'Davis', 'product' => 'Webcam', 'price' => 39.95],
    ['customers_id' => 6, 'first_name' => 'Ethan', 'last_name' => 'Wilson', 'product' => 'USB Hub', 'price' => 24.99],
    ['customers_id' => 7, 'first_name' => 'Ava', 'last_name' => 'Martinez', 'product' => 'Laptop Stand', 'price' => 32.00],
    ['customers_id' => 8, 'first_name' => 'Lucas', 'last_name' => 'Anderson', 'product' => 'Speakers', 'price' => 54.99],
    ['customers_id' => 9, 'first_name' => 'Isabella', 'last_name' => 'Taylor', 'product' => 'Flash Drive', 'price' => 12.50],
    ['customers_id' => 10, 'first_name' => 'Oliver', 'last_name' => 'Thomas', 'product' => 'Printer', 'price' => 129.00],
    ['customers_id' => 11, 'first_name' => 'Amelia', 'last_name' => 'Moore', 'product' => 'Desk Lamp', 'price' => 29.99],
    ['customers_id' => 12, 'first_name' => 'James', 'last_name' => 'Lee', 'product' => 'External Drive', 'price' => 89.99]
];

// Column names and labels.
$columns = [
    'customers_id' => 'Customer ID',
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'product' => 'Product',
    'price' => 'Price'
];

// Read and validate the sorting options from the URL.
$sortColumn = $_GET['sort'] ?? 'customers_id';

if (!is_string($sortColumn) || !array_key_exists($sortColumn, $columns)) {
    $sortColumn = 'customers_id';
}

$sortOrder = ($_GET['order'] ?? 'asc') === 'desc' ? 'desc' : 'asc';

// Sort the entire data array before dividing it into pages.
usort($data, function ($a, $b) use ($sortColumn, $sortOrder) {
    if ($sortColumn === 'customers_id' || $sortColumn === 'price') {
        $result = $a[$sortColumn] <=> $b[$sortColumn];
    } else {
        $result = strcasecmp($a[$sortColumn], $b[$sortColumn]);
    }

    return $sortOrder === 'asc' ? $result : -$result;
});

// Pagination settings.
$limit = 5;
$totalPages = max(1, (int) ceil(count($data) / $limit));

$requestedPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
$currentPage = max(1, min($totalPages, $requestedPage ?: 1));

$startIndex = ($currentPage - 1) * $limit;
$pageData = array_slice($data, $startIndex, $limit);

// Toggle between ascending and descending order.
function toggleOrder($currentOrder) {
    return $currentOrder === 'asc' ? 'desc' : 'asc';
}

// Escape values for safe HTML output.
function escape($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Build links that preserve the sorting options.
function tableLink($page, $column, $order) {
    return '?' . http_build_query([
        'page' => $page,
        'sort' => $column,
        'order' => $order
    ]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module 5 - GridView Sorting</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f6f8;
            color: #243247;
        }

        main {
            max-width: 900px;
            margin: auto;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #e3eaf4;
        }

        th a {
            color: #174b8a;
        }

        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .price {
            text-align: right;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ccc;
            background-color: white;
        }

        .pagination a {
            color: #174b8a;
        }

        .pagination .current {
            background-color: #174b8a;
            color: white;
        }
    </style>
</head>

<body>
<main>
    <h1>Customer GridView</h1>
    <p>Click a column heading to sort. Click it again to reverse the order.</p>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <?php foreach ($columns as $column => $label): ?>
                        <?php
                        $isActive = $sortColumn === $column;
                        $nextOrder = $isActive ? toggleOrder($sortOrder) : 'asc';
                        $ariaSort = $isActive
                            ? ($sortOrder === 'asc' ? 'ascending' : 'descending')
                            : 'none';
                        ?>

                        <th scope="col" aria-sort="<?= escape($ariaSort) ?>">
                            <a href="<?= escape(tableLink(1, $column, $nextOrder)) ?>">
                                <?= escape($label) ?>
                                <?php if ($isActive): ?>
                                    <?= $sortOrder === 'asc' ? '↑' : '↓' ?>
                                <?php endif; ?>
                            </a>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($pageData as $row): ?>
                    <tr>
                        <td><?= escape($row['customers_id']) ?></td>
                        <td><?= escape($row['first_name']) ?></td>
                        <td><?= escape($row['last_name']) ?></td>
                        <td><?= escape($row['product']) ?></td>
                        <td class="price">
                            $<?= number_format($row['price'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav class="pagination" aria-label="Table pages">
        <?php if ($currentPage > 1): ?>
            <a href="<?= escape(tableLink($currentPage - 1, $sortColumn, $sortOrder)) ?>">
                Previous
            </a>
        <?php endif; ?>

        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
            <?php if ($page === $currentPage): ?>
                <span class="current" aria-current="page"><?= $page ?></span>
            <?php else: ?>
                <a href="<?= escape(tableLink($page, $sortColumn, $sortOrder)) ?>">
                    <?= $page ?>
                </a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="<?= escape(tableLink($currentPage + 1, $sortColumn, $sortOrder)) ?>">
                Next
            </a>
        <?php endif; ?>
    </nav>

    <p>Page <?= $currentPage ?> of <?= $totalPages ?></p>
</main>
</body>
</html>