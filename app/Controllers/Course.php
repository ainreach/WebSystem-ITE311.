<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\NotificationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Course extends BaseController
{
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    /**
     * Handle AJAX enrollment request
     * @return ResponseInterface
     */
    public function enroll()
    {
        // Set response type to JSON
        $this->response->setContentType('application/json');

        try {
            // Check if user is logged in
            if (!session()->get('isLoggedIn')) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You must be logged in to enroll in courses.'
                ])->setStatusCode(401);
            }

            // Get user ID from session (try both possible keys)
            $userId = session()->get('user_id') ?: session()->get('userID');
            
            if (!$userId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You must be logged in to enroll in courses.'
                ])->setStatusCode(401);
            }
            
            // Get course ID from POST request
            $courseId = $this->request->getPost('course_id');

            // Validate course ID
            if (!$courseId || !is_numeric($courseId)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid course ID provided.'
                ])->setStatusCode(400);
            }

            // Check if course exists
            $course = $this->courseModel->getCourseById($courseId);
            if (!$course) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Course not found.'
                ])->setStatusCode(404);
            }

            // Check if user is already enrolled
            if ($this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You are already enrolled in this course.'
                ])->setStatusCode(409);
            }

            // Prepare enrollment data
            $enrollmentData = [
                'user_id' => $userId,
                'course_id' => $courseId,
                'enrolled_at' => date('Y-m-d H:i:s')
            ];

            // Insert enrollment record
            $enrollmentId = $this->enrollmentModel->enrollUser($enrollmentData);

            if ($enrollmentId) {
                // Create notification for the user
                $notificationModel = new NotificationModel();
                $notificationModel->createNotification(
                    $userId,
                    'enrollment',
                    'You have successfully enrolled in "' . $course['title'] . '"'
                );

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Successfully enrolled in the course!',
                    'enrollment_id' => $enrollmentId,
                    'course_title' => $course['title']
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to enroll in the course. Please try again.'
                ])->setStatusCode(500);
            }

        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Enrollment error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while enrolling. Please try again later.'
            ])->setStatusCode(500);
        }
    }

    /**
     * Display all courses
     * @return string
     */
    public function index()
    {
        $courses = $this->courseModel->getAllCourses();
        return view('courses/index', ['courses' => $courses]);
    }

    /**
     * Display course details
     * @param int $id
     * @return string
     */
    public function view($id)
    {
        $course = $this->courseModel->getCourseById($id);
        if (!$course) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Course not found');
        }
        $title = htmlspecialchars($course['title'] ?? 'Course');
        $desc = nl2br(htmlspecialchars($course['description'] ?? ''));
        $html = "<div class=\"container mt-4\">";
        $html .= "<h3>{$title}</h3>";
        if ($desc) {
            $html .= "<p>{$desc}</p>";
        }
        $html .= "<div class=\"mt-3\">";
        // Determine back URL based on user role
        $role = session()->get('role');
        if (in_array($role, ['admin', 'teacher'])) {
            $backUrl = site_url('admin/courses');
        } else {
            $backUrl = site_url('courses');
        }
        $html .= "<a class=\"btn btn-secondary btn-sm\" href=\"" . $backUrl . "\">Back</a> ";
        $html .= "<a class=\"btn btn-outline-primary btn-sm\" href=\"" . site_url('course/' . (int)$id . '/materials') . "\">View Materials</a>";
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }

    /**
     * Get available courses for a user (AJAX endpoint)
     * @return ResponseInterface
     */
    public function getAvailableCourses()
    {
        $this->response->setContentType('application/json');

        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        $userId = session()->get('user_id') ?: session()->get('userID');
        $availableCourses = $this->enrollmentModel->getAvailableCourses($userId);

        return $this->response->setJSON([
            'success' => true,
            'courses' => $availableCourses
        ]);
    }

    /**
     * Get user's enrolled courses (AJAX endpoint)
     * @return ResponseInterface
     */
    public function getEnrolledCourses()
    {
        $this->response->setContentType('application/json');

        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        $userId = session()->get('user_id') ?: session()->get('userID');
        $enrolledCourses = $this->enrollmentModel->getUserEnrollments($userId);

        return $this->response->setJSON([
            'success' => true,
            'courses' => $enrolledCourses
        ]);
    }

    /**
     * Search courses functionality
     * @return ResponseInterface|string
     */
    public function search()
    {
        $searchTerm = $this->request->getGet('search_term') ?? $this->request->getPost('search_term');

        if (!empty($searchTerm)) {
            $this->courseModel->select('courses.*, users.name as instructor_name');
            $this->courseModel->join('users', 'users.id = courses.instructor_id', 'left');
            $this->courseModel->like('courses.title', $searchTerm);
            $this->courseModel->orLike('courses.description', $searchTerm);
        } else {
            $this->courseModel->select('courses.*, users.name as instructor_name');
            $this->courseModel->join('users', 'users.id = courses.instructor_id', 'left');
        }

        $courses = $this->courseModel->findAll();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($courses);
        }

        return view('courses/search_results', ['courses' => $courses, 'searchTerm' => $searchTerm]);
    }
}
