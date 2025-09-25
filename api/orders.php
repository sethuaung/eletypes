<?php
$title = 'Orders';
$current = 'orders';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';

// Provide-By-Htet-Ye-Yint
// Fake data for users and products
$users = [
    ['id' => 1, 'name' => 'R. Singh'],
    ['id' => 2, 'name' => 'A. Lopez'],
    ['id' => 3, 'name' => 'J. Chen'],
    ['id' => 4, 'name' => 'M. Rossi'],
];

$products = [
    ['id' => 1, 'name' => 'T-Shirt'],
    ['id' => 2, 'name' => 'Jeans'],
    ['id' => 3, 'name' => 'Sneakers'],
];

// Fake data for orders
$orders = [
    ['id' => '#1042', 'user_id' => 1, 'status' => 'Paid', 'total' => '$129.00', 'date' => '2025-09-18'],
    ['id' => '#1041', 'user_id' => 2, 'status' => 'Pending', 'total' => '$89.50', 'date' => '2025-09-18'],
    ['id' => '#1040', 'user_id' => 3, 'status' => 'Refunded', 'total' => '$59.00', 'date' => '2025-09-17'],
    ['id' => '#1039', 'user_id' => 4, 'status' => 'Paid', 'total' => '$249.00', 'date' => '2025-09-16'],
];

// Helper function to get a user's name from their ID
function getUserName($users, $userId) {
    foreach ($users as $user) {
        if ($user['id'] === $userId) {
            return $user['name'];
        }
    }
    return 'Unknown';
}
?>

<section class="page-header">
  <div>
    <h1>Orders</h1>
    <p class="muted">Manage all customer orders and their details.</p>
  </div>
</section>

<section class="grid two" style="margin-top: 30px;">
    <div class="card">
        <div class="card-header">
            <h2>Create New Order</h2>
        </div>
        <div class="card-body">
            <form id="create-order-form" class="form" method="post" action="#">
                <div class="field">
                    <label>User</label>
                    <select name="user_id" required>
                        <option disabled selected value="">Select User</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['id']) ?>"><?= htmlspecialchars($user['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label>Product</label>
                    <select name="product_id" required>
                        <option disabled selected value="">Select Product</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= htmlspecialchars($product['id']) ?>"><?= htmlspecialchars($product['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label>Quantity</label>
                    <input type="number" name="quantity" min="1" value="1" required>
                </div>
                <div class="form-actions">
                    <button class="btn primary" type="submit" form="create-order-form">Create Order</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h2>Recent Orders</h2>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><?= htmlspecialchars($o['id']) ?></td>
                        <td><?= htmlspecialchars(getUserName($users, $o['user_id'])) ?></td>
                        <td><span class="badge <?= strtolower($o['status']) ?>"><?= htmlspecialchars($o['status']) ?></span></td>
                        <td><?= htmlspecialchars($o['total']) ?></td>
                        <td><?= htmlspecialchars($o['date']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>


