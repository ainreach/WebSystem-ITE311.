<?= $this->include('templates/header', ['title' => 'Dashboard - ITE311-NABALE']) ?>

<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">Welcome back, <?= $user['name'] ?>!</h2>
                            <p class="mb-0">You are logged in as <strong><?= ucfirst($user['role']) ?></strong></p>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-user-circle fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role-Specific Dashboard Content -->
    <?php if ($user['role'] === 'admin'): ?>
        <!-- ADMIN DASHBOARD -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="text-center"><i class="fas fa-shield-alt text-primary me-2"></i>Admin Panel</h3>
            </div>
        </div>

        <!-- Simple Statistics -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-users fa-2x text-primary mb-2"></i>
                        <h3 class="mb-1"><?= $roleData['totalUsers'] ?? 0 ?></h3>
                        <p class="text-muted mb-0">Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-book fa-2x text-success mb-2"></i>
                        <h3 class="mb-1"><?= $roleData['totalCourses'] ?? 0 ?></h3>
                        <p class="text-muted mb-0">Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-graduation-cap fa-2x text-info mb-2"></i>
                        <h3 class="mb-1"><?= $roleData['totalEnrollments'] ?? 0 ?></h3>
                        <p class="text-muted mb-0">Enrollments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Management -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5>User Management</h5>
                        <p class="text-muted">Manage system users</p>
                        <a href="<?= site_url('admin/users') ?>" class="btn btn-primary">Manage Users</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-3x text-success mb-3"></i>
                        <h5>Course Management</h5>
                        <p class="text-muted">Manage all courses</p>
                        <a href="<?= site_url('admin/courses') ?>" class="btn btn-success">Manage Courses</a>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'instructor'): ?>
        <!-- INSTRUCTOR DASHBOARD -->
        <div class="row mb-4">
            <div class="col-12">
                <h3><i class="fas fa-chalkboard-teacher text-success me-2"></i>Instructor Dashboard</h3>
                <p class="text-muted">Manage your courses, students, and lessons.</p>
            </div>
        </div>

        <!-- Instructor Statistics -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="fas fa-book-open fa-3x text-success mb-3"></i>
                        <h4 class="text-success"><?= $roleData['myCourses'] ?? 0 ?></h4>
                        <p class="mb-0">My Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <i class="fas fa-user-graduate fa-3x text-info mb-3"></i>
                        <h4 class="text-info"><?= $roleData['myStudents'] ?? 0 ?></h4>
                        <p class="mb-0">My Students</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Courses -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>My Courses</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($roleData['courseList'])): ?>
                            <div class="row">
                                <?php foreach ($roleData['courseList'] as $course): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="card-title"><?= esc($course['title']) ?></h6>
                                                <p class="card-text text-muted"><?= esc($course['description']) ?></p>
                                                <small class="text-muted">Created: <?= date('M j, Y', strtotime($course['created_at'])) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                                <p class="text-muted">You haven't created any courses yet.</p>
                                <a href="<?= site_url('teacher/courses/create') ?>" class="btn btn-primary">Create Your First Course</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'student'): ?>
        <!-- STUDENT DASHBOARD -->
        <div class="row mb-4">
            <div class="col-12">
                <h3><i class="fas fa-user-graduate text-primary me-2"></i>Student Dashboard</h3>
                <p class="text-muted">Track your progress and access your courses.</p>
            </div>
        </div>

        <!-- Student Statistics -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-3x text-primary mb-3"></i>
                        <h4 class="text-primary"><?= $roleData['enrolledCourses'] ?? 0 ?></h4>
                        <p class="mb-0">Enrolled Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h4 class="text-success"><?= $roleData['completedLessons'] ?? 0 ?></h4>
                        <p class="mb-0">Completed Lessons</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Courses -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>My Courses</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($roleData['myCourses'])): ?>
                            <div class="row">
                                <?php foreach ($roleData['myCourses'] as $course): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="card-title"><?= esc($course['title']) ?></h6>
                                                <p class="card-text text-muted"><?= esc($course['description']) ?></p>
                                                <small class="text-muted">Enrolled: <?= date('M j, Y', strtotime($course['enrolled_at'])) ?></small>
                                            </div>
                                            <div class="card-footer">
                                                <a href="<?= site_url('student/courses/' . $course['title']) ?>" class="btn btn-sm btn-primary">Continue Learning</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <p class="text-muted">You haven't enrolled in any courses yet.</p>
                                <a href="<?= site_url('courses') ?>" class="btn btn-primary">Browse Courses</a>
                            </div>
                        <?php endif; ?>
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

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if ($user['role'] === 'admin'): ?>
                            <div class="col-md-6 mb-2">
                                <a href="<?= site_url('admin/users') ?>" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-users me-2"></i>Users
                                </a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="<?= site_url('admin/courses') ?>" class="btn btn-outline-success w-100">
                                    <i class="fas fa-book me-2"></i>Courses
                                </a>
                            </div>
                        <?php elseif ($user['role'] === 'instructor'): ?>
                            <div class="col-md-3 mb-2">
                                <a href="<?= site_url('instructor/courses/create') ?>" class="btn btn-outline-success w-100">
                                    <i class="fas fa-plus me-2"></i>Create Course
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="<?= site_url('instructor/lessons') ?>" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-clipboard-list me-2"></i>Manage Lessons
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="<?= site_url('instructor/students') ?>" class="btn btn-outline-info w-100">
                                    <i class="fas fa-user-graduate me-2"></i>View Students
                                </a>
                            </div>
                        <?php elseif ($user['role'] === 'student'): ?>
                            <div class="col-md-3 mb-2">
                                <a href="<?= site_url('courses') ?>" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-search me-2"></i>Browse Courses
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="<?= site_url('student/assignments') ?>" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-tasks me-2"></i>My Assignments
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="<?= site_url('student/grades') ?>" class="btn btn-outline-success w-100">
                                    <i class="fas fa-star me-2"></i>View Grades
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-3 mb-2">
                            <a href="<?= site_url('profile') ?>" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>
