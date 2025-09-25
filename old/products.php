<?php
$title = 'Products';
$current = 'products';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
require __DIR__ . '/db.php';

// Handle Create, Update, and Delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create operation
    if (isset($_POST['create'])) {
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $price = $conn->real_escape_string($_POST['price']);
        $discount_price = !empty($_POST['discount_price']) ? "'" . $conn->real_escape_string($_POST['discount_price']) . "'" : 'NULL';

        $sql = "INSERT INTO products (category_id, name, description, price, discount_price) VALUES ('$category_id', '$name', '$description', '$price', $discount_price)";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error creating product: " . $conn->error . "');</script>";
        }
    }
    // Update operation
    else if (isset($_POST['update'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $price = $conn->real_escape_string($_POST['price']);
        $discount_price = !empty($_POST['discount_price']) ? "'" . $conn->real_escape_string($_POST['discount_price']) . "'" : 'NULL';

        $sql = "UPDATE products SET category_id='$category_id', name='$name', description='$description', price='$price', discount_price=$discount_price WHERE id='$id'";
        if (!$conn->query($sql)) {
            echo "<script>alert('Error updating product: " . $conn->error . "');</script>";
        }
    }
}
// Delete operation
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM products WHERE id='$id'";
    if (!$conn->query($sql)) {
        echo "<script>alert('Error deleting product: " . $conn->error . "');</script>";
    }
    header("Location: products.php");
    exit();
}

// Fetch products with category names from the database
$products_query = $conn->query("SELECT p.id, p.name, p.description, p.price, p.discount_price, p.category_id, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id");
$products = [];
while ($row = $products_query->fetch_assoc()) {
    $products[] = $row;
}

// Fetch all categories for the dropdown
$categories_query = $conn->query("SELECT id, name FROM categories");
$categories = [];
while ($row = $categories_query->fetch_assoc()) {
    $categories[$row['id']] = $row['name'];
}
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2">Products</h1>
                    <p class="text-muted">Manage all product listings.</p>
                </div>
                <label for="modal-create" class="btn btn-primary">Create New Product</label>
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
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Discount Price</th>
                                <th style="width:1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $i => $product): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                                    <td><?= htmlspecialchars(number_format($product['price'], 2)) ?></td>
                                    <td><?= htmlspecialchars(number_format($product['discount_price'], 2)) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <label for="modal-edit" class="btn btn-sm btn-outline-primary"
                                                onclick='editProduct(<?= json_encode($product) ?>)'>Edit</label>
                                            <a href="?delete=<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
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
            <h3 id="modal-title-create">Create New Product</h3>
        </div>
        <label for="modal-create" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="create-product-form" class="modal-body form" method="post" action="#">
        <input type="hidden" name="create">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category_id" required>
                    <?php foreach ($categories as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Discount Price</label>
                <input type="number" step="0.01" class="form-control" name="discount_price">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-create" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="create-product-form">Create Product</button>
    </div>
</div>

<input class="modal-state" id="modal-edit" type="checkbox">
<div class="modal d-flex" role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">
    <div class="modal-header">
        <div class="modal-title-row">
            <h3 id="modal-title-edit">Edit Product</h3>
        </div>
        <label for="modal-edit" class="modal-close" aria-label="Close">×</label>
    </div>
    <form id="edit-product-form" class="modal-body form" method="post" action="#">
        <input type="hidden" name="update">
        <input type="hidden" name="id" id="edit-id">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category_id" id="edit-category-id" required>
                    <?php foreach ($categories as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" id="edit-name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" id="edit-price" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Discount Price</label>
                <input type="number" step="0.01" class="form-control" name="discount_price" id="edit-discount-price">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" id="edit-description" rows="3"></textarea>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <label for="modal-edit" class="btn btn-secondary">Cancel</label>
        <button class="btn btn-primary" type="submit" form="edit-product-form">Update Product</button>
    </div>
</div>

<script>
    function editProduct(product) {
        document.getElementById('edit-id').value = product.id;
        document.getElementById('edit-category-id').value = product.category_id;
        document.getElementById('edit-name').value = product.name;
        document.getElementById('edit-price').value = product.price;
        document.getElementById('edit-discount-price').value = product.discount_price || '';
        document.getElementById('edit-description').value = product.description;
    }
</script>

<?php
require __DIR__ . '/partials/footer.php';
?>
