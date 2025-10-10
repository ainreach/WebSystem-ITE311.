<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateInstructorToTeacher extends Migration
{
    public function up()
    {
        // Update existing 'instructor' roles to 'teacher'
        $this->db->table('users')
            ->where('role', 'instructor')
            ->update(['role' => 'teacher']);
    }

    public function down()
    {
        // Revert 'teacher' roles back to 'instructor'
        $this->db->table('users')
            ->where('role', 'teacher')
            ->update(['role' => 'instructor']);
    }
}
