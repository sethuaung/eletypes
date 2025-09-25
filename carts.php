<?php
$title = 'Carts';
$current = 'carts';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
// Provide-By-Htet-Ye-Yint
// Fake data for the cart, users, and products
$carts = [
    ['id' => 1, 'user_id' => 1, 'product_id' => 2, 'quantity' => 1],
    ['id' => 2, 'user_id' => 1, 'product_id' => 3, 'quantity' => 2],
    ['id' => 3, 'user_id' => 2, 'product_id' => 1, 'quantity' => 1],
    ['id' => 4, 'user_id' => 3, 'product_id' => 2, 'quantity' => 1],
];

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

// Helper functions to get names from their IDs
function getUserNameFromId($users, $userId) {
    foreach ($users as $user) {
        if ($user['id'] === $userId) {
            return $user['name'];
        }
    }
    return 'Unknown User';
}

function getProductNameFromId($products, $productId) {
    foreach ($products as $product) {
        if ($product['id'] === $productId) {
            return $product['name'];
        }
    }
    return 'Unknown Product';
}
?>

<section class="page-header">
  <div>
    <h1>Carts</h1>
    <p class="muted">Manage and review all customer carts.</p>
  </div>
</section>

<section class="grid two" style="margin-top: 30px;">
    <div class="card">
        <div class="card-header">
            <h2>Create New Cart</h2>
        </div>
        <div class="card-body">
            <form id="create-cart-form" class="form" method="post" action="#">
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
                    <button class="btn primary" type="submit" form="create-cart-form">Create Cart</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h2>Carts Items</h2>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>User</th>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carts as $cart): ?>
                    <tr>
                        <td><?= htmlspecialchars($cart['id']) ?></td>
                        <td><?= htmlspecialchars(getUserNameFromId($users, $cart['user_id'])) ?></td>
                        <td><?= htmlspecialchars(getProductNameFromId($products, $cart['product_id'])) ?></td>
                        <td><?= htmlspecialchars($cart['quantity']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>


