<?php
$title = 'Addresses';
$current = 'addresses';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
require __DIR__ . '/db.php';

// Handle Create, Update, and Delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create operation
    if (isset($_POST['create'])) {
        $user_id = $conn->real_escape_string($_POST['user_id']);
        $address_line = $conn->real_escape_string($_POST['address_line']);
        $city = $conn->real_escape_string($_POST['city']);
        $state = $conn->real_escape_string($_POST['state']);
        $postal_code = $conn->real_escape_string($_POST['postal_code']);
        $country = $conn->real_escape_string($_POST['country']);

        $sql = "INSERT INTO addresses (user_id, address_line, city, state, postal_code, country) VALUES ('$user_id', '$address_line', '$city', '$state', '$postal_code', '$country')";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error creating address: " . $conn->error . "');</script>";
        }
    }
    // Update operation
    else if (isset($_POST['update'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $user_id = $conn->real_escape_string($_POST['user_id']);
        $address_line = $conn->real_escape_string($_POST['address_line']);
        $city = $conn->real_escape_string($_POST['city']);
        $state = $conn->real_escape_string($_POST['state']);
        $postal_code = $conn->real_escape_string($_POST['postal_code']);
        $country = $conn->real_escape_string($_POST['country']);

        $sql = "UPDATE addresses SET user_id='$user_id', address_line='$address_line', city='$city', state='$state', postal_code='$postal_code', country='$country' WHERE id='$id'";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error updating address: " . $conn->error . "');</script>";
        }
    }
}
// Delete operation
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM addresses WHERE id='$id'";
    if (!$conn->query($sql)) {
        echo "<script>alert('Error deleting address: " . $conn->error . "');</script>";
    }
    header("Location: addresses.php");
    exit();
}

// Fetch addresses with user names from the database
$addresses_query = $conn->query("SELECT a.*, u.name as user_name FROM addresses a JOIN users u ON a.user_id = u.id");
$addresses = [];
while ($row = $addresses_query->fetch_assoc()) {
    $addresses[] = $row;
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
                    <h1 class="h2">Addresses</h1>
                    <p class="text-muted">Manage all customer addresses.</p>
                </div>
                <label for="modal-create" class="btn btn-primary">Create New Address</label>
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
                                <th>Address</th>
                                <th>City</th>
                                <th>Postal Code</th>
                                <th style="width:1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($addresses as $i => $address): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($address['user_name']) ?></td>
                                    <td><?= htmlspecialchars($address['address_line']) ?></td>
                                    <td><?= htmlspecialchars($address['city']) ?></td>
                                    <td><?= htmlspecialchars($address['postal_code']) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <label for="modal-edit" class="btn btn-sm btn-outline-primary"
                                                onclick='editAddress(<?= json_encode($address) ?>)'>Edit</label>
                                            <a href="?delete=<?= $address['id'] ?>" class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this address?');">Delete</a>
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
            <h3 id="modal-title-create">Create New Address</h3>
        </div>
        <label for="modal-create" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="create-address-form" class="modal-body form" method="post" action="#">
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
            <div class="col-12 mb-3">
                <label class="form-label">Address Line</label>
                <input type="text" class="form-control" name="address_line" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">State</label>
                <input type="text" class="form-control" name="state">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postal_code">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="country">
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-create" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="create-address-form">Create Address</button>
    </div>
</div>

<input class="modal-state" id="modal-edit" type="checkbox">
<div class="modal d-flex" role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">
    <div class="modal-header">
        <div class="modal-title-row">
            <h3 id="modal-title-edit">Edit Address</h3>
        </div>
        <label for="modal-edit" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="edit-address-form" class="modal-body form" method="post" action="#">
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
            <div class="col-12 mb-3">
                <label class="form-label">Address Line</label>
                <input type="text" class="form-control" name="address_line" id="edit-address-line" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" id="edit-city" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">State</label>
                <input type="text" class="form-control" name="state" id="edit-state">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postal_code" id="edit-postal-code">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="country" id="edit-country">
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-edit" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="edit-address-form">Update Address</button>
    </div>
</div>

<script>
    function editAddress(address) {
        document.getElementById('edit-id').value = address.id;
        document.getElementById('edit-user-id').value = address.user_id;
        document.getElementById('edit-address-line').value = address.address_line;
        document.getElementById('edit-city').value = address.city;
        document.getElementById('edit-state').value = address.state;
        document.getElementById('edit-postal-code').value = address.postal_code;
        document.getElementById('edit-country').value = address.country;
    }
</script>

<?php
require __DIR__ . '/partials/footer.php';
?>
