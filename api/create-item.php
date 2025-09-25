<?php
$title = 'Create Item';
$current = 'items'; 
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
?>

<section class="page-header">
  <div>
    <h1>Create Item</h1>
    <p class="muted">Add or update product details here.</p>
  </div>
  <div class="actions">
    <a class="btn" href="<?= $base ?>/items.php">← Back to Items</a>
  </div>
</section>

<div class="card form">
  <h2>Item Details</h2>
  <form method="post" action="#" enctype="multipart/form-data">
    <label class="field">
      <span>Name</span>
      <input type="text" name="name" placeholder="e.g. T-shirt" required>
    </label>

    <label class="field">
      <span>Description</span>
      <textarea name="description" rows="3" placeholder="Enter item description"></textarea>
    </label>

    <label class="field">
      <span>Color</span>
      <input type="text" name="color" placeholder="e.g. Red">
    </label>

    <label class="field">
      <span>Size</span>
      <input type="text" name="size" placeholder="e.g. M, L, XL">
    </label>

    <label class="field">
      <span>Image</span>
      <input type="file" name="image" accept="image/*">
    </label>

    <label class="field">
      <span>Price</span>
      <input type="number" step="0.01" name="price" placeholder="e.g. 49.99">
    </label>

    <label class="field">
      <span>Discount Price</span>
      <input type="number" step="0.01" name="discount_price" placeholder="e.g. 39.99">
    </label>

    <div class="form-actions">
      <button class="btn" type="reset">Reset</button>
      <button class="btn primary" type="submit">Save Item</button>
    </div>
  </form>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
