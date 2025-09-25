<?php
// sidebar.php
$current = $current ?? '';
function active($key, $current) { return $key === $current ? 'active' : ''; }
?>
<aside class="sidebar">
  <div class="sidebar-inner">
    <nav class="menu" aria-label="Main">
      <a class="menu-item <?= active('dashboard', $current) ?>" href="<?= $base ?>/index.php">🏠 Dashboard</a>
      <a class="menu-item <?= active('categories', $current) ?>" href="<?= $base ?>/categories.php">📂 Categories</a>
      <a class="menu-item <?= active('items', $current) ?>" href="<?= $base ?>/items.php">📦 Items</a>
      <a class="menu-item <?= active('users', $current) ?>" href="<?= $base ?>/users.php">👥 Users</a>
      <a class="menu-item <?= active('orders', $current) ?>" href="<?= $base ?>/orders.php">🛒 Orders</a>
      <a class="menu-item <?= active('cart', $current) ?>" href="<?= $base ?>/carts.php">📇 Carts</a>	  
	  </nav>
    <div class="sidebar-foot">
      <small>v1.0 • © <?= date('Y') ?></small>
    </div>
  </div>
</aside>
<main class="content">
