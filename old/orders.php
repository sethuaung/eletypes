<?php
$title = 'Orders';
$current = 'orders';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
require __DIR__ . '/db.php';

// Handle Create, Update, and Delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create operation
    if (isset($_POST['create'])) {
        $user_id = $conn->real_escape_string($_POST['user_id']);
        $total = $conn->real_escape_string($_POST['total']);
        $status = $conn->real_escape_string($_POST['status']);
        $order_date = date("Y-m-d"); // Current date
        $sql = "INSERT INTO orders (user_id, total, status, order_date) VALUES ('$user_id', '$total', '$status', '$order_date')";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error creating order: " . $conn->error . "');</script>";
        }
    }
    // Update operation
    else if (isset($_POST['update'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $user_id = $conn->real_escape_string($_POST['user_id']);
        $total = $conn->real_escape_string($_POST['total']);
        $status = $conn->real_escape_string($_POST['status']);
        $sql = "UPDATE orders SET user_id='$user_id', total='$total', status='$status' WHERE id='$id'";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error updating order: " . $conn->error . "');</script>";
        }
    }
}
// Delete operation
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM orders WHERE id='$id'";
    if (!$conn->query($sql)) {
        echo "<script>alert('Error deleting order: " . $conn->error . "');</script>";
    }
    header("Location: orders.php");
    exit();
}

// Fetch orders with user names from the database
$orders_query = $conn->query("SELECT o.id, o.total, o.status, o.user_id, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id");
$orders = [];
while ($row = $orders_query->fetch_assoc()) {
    $orders[] = $row;
}

// Fetch all users for the dropdown
$users_query = $conn->query("SELECT id, name FROM users");
$users = [];
while ($row = $users_query->fetch_assoc()) {
    $users[$row['id']] = $row['name'];
}
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2">Orders</h1>
                    <p class="text-muted">Manage all customer orders.</p>
                </div>
                <label for="modal-create" class="btn btn-primary">Create New Order</label>
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
                                <th>User</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th style="width:1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $i => $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['id']) ?></td>
                                    <td><?= htmlspecialchars($order['user_name']) ?></td>
                                    <td>$<?= htmlspecialchars(number_format($order['total'], 2)) ?></td>
                                    <td><?= htmlspecialchars($order['status']) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <label for="modal-edit" class="btn btn-sm btn-outline-primary"
                                                onclick='editOrder(<?= json_encode($order) ?>)'>Edit</label>
                                            <a href="?delete=<?= $order['id'] ?>" class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
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
            <h3 id="modal-title-create">Create New Order</h3>
        </div>
        <label for="modal-create" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="create-order-form" class="modal-body form" method="post" action="#">
        <input type="hidden" name="create">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">User</label>
                <select class="form-select" name="user_id" required>
                    <?php foreach ($users as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Total Amount</label>
                <input type="number" step="0.01" class="form-control" name="total" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Refunded">Refunded</option>
                </select>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-create" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="create-order-form">Create Order</button>
    </div>
</div>

<input class="modal-state" id="modal-edit" type="checkbox">
<div class="modal d-flex" role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">
    <div class="modal-header">
        <div class="modal-title-row">
            <h3 id="modal-title-edit">Edit Order</h3>
        </div>
        <label for="modal-edit" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="edit-order-form" class="modal-body form" method="post" action="#">
        <input type="hidden" name="update">
        <input type="hidden" name="id" id="edit-id">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">User</label>
                <select class="form-select" name="user_id" id="edit-user-id" required>
                    <?php foreach ($users as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Total Amount</label>
                <input type="number" step="0.01" class="form-control" name="total" id="edit-total" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status" id="edit-status" required>
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Refunded">Refunded</option>
                </select>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-edit" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="edit-order-form">Update Order</button>
    </div>
</div>

<script>
    function editOrder(order) {
        document.getElementById('edit-id').value = order.id;
        document.getElementById('edit-user-id').value = order.user_id;
        document.getElementById('edit-total').value = order.total;
        document.getElementById('edit-status').value = order.status;
    }
</script>

<?php
require __DIR__ . '/partials/footer.php';
?>
