<?php
$mock = [
  1 => ['name'=>'T-Shirt','description'=>'Cotton round-neck T-shirt','color'=>'Red','size'=>'M','price'=>'49.99','discount_price'=>'39.99','image'=>$base . '/assets/img/tshirt.jpg'],
  2 => ['name'=>'Jeans','description'=>'Slim fit denim jeans','color'=>'Blue','size'=>'L','price'=>'89.00','discount_price'=>'69.00','image'=>$base . '/assets/img/jeans.jpg'],
  3 => ['name'=>'Sneakers','description'=>'Comfortable running shoes','color'=>'White','size'=>'42','price'=>'120.00','discount_price'=>'99.00','image'=>$base . '/assets/img/sneakers.jpg'],
];

$isEdit = isset($_GET['id']) && isset($mock[(int)$_GET['id']]);
$item   = $isEdit ? $mock[(int)$_GET['id']] : ['name'=>'','description'=>'','color'=>'','size'=>'','price'=>'','discount_price'=>'','image'=>''];

$title   = $isEdit ? 'Edit Item' : 'Create Item';
$current = 'items'; 
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
?>

<section class="page-header">
  <div>
    <h1><?= $isEdit ? 'Edit Item' : 'Create Item' ?></h1>
    <p class="muted">Add or update product details here.</p>
  </div>
  <div class="actions">
    <a class="btn" href="<?= $base ?>/items.php">← Back to Items</a>
  </div>
</section>

<div class="card form">
  <h2>Item Details</h2>

  <?php if ($isEdit && !empty($item['image'])): ?>
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
      <img src="<?= htmlspecialchars($item['image']) ?>" alt="" style="width:56px;height:56px;object-fit:cover;border-radius:8px;">
      <small class="muted">Current image • Upload a new file to replace</small>
    </div>
  <?php endif; ?>

  <form method="post" action="#" enctype="multipart/form-data">
    <label class="field">
      <span>Name</span>
      <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" placeholder="e.g. T-shirt" required>
    </label>

    <label class="field">
      <span>Description</span>
      <textarea name="description" rows="3" placeholder="Enter item description"><?= htmlspecialchars($item['description']) ?></textarea>
    </label>

    <label class="field">
      <span>Color</span>
      <input type="text" name="color" value="<?= htmlspecialchars($item['color']) ?>" placeholder="e.g. Red">
    </label>

    <label class="field">
      <span>Size</span>
      <input type="text" name="size" value="<?= htmlspecialchars($item['size']) ?>" placeholder="e.g. M, L, XL">
    </label>

    <label class="field">
      <span>Image</span>
      <input type="file" name="image" accept="image/*">
    </label>

    <label class="field">
      <span>Price</span>
      <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($item['price']) ?>" placeholder="e.g. 49.99">
    </label>

    <label class="field">
      <span>Discount Price</span>
      <input type="number" step="0.01" name="discount_price" value="<?= htmlspecialchars($item['discount_price']) ?>" placeholder="e.g. 39.99">
    </label>

    <div class="form-actions">
      <button class="btn" type="reset">Reset</button>
      <button class="btn primary" type="submit"><?= $isEdit ? 'Update Item' : 'Save Item' ?></button>
    </div>
  </form>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
