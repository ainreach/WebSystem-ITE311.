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
                'name'       => 'Admin Ain',
                'email'      => 'Ainreach@gmail.com',
                'password'   => password_hash('ayenreach12062004', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'name'       => 'Instructor Yen',
                'email'      => 'ayenreach@gmail.com',
                'password'   => password_hash('2311600074', PASSWORD_DEFAULT),
                'role'       => 'instructor',
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

        // Insert multiple users at once
        $this->db->table('users')->insertBatch($data);
    }
}