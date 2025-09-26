<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsersTableRoles extends Migration
{
    public function up()
    {
        // Alter the role column to include instructor and student
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'instructor', 'student'],
                'default'    => 'student',
            ],
        ]);
    }

    public function down()
    {
        // Revert back to original role structure
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default'    => 'user',
            ],
        ]);
    }
}
