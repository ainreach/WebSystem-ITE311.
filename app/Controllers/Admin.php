<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    private function checkAuth()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(site_url('login'));
        }
        return null;
    }

    public function users()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $db = \Config\Database::connect();
        $users = $db->table('users')->get()->getResultArray();
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>Manage Users</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        $html .= '<table class="table table-striped table-bordered">';
        $html .= '<thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th></tr></thead><tbody>';
        
        foreach ($users as $u) {
            $html .= '<tr>';
            $html .= '<td>' . (int)$u['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($u['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($u['email']) . '</td>';
            $html .= '<td><span class="badge bg-primary">' . htmlspecialchars($u['role']) . '</span></td>';
            $html .= '<td>' . htmlspecialchars($u['created_at']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table></div></body></html>';
        return $html;
    }

    public function courses()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $db = \Config\Database::connect();
        $courses = $db->table('courses')->get()->getResultArray();
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>Manage Courses</h3>';
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
                $html .= '<a href="' . site_url('admin/course/' . $c['id'] . '/upload') . '" class="btn btn-sm btn-success">Upload Material</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            
            $html .= '</tbody></table>';
        }
        
        $html .= '</div></body></html>';
        return $html;
    }

    public function reports()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>View Reports</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        $html .= '<div class="alert alert-info">Reports feature coming soon.</div>';
        $html .= '</div></body></html>';
        return $html;
    }

    public function settings()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>';
        $html .= '<div class="container mt-4">';
        $html .= '<h3>System Settings</h3>';
        $html .= '<a href="' . site_url('dashboard') . '" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>';
        $html .= '<div class="alert alert-info">Settings feature coming soon.</div>';
        $html .= '</div></body></html>';
        return $html;
    }
}
