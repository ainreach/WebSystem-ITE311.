<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;

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
        $enrolledCourses = $enrollmentModel->getUserEnrollments($userId);
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>My Courses</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        
        if (empty($enrolledCourses)) {
            $html .= '<div class="alert alert-info">You are not enrolled in any courses yet. <a href="' . site_url('courses') . '">Browse courses</a></div>';
        } else {
            $html .= '<div class="row">';
            foreach ($enrolledCourses as $course) {
                $html .= '<div class="col-md-6 mb-3">';
                $html .= '<div class="card">';
                $html .= '<div class="card-body">';
                $html .= '<h5 class="card-title">' . htmlspecialchars($course['title']) . '</h5>';
                $html .= '<p class="card-text">' . htmlspecialchars(substr($course['description'] ?? '', 0, 100)) . '...</p>';
                $html .= '<a href="' . site_url('course/' . $course['course_id'] . '/materials') . '" class="btn btn-primary btn-sm">View Materials</a>';
                $html .= '</div></div></div>';
            }
            $html .= '</div>';
        }
        
        $html .= '</div></body></html>';
        return $html;
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
