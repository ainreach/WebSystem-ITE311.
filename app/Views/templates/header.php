<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= isset($title) ? $title : 'ITE311-NABALE' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            padding-top: 76px; /* Account for fixed navbar */
        }
        .navbar-brand {
            font-weight: bold;
        }
        .role-badge {
            font-size: 0.75em;
            margin-left: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url('/dashboard') ?>">
                <i class="fas fa-graduation-cap me-2"></i> ITE311-NABALE
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (current_url() == site_url('dashboard')) ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                    
                    <?php if (session()->get('isLoggedIn')): ?>
                        <?php $userRole = session()->get('role'); ?>
                        
                        <?php if ($userRole === 'admin'): ?>
                            <!-- Admin Navigation -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('admin/users') ?>">
                                    <i class="fas fa-users me-1"></i> Manage Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('admin/courses') ?>">
                                    <i class="fas fa-book me-1"></i> Manage Courses
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('admin/reports') ?>">
                                    <i class="fas fa-chart-bar me-1"></i> Reports
                                </a>
                            </li>
                        
                        <?php elseif ($userRole === 'teacher'): ?>
                            <!-- Teacher Navigation -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('teacher/courses') ?>">
                                    <i class="fas fa-chalkboard-teacher me-1"></i> My Courses
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('teacher/students') ?>">
                                    <i class="fas fa-user-graduate me-1"></i> My Students
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('teacher/lessons') ?>">
                                    <i class="fas fa-clipboard-list me-1"></i> Lessons
                                </a>
                            </li>
                        
                        <?php elseif ($userRole === 'student'): ?>
                            <!-- Student Navigation -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('student/courses') ?>">
                                    <i class="fas fa-book-open me-1"></i> My Courses
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('student/assignments') ?>">
                                    <i class="fas fa-tasks me-1"></i> Assignments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('student/grades') ?>">
                                    <i class="fas fa-star me-1"></i> Grades
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                
                <!-- Notifications -->
                <?php if (session()->get('isLoggedIn')): ?>
                    <div class="dropdown me-3">
                        <button class="btn btn-outline-light position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notification-badge" style="display: none;">
                                0
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
                            <li><h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                Notifications
                                <button class="btn btn-sm btn-link text-decoration-none" id="mark-all-read" style="font-size: 0.8rem;">Mark all as read</button>
                            </h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <div id="notification-list">
                                <li><span class="dropdown-item-text text-muted text-center">No new notifications</span></li>
                            </div>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <!-- User Menu -->
                <?php if (session()->get('isLoggedIn')): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>
                            <?= session()->get('name') ?>
                            <span class="badge bg-light text-primary role-badge"><?= ucfirst(session()->get('role')) ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Account</h6></li>
                            <li><a class="dropdown-item" href="<?= site_url('profile') ?>">
                                <i class="fas fa-user-edit me-2"></i> Profile
                            </a></li>
                            <li><a class="dropdown-item" href="<?= site_url('settings') ?>">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="d-flex">
                        <a href="<?= site_url('login') ?>" class="btn btn-outline-light me-2">Login</a>
                        <a href="<?= site_url('register') ?>" class="btn btn-light">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container mt-3">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
