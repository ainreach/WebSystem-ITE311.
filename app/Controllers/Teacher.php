<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Teacher extends BaseController
{
    private function checkAuth()
    {
        if (!session()->get('isLoggedIn') || !in_array(session()->get('role'), ['admin', 'teacher'])) {
            session()->setFlashdata('error', 'Unauthorized access. Admin or Teacher role required.');
            return redirect()->to(site_url('login'));
        }
        return null;
    }

    public function courses()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $db = \Config\Database::connect();
        $courses = $db->table('courses')->get()->getResultArray();
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>My Courses</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        
        if (empty($courses)) {
            $html .= '<div class="alert alert-info">No courses found. Add courses via phpMyAdmin or create a seeder.</div>';
        } else {
            $html .= '<table class="table table-striped table-bordered">';
            $html .= '<thead class="table-dark"><tr><th>ID</th><th>Title</th><th>Description</th><th>Actions</th></tr></thead><tbody>';
            
            foreach ($courses as $c) {
                $html .= '<tr>';
                $html .= '<td>' . (int)$c['id'] . '</td>';
                $html .= '<td>' . htmlspecialchars($c['title']) . '</td>';
                $html .= '<td>' . htmlspecialchars(substr($c['description'] ?? '', 0, 80)) . '...</td>';
                $html .= '<td>';
                $html .= '<a href="' . site_url('course/' . $c['id']) . '" class="btn btn-sm btn-primary me-1">View</a>';
                $html .= '<a href="' . site_url('teacher/course/' . $c['id'] . '/upload') . '" class="btn btn-sm btn-success">Upload Material</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            
            $html .= '</tbody></table>';
        }
        
        $html .= '</div></body></html>';
        return $html;
    }

    public function students()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $db = \Config\Database::connect();
        // Show only students, not all users
        $students = $db->table('users')->where('role', 'student')->get()->getResultArray();
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>My Students</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        $html .= '<table class="table table-striped table-bordered">';
        $html .= '<thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th></tr></thead><tbody>';
        
        foreach ($students as $s) {
            $html .= '<tr>';
            $html .= '<td>' . (int)$s['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($s['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($s['email']) . '</td>';
            $html .= '<td><span class="badge bg-success">' . htmlspecialchars($s['role']) . '</span></td>';
            $html .= '<td>' . htmlspecialchars($s['created_at']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table></div></body></html>';
        return $html;
    }

    public function lessons()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $db = \Config\Database::connect();
        $courses = $db->table('courses')->get()->getResultArray();
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>Manage Lessons</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        $html .= '<div class="alert alert-info">Lessons feature coming soon. You can manage courses and upload materials from the courses page.</div>';
        
        if (!empty($courses)) {
            $html .= '<h5 class="mt-4">Available Courses:</h5>';
            $html .= '<table class="table table-striped table-bordered">';
            $html .= '<thead class="table-dark"><tr><th>ID</th><th>Course Title</th><th>Actions</th></tr></thead><tbody>';
            
            foreach ($courses as $c) {
                $html .= '<tr>';
                $html .= '<td>' . (int)$c['id'] . '</td>';
                $html .= '<td>' . htmlspecialchars($c['title']) . '</td>';
                $html .= '<td>';
                $html .= '<a href="' . site_url('admin/course/' . $c['id'] . '/upload') . '" class="btn btn-sm btn-success">Upload Materials</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            
            $html .= '</tbody></table>';
        }
        
        $html .= '</div></body></html>';
        return $html;
    }

    public function createCourse()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>Create Course</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        $html .= '<div class="alert alert-info">Course creation feature coming soon. For now, add courses via phpMyAdmin or run the CoursesSeeder.</div>';
        $html .= '</div></body></html>';
        return $html;
    }
}
