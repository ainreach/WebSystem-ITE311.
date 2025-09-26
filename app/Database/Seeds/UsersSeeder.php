<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Ain',
                'email'      => 'Ainreach@gmail.com',
                'password'   => password_hash('ayenreach12062004', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'name'       => 'Yen',
                'email'      => 'ayenreach@gmail.com',
                'password'   => password_hash('2311600074', PASSWORD_DEFAULT),
                'role'       => 'instructor', // Changed from 'teacher' to 'instructor'
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'name'       => 'yen reach',
                'email'      => 'reach@gmail.com',
                'password'   => password_hash('885270', PASSWORD_DEFAULT),
                'role'       => 'student',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];

        // Check if users already exist before inserting
        foreach ($data as $userData) {
            $existingUser = $this->db->table('users')
                ->where('email', $userData['email'])
                ->get()
                ->getRowArray();

            if (!$existingUser) {
                $this->db->table('users')->insert($userData);
                echo "Created user: {$userData['name']} ({$userData['role']}) - {$userData['email']}\n";
            } else {
                // Update existing user's role if it's different
                $this->db->table('users')
                    ->where('email', $userData['email'])
                    ->update([
                        'role' => $userData['role'],
                        'updated_at' => $userData['updated_at']
                    ]);
                echo "Updated user: {$userData['name']} ({$userData['role']}) - {$userData['email']}\n";
            }
        }

        echo "\nYour users have been created successfully!\n";
        echo "Login credentials:\n";
        echo "Admin: Ainreach@gmail.com / ayenreach12062004\n";
        echo "Instructor: ayenreach@gmail.com / 2311600074\n";
        echo "Student: reach@gmail.com / 115270\n";
    }
}