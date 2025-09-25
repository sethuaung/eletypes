<?php
$title = 'Categories';
$current = 'categories';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';

// Fake data — replace with DB query results.
$categories = [
  ['name' => 'Men',   'created' => '2025-01-12'],
  ['name' => 'Women', 'created' => '2025-02-05'],
  ['name' => 'Kid',   'created' => '2025-03-10'],
];
?>

<section class="page-header">
  <div>
    <h1>Categories</h1>
    <p class="muted">Manage product categories (Men, Women, Kid).</p>
  </div>
  <div class="actions">
    <label for="modal-create" class="btn primary">+ Create Category</label>
  </div>
</section>

<!-- Toggle lives here -->
<input type="checkbox" id="modal-create" class="modal-toggle" aria-hidden="true">

<!-- Modal -->
<div class="modal">
  <label for="modal-create" class="modal-overlay" aria-label="Close"></label>

  <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-header">
      <div class="modal-title-row">
        <span class="modal-icon">🗂️</span>
        <h3 id="modal-title">Create New Category</h3>
      </div>
      <label for="modal-create" class="modal-close" aria-label="Close">×</label>
    </div>

    <form id="create-cat-form" class="modal-body form" method="post" action="#">
      <label class="field">
        <span>Category Name</span>
        <input type="text" name="name" placeholder="e.g., Men, Women, Kid" required>
      </label>
    </form>

    <div class="modal-footer">
      <label for="modal-create" class="btn">Cancel</label>
      <button class="btn primary" type="submit" form="create-cat-form">Create Category</button>
    </div>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Category</th>
          <th>Created</th>
          <th style="width:1%">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $i => $c): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td>
            <div style="display:flex">
              <span class="avatar avatar-sm" style="margin-right: 4px;">📂</span>
            <div class="user-name"><?= htmlspecialchars($c['name']) ?></div>
            </div>
          </td>
          <td><?= htmlspecialchars($c['created']) ?></td>
          <td>
            <div class="btn-group">
              <button class="btn small primary" type="button">Edit</button>
              <button class="btn small danger" type="button">Delete</button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
