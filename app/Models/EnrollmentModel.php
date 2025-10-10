<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'course_id', 'enrolled_at'];
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    /**
     * Insert a new enrollment record
     * @param array $data
     * @return bool|int
     */
    public function enrollUser($data)
    {
        // Add current timestamp if not provided
        if (!isset($data['enrolled_at'])) {
            $data['enrolled_at'] = date('Y-m-d H:i:s');
        }

        return $this->insert($data);
    }

    /**
     * Fetch all courses a user is enrolled in
     * @param int $user_id
     * @return array
     */
    public function getUserEnrollments($user_id)
    {
        return $this->select('enrollments.*, courses.title, courses.description, courses.instructor_id')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->where('enrollments.user_id', $user_id)
                    ->findAll();
    }

    /**
     * Check if a user is already enrolled in a specific course
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    public function isAlreadyEnrolled($user_id, $course_id)
    {
        $enrollment = $this->where('user_id', $user_id)
                          ->where('course_id', $course_id)
                          ->first();
        
        return $enrollment !== null;
    }

    /**
     * Get all available courses that a user is not enrolled in
     * @param int $user_id
     * @return array
     */
    public function getAvailableCourses($user_id)
    {
        $db = \Config\Database::connect();
        
        // Get enrolled course IDs first
        $enrolledCourseIds = $db->table('enrollments')
                               ->select('course_id')
                               ->where('user_id', $user_id)
                               ->get()
                               ->getResultArray();
        
        // Extract just the IDs
        $enrolledIds = array_column($enrolledCourseIds, 'course_id');
        
        // Get courses not in the enrolled list
        $builder = $db->table('courses')->select('courses.*');
        
        if (!empty($enrolledIds)) {
            $builder->whereNotIn('courses.id', $enrolledIds);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get enrollment count for a specific course
     * @param int $course_id
     * @return int
     */
    public function getCourseEnrollmentCount($course_id)
    {
        return $this->where('course_id', $course_id)->countAllResults();
    }

    /**
     * Get total enrollment count for all courses
     * @return int
     */
    public function getTotalEnrollments()
    {
        return $this->countAll();
    }
}
