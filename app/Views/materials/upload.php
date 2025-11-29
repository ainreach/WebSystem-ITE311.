<?php /** @var int $course_id */ ?>
<?php echo view('template'); ?>

<div class="container mt-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?php echo esc(session()->getFlashdata('success')); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?php echo esc(session()->getFlashdata('error')); ?></div>
    <?php endif; ?>
    <?php if ($errors = session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?php echo esc($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Upload Course Material</h5>
            <?php 
            $role = session()->get('role');
            if ($role === 'admin') {
                $backUrl = site_url('admin/courses');
                $formUrl = site_url('admin/course/' . $course_id . '/upload');
            } elseif ($role === 'teacher') {
                $backUrl = site_url('teacher/courses');
                $formUrl = site_url('teacher/course/' . $course_id . '/upload');
            } else {
                $backUrl = site_url('dashboard');
                $formUrl = site_url('dashboard');
            }
            ?>
            <a href="<?php echo $backUrl; ?>" class="btn btn-secondary btn-sm">Back to Course</a>
        </div>
        <div class="card-body">
            <form action="<?php echo $formUrl; ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="material" class="form-label">Select File (PDF, PPT, PPTX)</label>
                    <input type="file" name="material" id="material" class="form-control" required accept="application/pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation">
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
