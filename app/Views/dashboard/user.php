<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="<?= site_url('/') ?>">ITE311-NABALE</a>
      <div class="d-flex">
        <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <div class="alert alert-success mb-4">User Dashboard</div>

    <div class="card mb-3">
      <div class="card-body">
        <h3 class="h5 mb-2">Welcome, <?= esc($user['name'] ?? 'User') ?>!</h3>
        <p class="mb-1">Email: <?= esc($user['email'] ?? '') ?></p>
        <span class="badge bg-success">Role: <?= esc(ucfirst($user['role'] ?? 'user')) ?></span>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="card h-100"><div class="card-body text-center">My Courses (placeholder)</div></div>
      </div>
      <div class="col-md-4">
        <div class="card h-100"><div class="card-body text-center">Notifications (placeholder)</div></div>
      </div>
      <div class="col-md-4">
        <div class="card h-100"><div class="card-body text-center">Profile (placeholder)</div></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
