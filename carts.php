<?php
$title = 'Carts';
$current = 'carts';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
require __DIR__ . '/db.php';

// Handle Create, Update, and Delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create operation
    if (isset($_POST['create'])) {
        $user_id = $conn->real_escape_string($_POST['user_id']);
        $sql = "INSERT INTO carts (user_id) VALUES ('$user_id')";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error creating cart: " . $conn->error . "');</script>";
        }
    }
    // Update operation
    else if (isset($_POST['update'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $user_id = $conn->real_escape_string($_POST['user_id']);
        $sql = "UPDATE carts SET user_id='$user_id' WHERE id='$id'";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error updating cart: " . $conn->error . "');</script>";
        }
    }
}
// Delete operation
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM carts WHERE id='$id'";
    if (!$conn->query($sql)) {
        echo "<script>alert('Error deleting cart: " . $conn->error . "');</script>";
    }
    header("Location: carts.php");
    exit();
}

// Fetch carts with user names from the database
$carts_query = $conn->query("SELECT c.id, c.user_id, u.name as user_name FROM carts c JOIN users u ON c.user_id = u.id");
$carts = [];
while ($row = $carts_query->fetch_assoc()) {
    $carts[] = $row;
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
                    <h1 class="h2">Carts</h1>
                    <p class="text-muted">Manage all customer shopping carts.</p>
                </div>
                <label for="modal-create" class="btn btn-primary">Create New Cart</label>
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
                                <th style="width:1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carts as $i => $cart): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($cart['user_name']) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <label for="modal-edit" class="btn btn-sm btn-outline-primary"
                                                onclick='editCart(<?= json_encode($cart) ?>)'>Edit</label>
                                            <a href="?delete=<?= $cart['id'] ?>" class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this cart?');">Delete</a>
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
            <h3 id="modal-title-create">Create New Cart</h3>
        </div>
        <label for="modal-create" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="create-cart-form" class="modal-body form" method="post" action="#">
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
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-create" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="create-cart-form">Create Cart</button>
    </div>
</div>

<input class="modal-state" id="modal-edit" type="checkbox">
<div class="modal d-flex" role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">
    <div class="modal-header">
        <div class="modal-title-row">
            <h3 id="modal-title-edit">Edit Cart</h3>
        </div>
        <label for="modal-edit" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="edit-cart-form" class="modal-body form" method="post" action="#">
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
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-edit" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="edit-cart-form">Update Cart</button>
    </div>
</div>

<script>
    function editCart(cart) {
        document.getElementById('edit-id').value = cart.id;
        document.getElementById('edit-user-id').value = cart.user_id;
    }
</script>

<?php
require __DIR__ . '/partials/footer.php';
?>
