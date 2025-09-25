<?php
$title = 'Categories';
$current = 'categories';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
require __DIR__ . '/db.php';

// Handle Create, Update, and Delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create operation
    if (isset($_POST['create'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $sql = "INSERT INTO categories (name) VALUES ('$name')";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error creating category: " . $conn->error . "');</script>";
        }
    }
    // Update operation
    else if (isset($_POST['update'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $name = $conn->real_escape_string($_POST['name']);
        $sql = "UPDATE categories SET name='$name' WHERE id='$id'";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error updating category: " . $conn->error . "');</script>";
        }
    }
}
// Delete operation
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM categories WHERE id='$id'";
    if (!$conn->query($sql)) {
        echo "<script>alert('Error deleting category: " . $conn->error . "');</script>";
    }
    header("Location: categories.php");
    exit();
}

// Fetch categories from the database
$categories_query = $conn->query("SELECT id, name FROM categories");
$categories = [];
while ($row = $categories_query->fetch_assoc()) {
    $categories[] = $row;
}
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2">Categories</h1>
                    <p class="text-muted">Manage all product categories.</p>
                </div>
                <label for="modal-create" class="btn btn-primary">Create New Category</label>
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
                                <th>Category</th>
                                <th style="width:1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $i => $category): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($category['name']) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <label for="modal-edit" class="btn btn-sm btn-outline-primary"
                                                onclick='editCategory(<?= json_encode($category) ?>)'>Edit</label>
                                            <a href="?delete=<?= $category['id'] ?>" class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
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
            <h3 id="modal-title-create">Create New Category</h3>
        </div>
        <label for="modal-create" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="create-cat-form" class="modal-body form" method="post" action="#">
        <input type="hidden" name="create">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" class="form-control" name="name" placeholder="e.g., Men, Women, Kid" required>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-create" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="create-cat-form">Create Category</button>
    </div>
</div>

<input class="modal-state" id="modal-edit" type="checkbox">
<div class="modal d-flex" role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">
    <div class="modal-header">
        <div class="modal-title-row">
            <h3 id="modal-title-edit">Edit Category</h3>
        </div>
        <label for="modal-edit" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="edit-cat-form" class="modal-body form" method="post" action="#">
        <input type="hidden" name="update">
        <input type="hidden" name="id" id="edit-id">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" class="form-control" name="name" id="edit-name" required>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-edit" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="edit-cat-form">Update Category</button>
    </div>
</div>

<script>
    function editCategory(category) {
        document.getElementById('edit-id').value = category.id;
        document.getElementById('edit-name').value = category.name;
    }
</script>

<?php
require __DIR__ . '/partials/footer.php';
?>
