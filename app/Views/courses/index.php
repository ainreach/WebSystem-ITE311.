<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>All Courses</h3>
        
        <!-- Search Form -->
        <form id="searchForm" class="mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" 
                               id="searchInput" 
                               name="search_term" 
                               class="form-control" 
                               placeholder="Search courses...">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" id="clearSearch" class="btn btn-outline-secondary w-100">
                        Clear
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="text-center d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        
        <!-- Courses Container -->
        <div id="coursesContainer">
            <?php if (empty($courses)): ?>
                <div class="alert alert-info">
                    No courses found.
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-6 col-lg-4 mb-4 course-card" 
                             data-title="<?= strtolower(esc($course['title'] ?? '')) ?>" 
                             data-description="<?= strtolower(esc($course['description'] ?? '')) ?>">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= esc($course['title'] ?? 'Untitled Course') ?>
                                    </h5>
                                    <p class="card-text text-muted">
                                        <?= esc(substr($course['description'] ?? '', 0, 100)) ?>
                                        <?= strlen($course['description'] ?? '') > 100 ? '...' : '' ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-secondary">
                                            <?= esc($course['instructor_name'] ?? 'Instructor') ?>
                                        </span>
                                        <a href="<?= site_url('course/' . $course['id']) ?>" 
                                           class="btn btn-primary btn-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- No Results Message (initially hidden) -->
        <div id="noResults" class="alert alert-warning d-none">
            No courses found matching your search criteria.
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    
    <script>
        const BASE_URL = '<?= site_url() ?>';

        $(document).ready(function() {
            // Client-side filtering on keyup
        $('#searchInput').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            if (searchTerm === '') {
                $('.course-card').show();
                $('#noResults').addClass('d-none');
                return;
            }
            
            let hasResults = false;
            
            $('.course-card').each(function() {
                const title = $(this).data('title');
                const description = $(this).data('description');
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    $(this).show();
                    hasResults = true;
                } else {
                    $(this).hide();
                }
            });
            
            // Show/hide no results message
            if (hasResults) {
                $('#noResults').addClass('d-none');
            } else {
                $('#noResults').removeClass('d-none');
            }
        });
        
        // Server-side search on form submit
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            
            const searchTerm = $('#searchInput').val();
            
            if (searchTerm.trim() === '') {
                window.location.reload();
                return;
            }
            
            // Show loading spinner
            $('#loadingSpinner').removeClass('d-none');
            $('#coursesContainer').addClass('d-none');
            $('#noResults').addClass('d-none');
            
            // Perform AJAX search
            $.ajax({
                url: BASE_URL + 'courses/search',
                method: 'GET',
                data: { search_term: searchTerm },
                dataType: 'json',
                success: function(response) {
                    $('#loadingSpinner').addClass('d-none');
                    $('#coursesContainer').removeClass('d-none').empty();
                    
                    if (response.length === 0) {
                        $('#noResults').removeClass('d-none');
                    } else {
                        let html = '<div class="row">';
                        
                        response.forEach(function(course) {
                            const courseTitle = course.title || 'Untitled Course';
                            const courseDesc = course.description || '';
                            const displayDesc = courseDesc.length > 100 ? 
                                courseDesc.substring(0, 100) + '...' : courseDesc;
                            
                            html += `
                                <div class="col-md-6 col-lg-4 mb-4 course-card" 
                                     data-title="${courseTitle.toLowerCase()}" 
                                     data-description="${courseDesc.toLowerCase()}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                ${courseTitle}
                                            </h5>
                                            <p class="card-text text-muted">${displayDesc}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-secondary">
                                                    ${course.instructor_name || 'Instructor'}
                                                </span>
                                                <a href="${BASE_URL + 'course/' + course.id}" 
                                                   class="btn btn-primary btn-sm">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        html += '</div>';
                        $('#coursesContainer').html(html);
                    }
                },
                error: function(xhr, status, error) {
                    $('#loadingSpinner').addClass('d-none');
                    $('#coursesContainer').removeClass('d-none');
                    
                    // Show error message
                    const errorHtml = `
                        <div class="alert alert-danger">
                            An error occurred while searching. Please try again.
                        </div>
                    `;
                    $('#coursesContainer').html(errorHtml);
                }
            });
        });
        
        // Clear search functionality
        $('#clearSearch').on('click', function() {
            $('#searchInput').val('');
            $('.course-card').show();
            $('#noResults').addClass('d-none');
        });
    });
    </script>
</body>
</html>
