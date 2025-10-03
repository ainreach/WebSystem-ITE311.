<?= $this->include('templates/header', ['title' => 'Dashboard - ITE311-NABALE']) ?>

<style>
    .admin-terminal {
        background: #1e1e1e;
        color: #ffffff;
        font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .commit-style {
        background: #2d2d2d;
        border: 1px solid #404040;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    .commit-style:hover {
        background: #363636;
        border-color: #505050;
    }
    .commit-dot {
        width: 8px;
        height: 8px;
        background: #00ff00;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    .commit-hash {
        color: #ffd700;
        font-weight: bold;
        margin-right: 8px;
    }
    .commit-message {
        color: #ffffff;
    }
    .commit-meta {
        color: #888888;
        font-size: 12px;
        margin-left: 16px;
    }
    .simple-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 16px;
        transition: all 0.2s ease;
    }
    .simple-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #495057;
    }
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="container">
    <!-- Role-Specific Dashboard Content -->
    <?php if ($user['role'] === 'admin'): ?>
        <!-- ADMIN DASHBOARD - Simple Terminal Style -->
        <div class="admin-terminal">
            <div class="d-flex align-items-center mb-3">
                <span class="commit-dot"></span>
                <span class="commit-hash">admin</span>
                <span class="commit-message">dashboard (admin only)</span>
            </div>
            <div class="commit-meta">
                Welcome back, <?= $user['name'] ?> • Role: Administrator • Last login: <?= date('M j, Y g:i A') ?>
            </div>
        </div>

        <!-- Simple Statistics -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="simple-card text-center">
                    <div class="stat-number"><?= $roleData['totalUsers'] ?? 0 ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="simple-card text-center">
                    <div class="stat-number"><?= $roleData['totalCourses'] ?? 0 ?></div>
                    <div class="stat-label">Total Courses</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="simple-card text-center">
                    <div class="stat-number"><?= $roleData['totalEnrollments'] ?? 0 ?></div>
                    <div class="stat-label">Total Enrollments</div>
                </div>
            </div>
        </div>

        <!-- Simple Actions -->
        <div class="row">
            <div class="col-12">
                <div class="admin-terminal">
                    <div class="mb-3">
                        <span class="commit-dot" style="background: #ff6b6b;"></span>
                        <span class="commit-message">Quick Actions</span>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('admin/users') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">users</span>
                            <span class="commit-message">Manage system users and permissions</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('admin/courses') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">courses</span>
                            <span class="commit-message">Manage courses and content</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('admin/reports') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">reports</span>
                            <span class="commit-message">View system reports and analytics</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('admin/settings') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">settings</span>
                            <span class="commit-message">Configure system settings</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'instructor'): ?>
        <!-- INSTRUCTOR DASHBOARD - Simple Style -->
        <div class="admin-terminal">
            <div class="d-flex align-items-center mb-3">
                <span class="commit-dot" style="background: #28a745;"></span>
                <span class="commit-hash">instructor</span>
                <span class="commit-message">dashboard (instructor only)</span>
            </div>
            <div class="commit-meta">
                Welcome back, <?= $user['name'] ?> • Role: Instructor • Manage your courses and students
            </div>
        </div>

        <!-- Simple Statistics -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="simple-card text-center">
                    <div class="stat-number"><?= $roleData['myCourses'] ?? 0 ?></div>
                    <div class="stat-label">My Courses</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="simple-card text-center">
                    <div class="stat-number"><?= $roleData['myStudents'] ?? 0 ?></div>
                    <div class="stat-label">My Students</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions for Instructor -->
        <div class="row">
            <div class="col-12">
                <div class="admin-terminal">
                    <div class="mb-3">
                        <span class="commit-dot" style="background: #17a2b8;"></span>
                        <span class="commit-message">Quick Actions</span>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('instructor/courses') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">courses</span>
                            <span class="commit-message">Manage my courses</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('instructor/students') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">students</span>
                            <span class="commit-message">View my students</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('instructor/lessons') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">lessons</span>
                            <span class="commit-message">Manage lessons and content</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('instructor/courses/create') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">create</span>
                            <span class="commit-message">Create new course</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'student'): ?>
        <!-- STUDENT DASHBOARD - Simple Style -->
        <div class="admin-terminal">
            <div class="d-flex align-items-center mb-3">
                <span class="commit-dot" style="background: #007bff;"></span>
                <span class="commit-hash">student</span>
                <span class="commit-message">dashboard (student only)</span>
            </div>
            <div class="commit-meta">
                Welcome back, <?= $user['name'] ?> • Role: Student • Track your learning progress
            </div>
        </div>

        <!-- Simple Statistics -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="simple-card text-center">
                    <div class="stat-number"><?= $roleData['enrolledCourses'] ?? 0 ?></div>
                    <div class="stat-label">Enrolled Courses</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="simple-card text-center">
                    <div class="stat-number"><?= $roleData['completedLessons'] ?? 0 ?></div>
                    <div class="stat-label">Completed Lessons</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions for Student -->
        <div class="row">
            <div class="col-12">
                <div class="admin-terminal">
                    <div class="mb-3">
                        <span class="commit-dot" style="background: #6f42c1;"></span>
                        <span class="commit-message">Quick Actions</span>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('student/courses') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">courses</span>
                            <span class="commit-message">View my enrolled courses</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('courses') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">browse</span>
                            <span class="commit-message">Browse available courses</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('student/assignments') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">assignments</span>
                            <span class="commit-message">View my assignments</span>
                        </a>
                    </div>
                    
                    <div class="commit-style">
                        <a href="<?= site_url('student/grades') ?>" class="text-decoration-none text-white">
                            <span class="commit-hash">grades</span>
                            <span class="commit-message">Check my grades</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- FALLBACK FOR UNKNOWN ROLE -->
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Access Restricted:</strong> Your account role is not recognized. Please contact the administrator.
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<?= $this->include('templates/footer') ?>
