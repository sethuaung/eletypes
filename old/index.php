<?php
$title = 'Dashboard';
$current = 'dashboard';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
require __DIR__ . '/db.php';

// Fetching real stats from the database
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$totalProducts = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$totalOrders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$totalRevenue = $conn->query("SELECT SUM(total) as sum FROM orders WHERE status = 'Paid'")->fetch_assoc()['sum'];

$stats = [
    ['label' => 'Total Users', 'value' => number_format($totalUsers)],
    ['label' => 'Total Products', 'value' => number_format($totalProducts)],
    ['label' => 'Total Orders', 'value' => number_format($totalOrders)],
    ['label' => 'Total Revenue', 'value' => '$' . number_format($totalRevenue, 2)],
];
?>
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h1>Dashboard</h1>
        <p class="text-muted">Quick overview of what's happening today.</p>
    </div>
    <div class="row g-4">
        <?php foreach ($stats as $s): ?>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="stat-label text-muted"><?= htmlspecialchars($s['label']) ?></div>
                    <div class="stat-value h4"><?= htmlspecialchars($s['value']) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
require __DIR__ . '/partials/footer.php';
?>
