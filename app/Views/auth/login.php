<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ITE311 NABALE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .card-body {
            padding: 2.5rem;
        }
        .btn-primary {
            background-color: #4a69bd;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #3b5998;
        }
        .form-control-lg {
            border-radius: 8px;
            padding: 0.75rem 1.25rem;
        }
        .form-control:focus {
            border-color: #4a69bd;
            box-shadow: 0 0 0 0.25rem rgba(74, 105, 189, 0.25);
        }
        .footer {
            background-color: transparent;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url('/') ?>">
                <i class="fas fa-graduation-cap me-2"></i> ITE311-NABALE
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Login</h2>
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li class="small"><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('login') ?>" method="POST">
                            <?= csrf_field() ?>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                       value="<?= old('email') ?>" placeholder="Enter your email" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                       placeholder="Enter your password" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center mt-4">
                        <p class="mb-2">Don't have an account? <a href="<?= site_url('register') ?>" class="text-decoration-none">Register here</a></p>
                        <p class="mb-0"><a href="<?= site_url('/') ?>" class="text-decoration-none">Back to Home</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light border-top mt-auto py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>ITE311-NABALE</h5>
                    <p class="text-muted">Learning Management System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">&copy; <?= date('Y') ?> ITE311 NABALE. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
