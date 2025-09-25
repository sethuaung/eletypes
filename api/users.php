<?php
$title = 'Users';
$current = 'users';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';

// Fake data — replace later with DB query results
$users = [
  ['name' => 'Alice Johnson', 'role' => 'Admin',   'address' => '123 Main St, NY',   'phone' => '555-1234'],
  ['name' => 'Bruno Díaz',    'role' => 'Editor',  'address' => '45 Central Rd, LA', 'phone' => '555-5678'],
  ['name' => 'Chen Wei',      'role' => 'Viewer',  'address' => '78 River St, SF',   'phone' => '555-9012'],
];
?>

<section class="page-header">
  <div>
    <h1>Users</h1>
    <p class="muted">Manage application users here.</p>
  </div>
  <div class="actions">
    <a class="btn primary" href="#add-user">+ Add User</a>
  </div>
</section>

<!-- User Form -->
<div class="card form" id="add-user">
  <h2>Add User</h2>
  <form method="post" action="#">
    <label class="field">
      <span>Name</span>
      <input type="text" name="name" placeholder="Enter full name">
    </label>
    <label class="field">
      <span>Role</span>
      <select name="role">
        <option>Admin</option>
        <option>Editor</option>
        <option>Viewer</option>
      </select>
    </label>
    <label class="field">
      <span>Address</span>
      <input type="text" name="address" placeholder="Enter address">
    </label>
    <label class="field">
      <span>Phone</span>
      <input type="text" name="phone" placeholder="Enter phone number">
    </label>
    <div class="form-actions">
      <button class="btn primary" type="submit">Save User</button>
      <button class="btn" type="reset">Reset</button>
    </div>
  </form>
</div>

<!-- Users Table -->
<div class="card">
  <div class="card-header">
    <h2>All Users</h2>
  </div>
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Role</th>
          <th>Address</th>
          <th>Phone</th>
          <th style="width:1%">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $i => $u): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($u['name']) ?></td>
          <td><?= htmlspecialchars($u['role']) ?></td>
          <td><?= htmlspecialchars($u['address']) ?></td>
          <td><?= htmlspecialchars($u['phone']) ?></td>
          <td>
            <div class="btn-group">
              <button class="btn small primary">Edit</button>
              <button class="btn small danger">Delete</button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
