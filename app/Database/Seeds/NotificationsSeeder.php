<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotificationsSeeder extends Seeder
{
    public function run()
    {
        // Get student user ID (assuming student email is reach@gmail.com)
        $student = $this->db->table('users')->where('email', 'reach@gmail.com')->get()->getRowArray();
        
        if (!$student) {
            echo "Student user not found. Please run UsersSeeder first.\n";
            return;
        }

        $data = [
            [
                'user_id' => $student['id'],
                'type' => 'enrollment',
                'message' => 'Welcome! You have successfully enrolled in "Introduction to Web Development"',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
            [
                'user_id' => $student['id'],
                'type' => 'material',
                'message' => 'New material "Lecture 1 - HTML Basics.pdf" uploaded for "Introduction to Web Development"',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ],
            [
                'user_id' => $student['id'],
                'type' => 'material',
                'message' => 'New material "Lab Exercise 1.pptx" uploaded for "Database Management Systems"',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
            ],
        ];

        $this->db->table('notifications')->insertBatch($data);
        echo "Sample notifications created successfully!\n";
    }
}
