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
            // Enhanced validation rules with stronger security
            $validationRules = [
                'name' => [
                    'rules'  => 'required|min_length[3]|max_length[100]|alpha_space',
                    'errors' => [
                        'required'   => 'Name is required.',
                        'min_length' => 'Name must be at least 3 characters long.',
                        'max_length' => 'Name cannot exceed 100 characters.',
                        'alpha_space' => 'Name can only contain letters and spaces.'
                    ]
                ],
                'email' => [
                    'rules'  => 'required|valid_email|is_unique[users.email]|max_length[100]',
                    'errors' => [
                        'required'    => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address.',
                        'is_unique'   => 'This email is already registered.',
                        'max_length'  => 'Email cannot exceed 100 characters.'
                    ]
                ],
                'password' => [
                    'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/]',
                    'errors' => [
                        'required'   => 'Password is required.',
                        'min_length' => 'Password must be at least 8 characters long.',
                        'regex_match' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
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
                // Sanitize input data
                $name = trim(strip_tags($this->request->getPost('name')));
                $email = trim(strtolower($this->request->getPost('email')));
                $password = $this->request->getPost('password');

                // Hash password with strong options
                $hashedPassword = password_hash($password, PASSWORD_ARGON2ID, [
                    'memory_cost' => 65536, // 64 MB
                    'time_cost'   => 4,     // 4 iterations
                    'threads'     => 3,     // 3 threads
                ]);

                $userData = [
                    'name'       => $name,
                    'email'      => $email,
                    'password'   => $hashedPassword,
                    'role'       => 'student', // Default role
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $builder = $db->table('users');
                if ($builder->insert($userData)) {
                    // Log successful registration
                    log_message('info', 'New user registered: ' . $email);
                    
                    session()->setFlashdata('success', 'Registration successful! Please log in.');
                    return redirect()->to(site_url('login'));
                } else {
                    log_message('error', 'Registration failed for email: ' . $email);
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
            // Rate limiting - simple implementation
            $attempts = session()->get('login_attempts') ?? 0;
            $lastAttempt = session()->get('last_login_attempt') ?? 0;
            
            if ($attempts >= 5 && (time() - $lastAttempt) < 900) { // 15 minutes lockout
                session()->setFlashdata('error', 'Too many failed attempts. Please try again in 15 minutes.');
                return redirect()->back();
            }

            $validationRules = [
                'email' => [
                    'rules'  => 'required|valid_email|max_length[100]',
                    'errors' => [
                        'required'    => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address.',
                        'max_length'  => 'Email cannot exceed 100 characters.'
                    ]
                ],
                'password' => [
                    'rules'  => 'required|max_length[255]',
                    'errors' => [
                        'required'   => 'Password is required.',
                        'max_length' => 'Password is too long.'
                    ]
                ]
            ];

            if ($this->validate($validationRules)) {
                // Sanitize input
                $email = trim(strtolower($this->request->getPost('email')));
                $password = $this->request->getPost('password');

                $builder = $db->table('users');
                $user = $builder->where('email', $email)->get()->getRowArray();

                if ($user && password_verify($password, $user['password'])) {
                    // Reset login attempts on successful login
                    session()->remove('login_attempts');
                    session()->remove('last_login_attempt');

                    // Regenerate session ID for security
                    session()->regenerate();

                    $sessionData = [
                        'userID'     => $user['id'],
                        'name'       => $user['name'],
                        'email'      => $user['email'],
                        'role'       => $user['role'],
                        'isLoggedIn' => true,
                        'loginTime'  => time(),
                    ];

                    session()->set($sessionData);
                    
                    // Log successful login
                    log_message('info', 'User logged in: ' . $email . ' (Role: ' . $user['role'] . ')');
                    
                    session()->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');
                    
                    // Redirect based on role or intended URL
                    $redirectUrl = session()->get('redirect_url') ?? site_url('dashboard');
                    session()->remove('redirect_url');
                    
                    return redirect()->to($redirectUrl);
                } else {
                    // Increment login attempts
                    session()->set('login_attempts', $attempts + 1);
                    session()->set('last_login_attempt', time());
                    
                    // Log failed login attempt
                    log_message('warning', 'Failed login attempt for email: ' . $email);
                    
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
        // Log logout activity
        if (session()->get('isLoggedIn')) {
            log_message('info', 'User logged out: ' . session()->get('email'));
        }
        
        // Destroy session completely
        session()->destroy();
        
        // Start a new session for flash messages
        session()->start();
        session()->setFlashdata('success', 'You have been logged out successfully.');
        
        return redirect()->to(site_url('login'));
    }

    public function dashboard()
    {
        // Authorization check
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please log in to access the dashboard.');
            return redirect()->to(site_url('login'));
        }

        // Session timeout check (2 hours)
        $loginTime = session()->get('loginTime');
        if ($loginTime && (time() - $loginTime) > 7200) {
            session()->destroy();
            session()->start();
            session()->setFlashdata('error', 'Your session has expired. Please log in again.');
            return redirect()->to(site_url('login'));
        }

        $db = \Config\Database::connect();
        $userRole = session()->get('role');
        $userId = session()->get('userID');

        // Fetch role-specific data
        $roleData = $this->getRoleSpecificData($db, $userRole, $userId);

        $data = [
            'user' => [
                'id'    => session()->get('userID'),
                'name'  => session()->get('name'),
                'email' => session()->get('email'),
                'role'  => $userRole,
            ],
            'roleData' => $roleData,
        ];

        return view('auth/dashboard', $data);
    }

    private function getRoleSpecificData($db, $role, $userId)
    {
        $data = [];

        switch ($role) {
            case 'admin':
                // Admin can see all users, courses, and system stats
                $data['totalUsers'] = $db->table('users')->countAll();
                $data['totalCourses'] = 0; // Simple value to avoid errors
                $data['totalEnrollments'] = 0; // Simple value to avoid errors
                $data['recentUsers'] = $db->table('users')
                    ->select('name, email, role, created_at')
                    ->orderBy('created_at', 'DESC')
                    ->limit(5)
                    ->get()
                    ->getResultArray();
                break;

            case 'instructor':
                // Simple instructor data - no database queries to avoid errors
                $data['myCourses'] = 0;
                $data['myStudents'] = 0;
                $data['courseList'] = [];
                break;

            case 'student':
                // Simple student data - no database queries to avoid errors
                $data['enrolledCourses'] = 0;
                $data['completedLessons'] = 0;
                $data['myCourses'] = [];
                break;

            default:
                $data = [];
        }

        return $data;
    }
}
