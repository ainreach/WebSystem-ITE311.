<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CoursesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'       => 'Introduction to Web Development',
                'description' => 'Learn the basics of HTML, CSS, and JavaScript to build modern web applications.',
                'instructor_id' => 2, // Teacher user ID
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'title'       => 'Database Management Systems',
                'description' => 'Comprehensive course covering SQL, database design, and management principles.',
                'instructor_id' => 2, // Teacher user ID
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'title'       => 'Object-Oriented Programming',
                'description' => 'Master OOP concepts using PHP and modern programming practices.',
                'instructor_id' => 2, // Teacher user ID
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'title'       => 'Mobile App Development',
                'description' => 'Build native and cross-platform mobile applications using modern frameworks.',
                'instructor_id' => 2, // Teacher user ID
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'title'       => 'Data Structures and Algorithms',
                'description' => 'Essential computer science concepts for efficient problem solving.',
                'instructor_id' => 2, // Teacher user ID
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];

        // Update existing courses with instructor_id
        foreach ($data as $courseData) {
            $existingCourse = $this->db->table('courses')
                ->where('title', $courseData['title'])
                ->get()
                ->getRowArray();

            if ($existingCourse) {
                // Update existing course with instructor_id
                $this->db->table('courses')
                    ->where('id', $existingCourse['id'])
                    ->update([
                        'instructor_id' => $courseData['instructor_id'],
                        'updated_at' => $courseData['updated_at']
                    ]);
                echo "Updated course: {$courseData['title']} with instructor_id\n";
            } else {
                // Insert new course
                $this->db->table('courses')->insert($courseData);
                echo "Created course: {$courseData['title']}\n";
            }
        }

        echo "\nCourses have been seeded successfully!\n";
    }
}
