<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Admin Panel</div>
    <div class="list-group list-group-flush">
        <a href="/" class="list-group-item list-group-item-action bg-light <?php echo ($current == 'dashboard') ? 'active' : ''; ?>">Dashboard</a>
        <a href="/users.php" class="list-group-item list-group-item-action bg-light <?php echo ($current == 'users') ? 'active' : ''; ?>">Users</a>
        <a href="/addresses.php" class="list-group-item list-group-item-action bg-light <?php echo ($current == 'addresses') ? 'active' : ''; ?>">Addresses</a>
        <a href="/products.php" class="list-group-item list-group-item-action bg-light <?php echo ($current == 'products') ? 'active' : ''; ?>">Products</a>
        <a href="/categories.php" class="list-group-item list-group-item-action bg-light <?php echo ($current == 'categories') ? 'active' : ''; ?>">Categories</a>
        <a href="/carts.php" class="list-group-item list-group-item-action bg-light <?php echo ($current == 'carts') ? 'active' : ''; ?>">Carts</a>
        <a href="/items.php" class="list-group-item list-group-item-action bg-light <?php echo ($current == 'items') ? 'active' : ''; ?>">Items</a>
        <a href="/orders.php" class="list-group-item list-group-item-action bg-light <?php echo ($current == 'orders') ? 'active' : ''; ?>">Orders</a>
    </div>
</div>
<div id="page-content-wrapper">
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
</nav>
