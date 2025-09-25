<?php
// header.php
$title = $title ?? 'Admin';

$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$base = ($base === '/' || $base === '\\') ? '' : $base;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($title) ?> · Admin</title>
  <meta name="color-scheme" content="light dark">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?= $base ?>/assets/css/styles.css">
</head>
<body>
  <input type="checkbox" id="nav-toggle" class="nav-toggle" aria-hidden="true">
  <header class="topbar">
    <label for="nav-toggle" class="hamburger" aria-label="Toggle navigation" title="Menu">☰</label>
    <div class="brand">
      <span class="brand-dot"></span>
      <strong>Online Sale Shopping</strong> Admin
    </div>
    <div class="topbar-actions">
      <form class="search" role="search" action="#" method="get">
        <input type="search" placeholder="Search…" aria-label="Search" name="q">
      </form>
      <div class="profile">
        <span class="avatar" aria-hidden="true">👤</span>
        <span class="name">Admin</span>
      </div>
    </div>
  </header>
  <div class="layout">
