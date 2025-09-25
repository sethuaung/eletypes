<?php
$title = 'Items';
$current = 'items';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';

// UI-only mock data 
$items = [
  [
    'id' => 1,
    'image' => $base . '/assets/img/tshirt.jpg',
    'name' => 'T-Shirt',
    'description' => 'Cotton round-neck T-shirt',
    'color' => 'Red',
    'size' => 'M',
    'price' => 49.99,
    'discount_price' => 39.99,
    'created' => '2025-01-12',
  ],
  [
    'id' => 2,
    'image' => $base . '/assets/img/jeans.jpg',
    'name' => 'Jeans',
    'description' => 'Slim fit denim jeans',
    'color' => 'Blue',
    'size' => 'L',
    'price' => 89.00,
    'discount_price' => 69.00,
    'created' => '2025-02-05',
  ],
  [
    'id' => 3,
    'image' => $base . '/assets/img/sneakers.jpg',
    'name' => 'Sneakers',
    'description' => 'Comfortable running shoes',
    'color' => 'White',
    'size' => '42',
    'price' => 120.00,
    'discount_price' => 99.00,
    'created' => '2025-03-10',
  ],
];
?>

<section class="page-header">
  <div>
    <h1>Items</h1>
    <p class="muted">Manage your product items.</p>
  </div>
  <div class="actions">
    <a class="btn primary" href="<?= $base ?>/item-form.php">+ Create Item</a>
  </div>
</section>

<div class="card">
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Image</th>
        <th>Name</th>
        <th>Description</th>
        <th>Color</th>
        <th>Size</th>
        <th>Price</th>
        <th>Discount Price</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $i => $it): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td>
            <img src="<?= htmlspecialchars($it['image']) ?>" alt="<?= htmlspecialchars($it['name']) ?>"
                 style="width:36px;height:36px;object-fit:cover;border-radius:6px;">
          </td>
          <td><?= htmlspecialchars($it['name']) ?></td>
          <td class="muted"><?= htmlspecialchars($it['description']) ?></td>
          <td><?= htmlspecialchars($it['color']) ?></td>
          <td><?= htmlspecialchars($it['size']) ?></td>
          <td>$<?= number_format($it['price'], 2) ?></td>
          <td>$<?= number_format($it['discount_price'], 2) ?></td>
          <td><?= htmlspecialchars($it['created']) ?></td>
          <td style="white-space:nowrap;">
            <a class="btn" href="<?= $base ?>/item-form.php?id=<?= (int)$it['id'] ?>">Edit</a>
            <a class="btn danger" href="#" onclick="return confirm('Delete this item?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
