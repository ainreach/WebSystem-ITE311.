<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInstructorIdToCourses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'instructor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'description'
            ]
        ]);
        
        // Add foreign key constraint
        $this->forge->addForeignKey('instructor_id', 'users', 'id', 'SET NULL', 'CASCADE', 'courses');
    }

    public function down()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('courses', 'courses_instructor_id_foreign');
        
        // Drop column
        $this->forge->dropColumn('courses', 'instructor_id');
    }
}
