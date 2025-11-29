<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>Course Search Results</h3>
        
        <?php if (!empty($searchTerm)): ?>
            <p class="text-muted">Showing results for: "<strong><?= esc($searchTerm) ?></strong>"</p>
        <?php endif; ?>
        
        <?php if (empty($courses)): ?>
            <div class="alert alert-info">
                <?php if (!empty($searchTerm)): ?>
                    No courses found matching your search term.
                <?php else: ?>
                    No courses available.
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($course['title'] ?? 'Untitled Course') ?></h5>
                                <p class="card-text">
                                    <?= esc(substr($course['description'] ?? '', 0, 100)) ?>
                                    <?= strlen($course['description'] ?? '') > 100 ? '...' : '' ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-secondary">
                                        <?= esc($course['instructor_name'] ?? 'Instructor') ?>
                                    </span>
                                    <a href="<?= site_url('course/' . $course['id']) ?>" class="btn btn-primary btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-3">
                <a href="<?= site_url('courses') ?>" class="btn btn-secondary">Back to All Courses</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
