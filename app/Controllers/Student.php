<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;
use App\Models\CourseModel;

class Student extends BaseController
{
    private function checkAuth()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            session()->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(site_url('login'));
        }
        return null;
    }

    public function courses()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $userId = session()->get('user_id') ?: session()->get('userID');
        $enrollmentModel = new EnrollmentModel();
        $courseModel = new CourseModel();
        
        $enrolledCourses = $enrollmentModel->getUserEnrollments($userId);
        $allCourses = $courseModel->getAllCourses();
        
        // Filter out already enrolled courses
        $availableCourses = [];
        $enrolledCourseIds = array_column($enrolledCourses, 'course_id');
        
        foreach ($allCourses as $course) {
            if (!in_array($course['id'], $enrolledCourseIds)) {
                $availableCourses[] = $course;
            }
        }
        
        return view('student/courses', [
            'enrolledCourses' => $enrolledCourses,
            'availableCourses' => $availableCourses
        ]);
    }

    public function assignments()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>My Assignments</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        $html .= '<div class="alert alert-info">Assignments feature coming soon.</div>';
        $html .= '</div></body></html>';
        return $html;
    }

    public function grades()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>My Grades</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        $html .= '<div class="alert alert-info">Grades feature coming soon.</div>';
        $html .= '</div></body></html>';
        return $html;
    }
}
