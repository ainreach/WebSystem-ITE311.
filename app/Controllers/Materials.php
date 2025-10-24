<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\EnrollmentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Materials extends BaseController
{
    protected $materialModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    public function upload($course_id)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please log in.');
            return redirect()->to(site_url('login'));
        }

        $role = session()->get('role');
        if (!in_array($role, ['admin', 'teacher'])) {
            session()->setFlashdata('error', 'Unauthorized.');
            return redirect()->to(site_url('dashboard'));
        }

        if ($this->request->getMethod() === 'POST') {
            $validationRules = [
                'material' => [
                    'rules' => 'uploaded[material]|max_size[material,10240]|ext_in[material,pdf,ppt,pptx]',
                ]
            ];

            if (!$this->validate($validationRules)) {
                session()->setFlashdata('errors', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }

            $file = $this->request->getFile('material');
            if (!$file || !$file->isValid()) {
                session()->setFlashdata('error', 'Invalid file upload.');
                return redirect()->back();
            }

            $originalName = $file->getClientName();
            $newName = $file->getRandomName();

            $uploadDir = WRITEPATH . 'uploads/materials';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }

            if (!$file->move($uploadDir, $newName)) {
                session()->setFlashdata('error', 'Failed to move uploaded file.');
                return redirect()->back();
            }

            $relativePath = 'uploads/materials/' . $newName;

            $data = [
                'course_id' => (int) $course_id,
                'file_name' => $originalName,
                'file_path' => $relativePath,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $insertId = $this->materialModel->insertMaterial($data);
            if ($insertId) {
                session()->setFlashdata('success', 'Material uploaded successfully.');
                return redirect()->to(site_url('course/' . $course_id));
            } else {
                session()->setFlashdata('error', 'Failed to save material.');
                return redirect()->back();
            }
        }

        return view('materials/upload', ['course_id' => $course_id]);
    }

    public function delete($material_id)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please log in.');
            return redirect()->to(site_url('login'));
        }

        $role = session()->get('role');
        if (!in_array($role, ['admin', 'teacher'])) {
            session()->setFlashdata('error', 'Unauthorized.');
            return redirect()->to(site_url('dashboard'));
        }

        $material = $this->materialModel->getById((int) $material_id);
        if (!$material) {
            session()->setFlashdata('error', 'Material not found.');
            return redirect()->back();
        }

        $fullPath = WRITEPATH . $material['file_path'];
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }

        $this->materialModel->deleteMaterial((int) $material_id);
        session()->setFlashdata('success', 'Material deleted.');
        return redirect()->back();
    }

    public function download($material_id)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please log in to download.');
            return redirect()->to(site_url('login'));
        }

        $material = $this->materialModel->getById((int) $material_id);
        if (!$material) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Material not found');
        }

        $userId = session()->get('user_id') ?: session()->get('userID');
        $role = session()->get('role');
        $courseId = (int) $material['course_id'];

        $authorized = in_array($role, ['admin', 'teacher']) || $this->enrollmentModel->isAlreadyEnrolled((int) $userId, $courseId);
        if (!$authorized) {
            session()->setFlashdata('error', 'Access denied.');
            return redirect()->to(site_url('courses'));
        }

        $fullPath = WRITEPATH . $material['file_path'];
        if (!is_file($fullPath)) {
            session()->setFlashdata('error', 'File not found on server.');
            return redirect()->back();
        }

        return $this->response->download($fullPath, null)->setFileName($material['file_name']);
    }

    public function materialsList($course_id)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please log in to view materials.');
            return redirect()->to(site_url('login'));
        }

        $userId = session()->get('user_id') ?: session()->get('userID');
        $role = session()->get('role');

        $authorized = in_array($role, ['admin', 'teacher']) || $this->enrollmentModel->isAlreadyEnrolled((int) $userId, (int) $course_id);
        if (!$authorized) {
            session()->setFlashdata('error', 'Access denied.');
            return redirect()->to(site_url('courses'));
        }

        $materials = $this->materialModel->getMaterialsByCourse((int) $course_id);

        return view('materials/list', [
            'course_id' => (int) $course_id,
            'materials' => $materials,
        ]);
    }
}
