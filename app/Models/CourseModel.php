<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'instructor_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';

    /**
     * Get all courses
     * @return array
     */
    public function getAllCourses()
    {
        $this->select('courses.*, users.name as instructor_name');
        $this->join('users', 'users.id = courses.instructor_id', 'left');
        return $this->findAll();
    }

    /**
     * Get course by ID
     * @param int $id
     * @return array|null
     */
    public function getCourseById($id)
    {
        return $this->find($id);
    }

    /**
     * Get courses by instructor
     * @param int $instructor_id
     * @return array
     */
    public function getCoursesByInstructor($instructor_id)
    {
        return $this->where('instructor_id', $instructor_id)->findAll();
    }

    /**
     * Get total course count
     * @return int
     */
    public function getTotalCourses()
    {
        return $this->countAll();
    }
}
