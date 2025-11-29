LABORATORY EXERCISE 9
SEARCH AND FILTERING SYSTEM

Learning Objectives
	By the end of this laboratory exercise, students should be able to:
	Implement client-side search filtering using jQuery for dynamic user experience.
	Develop server-side search functionality using CodeIgniter's database queries.
	Create a responsive search interface using Bootstrap components.
	Integrate AJAX techniques to display search results without page reload.
	Understand the differences between client-side and server-side search approaches.

Prerequisite student experiences and knowledge
Before starting this exercise, students should have:
	Completed Laboratory Exercise 8 (Real-time Notifications with jQuery).
	Solid understanding of CodeIgniter's MVC architecture and database operations.
	Proficiency in writing jQuery and JavaScript code for DOM manipulation.
	Experience with AJAX requests and handling JSON responses.
	Familiarity with Bootstrap form components and grid system.
	Knowledge of SQL queries, particularly LIKE operators for search functionality.

Background
An effective search system is crucial for any Learning Management System (LMS) to help users quickly find relevant courses and content. This exercise focuses on implementing a dual-approach search system: client-side filtering for immediate feedback and server-side searching for comprehensive results. jQuery provides the tools for dynamic client-side filtering, while CodeIgniter's database class enables efficient server-side search using SQL LIKE queries. The combination creates a seamless user experience where search results update in real-time without page refreshes, enhancing the overall usability of the application.

Materials/Resources
•	Personal Computer with Internet Access
•	XAMPP/WAMP/LAMP server installed
•	CodeIgniter Framework 
•	Visual Studio Code or any code editor
•	Git and GitHub Account
•	Web Browser (Chrome, Firefox, etc.)






Laboratory Activity
Step 1: Project Setup
1.	Open your existing ITE311-LASTNAME CodeIgniter project.
2.	Ensure your database has a courses table with sample data for testing search functionality.
3.	Verify that your course listing page is functional from previous exercises.

Step 2: Create Search Controller Method
1.	Navigate to your Course.php controller in app/Controllers/.
2.	Add a new method named search():
	This method should accept GET or POST requests with a search term parameter.
	Use CodeIgniter's Query Builder to search the courses table using LIKE queries.
	Return the results as JSON for AJAX requests or render a view for regular requests.
3.	Implement the search logic
 

Step 3: Add Search Route
1.	Open app/Config/Routes.php.
2.	Add routes for the search functionality:
 











Step 4: Create Search Interface
1.	Modify your courses view file (app/Views/courses/index.php).
2.	Add a search form with Bootstrap styling
 


Step 5: Implement Client-Side Filtering with jQuery
1.	Add jQuery script for instant client-side filtering
 










Step 6: Update Courses View Structure
1.	Modify your courses listing to work with the search functionality
 
2.	To simulate real-time updates, you can set an interval to fetch notifications every 60 seconds (optional advanced task).

Step 7: Test the Search Functionality
1.	Load the courses page in your browser.
2.	Test the client-side filtering by typing in the search box courses should filter instantly.
3.	Test the server-side search by submitting the form results should load via AJAX without page refresh.
4.	Verify that both empty search results and successful searches display appropriate messages.

Step 9: Push to GitHub
1.	Stage and commit your search functionality
 

Output / Results
	Screenshot of the courses page with the search interface implemented.
	Screenshot showing filtered courses during client-side search.
	Screenshot of browser Developer Tools Network tab showing AJAX request to server-side search.
	Screenshot of search results displaying when no courses match the search term.
	Screenshot of GitHub repository with the latest commit.






QUESTIONS:
1.	What are the advantages and limitations of client-side filtering compared to server-side search?

Advantages of Client-Side Filtering

•	Speed: Filtering happens instantly in the browser with no network requests.
•	Reduced server load: Server doesn’t need to perform repeated searches.
•	Smooth user experience: Results can update in real time as users type.
•	Offline capability: Works even without a network connection (if data is already loaded).
       Limitations of Client-Side Filtering
•	Requires loading all data upfront: Not practical for large datasets.
•	Browser performance limits: Large data can slow down the UI.
•	Security/data exposure: All data must be sent to the client, even if sensitive.
•	No dynamic or up-to-date results: Cannot search data that isn’t already loaded.

2.	How does using AJAX for search improve the user experience compared to traditional form submission?

- AJAX improves the user experience by updating search results instantly without reloading the entire page. This makes the search feel faster, smoother, and more interactive, allowing features like live search suggestions and real-time filtering.

3.	What security considerations should be taken when implementing search functionality with user input?

- Search input must be validated and sanitized to prevent attacks such as SQL injection and XSS. Using parameterized queries, escaping output, limiting requests, and avoiding exposure of sensitive data help keep the search feature secure.





