<?php
$title = 'Items';
$current = 'items';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
require __DIR__ . '/db.php';

// Handle Create, Update, and Delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create operation
    if (isset($_POST['create'])) {
        $cart_id = $conn->real_escape_string($_POST['cart_id']);
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $quantity = $conn->real_escape_string($_POST['quantity']);
        $sql = "INSERT INTO items (cart_id, product_id, quantity) VALUES ('$cart_id', '$product_id', '$quantity')";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error creating item: " . $conn->error . "');</script>";
        }
    }
    // Update operation
    else if (isset($_POST['update'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $cart_id = $conn->real_escape_string($_POST['cart_id']);
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $quantity = $conn->real_escape_string($_POST['quantity']);
        $sql = "UPDATE items SET cart_id='$cart_id', product_id='$product_id', quantity='$quantity' WHERE id='$id'";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error updating item: " . $conn->error . "');</script>";
        }
    }
}
// Delete operation
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM items WHERE id='$id'";
    if (!$conn->query($sql)) {
        echo "<script>alert('Error deleting item: " . $conn->error . "');</script>";
    }
    header("Location: items.php");
    exit();
}

// Fetch items with cart and product names from the database
$items_query = $conn->query("SELECT i.id, i.quantity, i.cart_id, i.product_id, u.name as user_name, p.name as product_name FROM items i JOIN carts c ON i.cart_id = c.id JOIN users u ON c.user_id = u.id JOIN products p ON i.product_id = p.id");
$items = [];
while ($row = $items_query->fetch_assoc()) {
    $items[] = $row;
}

// Fetch all carts for the dropdown
$carts_query = $conn->query("SELECT c.id, u.name as user_name FROM carts c JOIN users u ON c.user_id = u.id");
$carts = [];
while ($row = $carts_query->fetch_assoc()) {
    $carts[$row['id']] = 'Cart for ' . $row['user_name'];
}

// Fetch all products for the dropdown
$products_query = $conn->query("SELECT id, name FROM products");
$products = [];
while ($row = $products_query->fetch_assoc()) {
    $products[$row['id']] = $row['name'];
}
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2">Items</h1>
                    <p class="text-muted">Manage items within customer carts.</p>
                </div>
                <label for="modal-create" class="btn btn-primary">Create New Item</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-wrap">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cart</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th style="width:1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $i => $item): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars('Cart for ' . $item['user_name']) ?></td>
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <label for="modal-edit" class="btn btn-sm btn-outline-primary"
                                                onclick='editItem(<?= json_encode($item) ?>)'>Edit</label>
                                            <a href="?delete=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input class="modal-state" id="modal-create" type="checkbox">
<div class="modal d-flex" role="dialog" aria-modal="true" aria-labelledby="modal-title-create">
    <div class="modal-header">
        <div class="modal-title-row">
            <h3 id="modal-title-create">Create New Item</h3>
        </div>
        <label for="modal-create" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="create-item-form" class="modal-body form" method="post" action="#">
        <input type="hidden" name="create">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Cart</label>
                <select class="form-select" name="cart_id" required>
                    <?php foreach ($carts as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Product</label>
                <select class="form-select" name="product_id" required>
                    <?php foreach ($products as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity" min="1" value="1" required>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-create" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="create-item-form">Create Item</button>
    </div>
</div>

<input class="modal-state" id="modal-edit" type="checkbox">
<div class="modal d-flex" role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">
    <div class="modal-header">
        <div class="modal-title-row">
            <h3 id="modal-title-edit">Edit Item</h3>
        </div>
        <label for="modal-edit" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="edit-item-form" class="modal-body form" method="post" action="#">
        <input type="hidden" name="update">
        <input type="hidden" name="id" id="edit-id">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Cart</label>
                <select class="form-select" name="cart_id" id="edit-cart-id" required>
                    <?php foreach ($carts as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Product</label>
                <select class="form-select" name="product_id" id="edit-product-id" required>
                    <?php foreach ($products as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity" id="edit-quantity" min="1" required>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-edit" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="edit-item-form">Update Item</button>
    </div>
</div>

<script>
    function editItem(item) {
        document.getElementById('edit-id').value = item.id;
        document.getElementById('edit-cart-id').value = item.cart_id;
        document.getElementById('edit-product-id').value = item.product_id;
        document.getElementById('edit-quantity').value = item.quantity;
    }
</script>

<?php
require __DIR__ . '/partials/footer.php';
?>
