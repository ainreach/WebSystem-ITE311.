<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function register()
    {
        $db = \Config\Database::connect();

        if ($this->request->getMethod() === 'POST') {
            // Validation rules with messages (MACA style)
            $validationRules = [
                'name' => [
                    'rules'  => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required'   => 'Name is required.',
                        'min_length' => 'Name must be at least 3 characters long.',
                        'max_length' => 'Name cannot exceed 100 characters.'
                    ]
                ],
                'email' => [
                    'rules'  => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required'    => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address.',
                        'is_unique'   => 'This email is already registered.'
                    ]
                ],
                'password' => [
                    'rules'  => 'required|min_length[6]',
                    'errors' => [
                        'required'   => 'Password is required.',
                        'min_length' => 'Password must be at least 6 characters long.'
                    ]
                ],
                'password_confirm' => [
                    'rules'  => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Password confirmation is required.',
                        'matches'  => 'Password confirmation does not match.'
                    ]
                ]
            ];

            if ($this->validate($validationRules)) {
                $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

                $userData = [
                    'name'       => $this->request->getPost('name'),
                    'email'      => $this->request->getPost('email'),
                    'password'   => $hashedPassword,
                    'role'       => 'student',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $builder = $db->table('users');
                if ($builder->insert($userData)) {
                    session()->setFlashdata('success', 'Registration successful! Please log in.');
                    return redirect()->to(site_url('login'));
                } else {
                    session()->setFlashdata('error', 'Registration failed. Please try again.');
                }
            } else {
                session()->setFlashdata('errors', $this->validator->getErrors());
            }
        }

        return view('auth/register');
    }

    public function login()
    {
        $db = \Config\Database::connect();

        if ($this->request->getMethod() === 'POST') {
            $validationRules = [
                'email' => [
                    'rules'  => 'required|valid_email',
                    'errors' => [
                        'required'    => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address.'
                    ]
                ],
                'password' => [
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Password is required.'
                    ]
                ]
            ];

            if ($this->validate($validationRules)) {
                $email    = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                $builder = $db->table('users');
                $user    = $builder->where('email', $email)->get()->getRowArray();

                if ($user && password_verify($password, $user['password'])) {
                    $sessionData = [
                        'userID'     => $user['id'],
                        'name'       => $user['name'],
                        'email'      => $user['email'],
                        'role'       => $user['role'],
                        'isLoggedIn' => true,
                    ];

                    session()->set($sessionData);
                    session()->setFlashdata('success', 'Welcome, ' . $user['name'] . '!');
                    return redirect()->to(site_url('dashboard'));
                } else {
                    session()->setFlashdata('error', 'Invalid email or password.');
                }
            } else {
                session()->setFlashdata('errors', $this->validator->getErrors());
            }
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to(site_url('login'));
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please log in to access the dashboard.');
            return redirect()->to(site_url('login'));
        }

        $data = [
            'user' => [
                'name'  => session()->get('name'),
                'email' => session()->get('email'),
                'role'  => session()->get('role'),
            ],
        ];

        return view('auth/dashboard', $data);
    }
}
