<?= $this->include('templates/header', ['title' => 'Dashboard - ITE311-NABALE']) ?>

<style>
    .dashboard-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .welcome-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        border-left: 4px solid #007bff;
    }
    
    .welcome-section h3 {
        margin: 0 0 10px 0;
        color: #333;
    }
    
    .welcome-section p {
        margin: 0;
        color: #666;
    }
    
    .stats-row {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
    }
    
    .stat-box {
        flex: 1;
        background: white;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
        text-align: center;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #666;
        font-size: 0.9rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
    }
    
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .course-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
    }
    
    .course-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    
    .course-instructor {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    
    .course-code {
        color: #999;
        font-size: 0.8rem;
        margin-bottom: 15px;
    }
    
    .course-date {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    
    .enroll-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        width: 100%;
        font-weight: 500;
    }
    
    .enroll-btn:hover {
        background: #0056b3;
        color: white;
    }
    
    .enroll-btn:disabled {
        background: #6c757d;
    }
    
    .enrolled-badge {
        background: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 0.8rem;
    }
    
    .empty-message {
        text-align: center;
        color: #666;
        padding: 40px;
        background: #f8f9fa;
        border-radius: 5px;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .action-link {
        display: block;
        padding: 15px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
    }
    
    .action-link:hover {
        background: #f8f9fa;
        text-decoration: none;
        color: #333;
    }
    
    .alert-container {
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 1050;
        max-width: 350px;
    }
</style>

<div class="dashboard-container">
    <?php if ($user['role'] === 'admin'): ?>
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h3>Admin Dashboard</h3>
            <p>Welcome back, <?= $user['name'] ?>!</p>
        </div>

        <!-- Statistics -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-number"><?= $roleData['totalUsers'] ?? 0 ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= $roleData['totalCourses'] ?? 0 ?></div>
                <div class="stat-label">Total Courses</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= $roleData['totalEnrollments'] ?? 0 ?></div>
                <div class="stat-label">Total Enrollments</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h4 class="section-title">Quick Actions</h4>
        <div class="quick-actions">
            <a href="<?= site_url('admin/users') ?>" class="action-link">
                <i class="fas fa-users me-2"></i> Manage Users
            </a>
            <a href="<?= site_url('admin/courses') ?>" class="action-link">
                <i class="fas fa-book me-2"></i> Manage Courses
            </a>
            <a href="<?= site_url('admin/reports') ?>" class="action-link">
                <i class="fas fa-chart-bar me-2"></i> View Reports
            </a>
            <a href="<?= site_url('admin/settings') ?>" class="action-link">
                <i class="fas fa-cog me-2"></i> System Settings
            </a>
        </div>

    <?php elseif ($user['role'] === 'teacher'): ?>
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h3>Teacher Dashboard</h3>
            <p>Welcome back, <?= $user['name'] ?>!</p>
        </div>

        <!-- Statistics -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-number"><?= $roleData['myCourses'] ?? 0 ?></div>
                <div class="stat-label">My Courses</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= $roleData['myStudents'] ?? 0 ?></div>
                <div class="stat-label">My Students</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h4 class="section-title">Quick Actions</h4>
        <div class="quick-actions">
            <a href="<?= site_url('teacher/courses') ?>" class="action-link">
                <i class="fas fa-book me-2"></i> My Courses
            </a>
            <a href="<?= site_url('teacher/students') ?>" class="action-link">
                <i class="fas fa-user-graduate me-2"></i> My Students
            </a>
            <a href="<?= site_url('teacher/lessons') ?>" class="action-link">
                <i class="fas fa-clipboard-list me-2"></i> Manage Lessons
            </a>
            <a href="<?= site_url('teacher/courses/create') ?>" class="action-link">
                <i class="fas fa-plus me-2"></i> Create Course
            </a>
        </div>

    <?php elseif ($user['role'] === 'student'): ?>
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h3>Student Dashboard</h3>
            <p>Welcome back, <?= $user['name'] ?>!</p>
        </div>

        <!-- Statistics -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-number"><?= $roleData['enrolledCourses'] ?? 0 ?></div>
                <div class="stat-label">Enrolled Courses</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= $roleData['completedLessons'] ?? 0 ?></div>
                <div class="stat-label">Completed Lessons</div>
            </div>
        </div>

        <!-- Enrolled Courses Section -->
        <?php if (!empty($roleData['myCourses'])): ?>
            <h4 class="section-title">My Enrolled Courses</h4>
            <div class="courses-grid" id="enrolled-courses">
                <?php foreach ($roleData['myCourses'] as $course): ?>
                    <div class="course-card">
                        <div class="course-title"><?= esc($course['title']) ?></div>
                        <div class="course-instructor"><i class="fas fa-user me-1"></i> Janjan Maranan</div>
                        <div class="course-code">ITE311</div>
                        <div class="course-date"><i class="fas fa-calendar me-1"></i> Enrolled: <?= date('M j, Y', strtotime($course['enrolled_at'])) ?></div>
                        <span class="enrolled-badge"><i class="fas fa-check-circle me-1"></i> Enrolled</span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Available Courses Section -->
        <h4 class="section-title">Available Courses</h4>
        <div class="courses-grid" id="available-courses">
            <?php if (!empty($roleData['availableCourses'])): ?>
                <?php foreach ($roleData['availableCourses'] as $course): ?>
                    <div class="course-card available-course-item" data-course-id="<?= $course['id'] ?>">
                        <div class="course-title"><?= esc($course['title']) ?></div>
                        <div class="course-instructor"><i class="fas fa-user me-1"></i> Janjan Maranan</div>
                        <div class="course-code">ITE311</div>
                        <div class="course-date"><i class="fas fa-calendar me-1"></i> Oct 10, 2025</div>
                        <button class="enroll-btn" 
                                data-course-id="<?= $course['id'] ?>" 
                                data-course-title="<?= esc($course['title']) ?>">
                            <i class="fas fa-plus me-1"></i> Enroll Now
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-message">
                    <p>No available courses at the moment. You are enrolled in all available courses!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <h4 class="section-title">Quick Actions</h4>
        <div class="quick-actions">
            <a href="<?= site_url('student/courses') ?>" class="action-link">
                <i class="fas fa-book-open me-2"></i> My Courses
            </a>
            <a href="<?= site_url('courses') ?>" class="action-link">
                <i class="fas fa-search me-2"></i> Browse Courses
            </a>
            <a href="<?= site_url('student/assignments') ?>" class="action-link">
                <i class="fas fa-tasks me-2"></i> My Assignments
            </a>
            <a href="<?= site_url('student/grades') ?>" class="action-link">
                <i class="fas fa-star me-2"></i> My Grades
            </a>
        </div>

    <?php else: ?>
        <!-- FALLBACK FOR UNKNOWN ROLE -->
        <div class="section-card">
            <div class="section-content">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Access Restricted:</strong> Your account role is not recognized. Please contact the administrator.
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Alert container for messages -->
<div class="alert-container" id="alert-container"></div>

<!-- AJAX Enrollment Script -->
<?php if ($user['role'] === 'student'): ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle enrollment button clicks
    $('.enroll-btn').on('click', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const courseId = button.data('course-id');
        const courseTitle = button.data('course-title');
        const courseItem = button.closest('.available-course-item');
        
        // Disable button and show loading state
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin me-1"></i> Enrolling...');
        
        // Get CSRF token
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const csrfName = '<?= csrf_token() ?>';
        
        // Make AJAX request
        $.ajax({
            url: '<?= site_url('course/enroll') ?>',
            type: 'POST',
            data: {
                course_id: courseId,
                [csrfName]: csrfToken
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Remove course from available courses
                    courseItem.fadeOut(300, function() {
                        $(this).remove();
                        
                        // Check if no more available courses
                        if ($('#available-courses .available-course-item').length === 0) {
                            $('#available-courses').html(`
                                <div class="empty-message">
                                    <p>Great job! You are enrolled in all available courses.</p>
                                </div>
                            `);
                        }
                    });
                    
                    // Add course to enrolled courses
                    const enrolledHtml = `
                        <div class="course-card" style="display: none;">
                            <div class="course-title">${courseTitle}</div>
                            <div class="course-instructor"><i class="fas fa-user me-1"></i> Janjan Maranan</div>
                            <div class="course-code">ITE311</div>
                            <div class="course-date"><i class="fas fa-calendar me-1"></i> Enrolled: Just now</div>
                            <span class="enrolled-badge"><i class="fas fa-check-circle me-1"></i> Enrolled</span>
                        </div>
                    `;
                    
                    // Show enrolled courses section if hidden
                    if ($('#enrolled-courses').length === 0) {
                        const enrolledSection = `
                            <h4 class="section-title">My Enrolled Courses</h4>
                            <div class="courses-grid" id="enrolled-courses"></div>
                        `;
                        $('.stats-row').after(enrolledSection);
                    }
                    
                    // Add new enrolled course
                    $('#enrolled-courses').prepend(enrolledHtml);
                    $('#enrolled-courses .course-card:first').fadeIn(300);
                    
                    // Update enrolled courses count
                    const currentCount = parseInt($('.stat-number').first().text()) || 0;
                    $('.stat-number').first().text(currentCount + 1);
                    
                } else {
                    // Show error message
                    showAlert('danger', response.message);
                    
                    // Re-enable button
                    button.prop('disabled', false);
                    button.html('<i class="fas fa-plus me-1"></i> Enroll Now');
                }
            },
            error: function(xhr, status, error) {
                console.error('Enrollment error:', error);
                
                let errorMessage = 'An error occurred while enrolling. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 401) {
                    errorMessage = 'You must be logged in to enroll in courses.';
                } else if (xhr.status === 403) {
                    errorMessage = 'You do not have permission to enroll in courses.';
                }
                
                showAlert('danger', errorMessage);
                
                // Re-enable button
                button.prop('disabled', false);
                button.html('<i class="fas fa-plus me-1"></i> Enroll Now');
            }
        });
    });
    
    // Function to show simple alerts
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas ${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        $('#alert-container').html(alertHtml);
        
        // Auto-dismiss success alerts after 3 seconds
        if (type === 'success') {
            setTimeout(function() {
                $('#alert-container .alert').fadeOut();
            }, 3000);
        }
    }
});
</script>
<?php endif; ?>

<?= $this->include('templates/footer') ?>
