<?php
$title = 'Dashboard';
$current = 'dashboard';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
?>

<section class="page-header">
  <div>
    <h1>Dashboard</h1>
    <p class="muted">Quick overview of what’s happening today.</p>
  </div>
</section>

<section class="grid stats">
  <?php
    $stats = [
      ['label' => 'Total Users', 'value' => '8,241', 'delta' => '+3.2%'],
      ['label' => 'Active Sessions', 'value' => '527', 'delta' => '+0.8%'],
      ['label' => 'Revenue (MTD)', 'value' => '$42,390', 'delta' => '+12.4%'],
      ['label' => 'Refunds', 'value' => '12', 'delta' => '-0.6%'],
    ];
    foreach ($stats as $s):
  ?>
  <div class="card stat">
    <div class="stat-label"><?= htmlspecialchars($s['label']) ?></div>
    <div class="stat-value"><?= htmlspecialchars($s['value']) ?></div>
    <div class="stat-delta <?= $s['delta'][0] === '-' ? 'down' : 'up' ?>">
      <?= htmlspecialchars($s['delta']) ?>
    </div>
  </div>
  <?php endforeach; ?>
</section>

<section class="grid two" style="margin-top: 30px;">
  <div class="card">
    <div class="card-header">
      <h2>Recent Orders</h2>
      <a class="link" href="#">View all</a>
    </div>
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>#ID</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Total</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $rows = [
              ['#1042','R. Singh','Paid','$129.00','2025-09-18'],
              ['#1041','A. Lopez','Pending','$89.50','2025-09-18'],
              ['#1040','J. Chen','Refunded','$59.00','2025-09-17'],
              ['#1039','M. Rossi','Paid','$249.00','2025-09-16'],
            ];
            foreach ($rows as $r):
          ?>
          <tr>
            <td><?= $r[0] ?></td>
            <td><?= htmlspecialchars($r[1]) ?></td>
            <td><span class="badge <?= strtolower($r[2]) ?>"><?= $r[2] ?></span></td>
            <td><?= $r[3] ?></td>
            <td><?= $r[4] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
