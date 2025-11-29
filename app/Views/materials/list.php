<?php /** @var int $course_id */ /** @var array $materials */ ?>
<?php echo view('template'); ?>

<div class="container mt-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?php echo esc(session()->getFlashdata('success')); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?php echo esc(session()->getFlashdata('error')); ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Course Materials</h4>
        <div>
            <?php 
            $role = session()->get('role');
            if ($role === 'student') {
                $backUrl = site_url('student/courses');
                $backText = 'Back to My Courses';
            } elseif (in_array($role, ['admin', 'teacher'])) {
                $backUrl = site_url('admin/courses');
                $backText = 'Back to Courses';
            } else {
                $backUrl = site_url('dashboard');
                $backText = 'Back to Dashboard';
            }
            ?>
            <a href="<?php echo $backUrl; ?>" class="btn btn-secondary btn-sm">
                <?php echo $backText; ?>
            </a>
            <?php if (in_array(session()->get('role'), ['admin','teacher'])): ?>
                <a href="<?php echo site_url('admin/course/' . $course_id . '/upload'); ?>" class="btn btn-primary btn-sm ms-2">Upload Material</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($materials)): ?>
        <div class="alert alert-info">No materials available for this course yet.</div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($materials as $m): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-semibold"><?php echo esc($m['file_name']); ?></div>
                        <small class="text-muted">Uploaded: <?php echo esc($m['created_at']); ?></small>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-outline-success btn-sm" href="<?php echo site_url('materials/download/' . $m['id']); ?>">Download</a>
                        <?php if (in_array(session()->get('role'), ['admin','teacher'])): ?>
                            <a class="btn btn-outline-danger btn-sm" href="<?php echo site_url('materials/delete/' . $m['id']); ?>" onclick="return confirm('Delete this material?');">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
