<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');

// Authentication routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Auth::dashboard');

// Course routes
$routes->get('/courses', 'Course::index');
$routes->get('/course/(:num)', 'Course::view/$1');
$routes->get('/course/(:num)/materials', 'Materials::materialsList/$1');
$routes->post('/course/enroll', 'Course::enroll');
$routes->get('/course/available', 'Course::getAvailableCourses');
$routes->get('/course/enrolled', 'Course::getEnrolledCourses');
$routes->get('/courses/search', 'Course::search');
$routes->post('/courses/search', 'Course::search');
// Materials routes
$routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('/materials/download/(:num)', 'Materials::download/$1');

// Admin routes
$routes->get('/admin/users', 'Admin::users');
$routes->get('/admin/courses', 'Admin::courses');
$routes->get('/admin/reports', 'Admin::reports');
$routes->get('/admin/settings', 'Admin::settings');

// Student routes
$routes->get('/student/courses', 'Student::courses');
$routes->get('/student/assignments', 'Student::assignments');
$routes->get('/student/grades', 'Student::grades');

// Teacher routes
$routes->get('/teacher/courses', 'Teacher::courses');
$routes->get('/teacher/students', 'Teacher::students');
$routes->get('/teacher/lessons', 'Teacher::lessons');
$routes->get('/teacher/courses/create', 'Teacher::createCourse');
$routes->get('/teacher/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/teacher/course/(:num)/upload', 'Materials::upload/$1');

// Notification routes (AJAX)
$routes->get('/notifications/count', 'Notification::getUnreadCount');
$routes->get('/notifications/unread', 'Notification::getUnreadNotifications');
$routes->post('/notifications/read/(:num)', 'Notification::markAsRead/$1');
$routes->post('/notifications/read-all', 'Notification::markAllAsRead');