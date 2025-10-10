<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixRoleEnumConstraint extends Migration
{
    public function up()
    {
        // Drop the existing ENUM constraint and recreate with correct values
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'teacher', 'student') DEFAULT 'student'");
    }

    public function down()
    {
        // Revert back to instructor
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'instructor', 'student') DEFAULT 'student'");
    }
}