Output / Results
1.Screenshot of the courses page with the search interface implemented.
 
	Screenshot showing filtered courses during client-side search.
 





Screenshot of browser Developer Tools Network tab showing AJAX request to server-side search.
	Screenshot of search results displaying when no courses match the search term.
                   Screenshot of GitHub repository with the latest commit.







Conclusion

























<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>My Courses</h3>
            <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Enrolled Courses Section -->
        <div class="mb-5">
            <h4><i class="fas fa-graduation-cap text-primary"></i> My Enrolled Courses</h4>
            <?php if (empty($enrolledCourses)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> You are not enrolled in any courses yet.
                    Browse available courses below to get started!
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($enrolledCourses as $course): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-success">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <?= esc($course['title']) ?>
                                    </h5>
                                    <p class="card-text text-muted">
                                        <?= esc(substr($course['description'] ?? '', 0, 100)) ?>
                                        <?= strlen($course['description'] ?? '') > 100 ? '...' : '' ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-success">
                                            <i class="fas fa-user"></i> 
                                            <?= esc($course['instructor_name'] ?? 'Instructor') ?>
                                        </span>
                                        <a href="<?= site_url('course/' . $course['course_id'] . '/materials') ?>" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-book"></i> View Materials
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Available Courses Section with Search -->
        <div>
            <h4><i class="fas fa-search text-primary"></i> Browse Available Courses</h4>
            
            <!-- Search Form -->
            <form id="searchForm" class="mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" 
                                   id="searchInput" 
                                   name="search_term" 
                                   class="form-control" 
                                   placeholder="Search available courses...">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" id="clearSearch" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Clear
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
            
            <!-- Available Courses Container -->
            <div id="coursesContainer">
                <?php if (empty($availableCourses)): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        No additional courses available for enrollment at the moment.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($availableCourses as $course): ?>
                            <div class="col-md-6 col-lg-4 mb-4 course-card" 
                                 data-title="<?= strtolower(esc($course['title'] ?? '')) ?>" 
                                 data-description="<?= strtolower(esc($course['description'] ?? '')) ?>">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-book-open text-primary"></i>
                                            <?= esc($course['title'] ?? 'Untitled Course') ?>
                                        </h5>
                                        <p class="card-text text-muted">
                                            <?= esc(substr($course['description'] ?? '', 0, 100)) ?>
                                            <?= strlen($course['description'] ?? '') > 100 ? '...' : '' ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-user"></i> 
                                                <?= esc($course['instructor_name'] ?? 'Instructor') ?>
                                            </span>
                                            <button class="btn btn-success btn-sm enroll-btn" 
                                                    data-course-id="<?= $course['id'] ?>"
                                                    data-course-title="<?= esc($course['title']) ?>">
                                                <i class="fas fa-plus-circle"></i> Enroll
                                            </button>
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
                <i class="fas fa-exclamation-triangle"></i> 
                No courses found matching your search criteria.
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
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
                    location.reload();
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
                                                    <i class="fas fa-book-open text-primary"></i>
                                                    ${courseTitle}
                                                </h5>
                                                <p class="card-text text-muted">${displayDesc}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-user"></i> 
                                                        ${course.instructor_name || 'Instructor'}
                                                    </span>
                                                    <button class="btn btn-success btn-sm enroll-btn" 
                                                            data-course-id="${course.id}"
                                                            data-course-title="${courseTitle}">
                                                        <i class="fas fa-plus-circle"></i> Enroll
                                                    </button>
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
                                <i class="fas fa-exclamation-circle"></i>
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
            
            // Enrollment functionality
            $(document).on('click', '.enroll-btn', function() {
                const btn = $(this);
                const courseId = btn.data('course-id');
                const courseTitle = btn.data('course-title');
                
                // Disable button and show loading
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Enrolling...');
                
                $.ajax({
                    url: BASE_URL + 'course/enroll',
                    method: 'POST',
                    data: { course_id: courseId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            const successHtml = `
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="fas fa-check-circle"></i>
                                    Successfully enrolled in "${courseTitle}"!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            `;
                            $('#coursesContainer').before(successHtml);
                            
                            // Remove the course card from available courses
                            btn.closest('.course-card').fadeOut(300, function() {
                                $(this).remove();
                            });
                        } else {
                            // Show error message
                            btn.prop('disabled', false).html('<i class="fas fa-plus-circle"></i> Enroll');
                            const errorHtml = `
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <i class="fas fa-exclamation-circle"></i>
                                    ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            `;
                            $('#coursesContainer').before(errorHtml);
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-plus-circle"></i> Enroll');
                        const errorHtml = `
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle"></i>
                                An error occurred. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        `;
                        $('#coursesContainer').before(errorHtml);
                    }
                });
            });
        });
    </script>
</body>
</html>
