<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $allowedFields = ['course_id', 'file_name', 'file_path', 'created_at'];
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    public function insertMaterial(array $data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        return $this->insert($data);
    }

    public function getMaterialsByCourse(int $course_id): array
    {
        return $this->where('course_id', $course_id)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getById(int $id)
    {
        return $this->where('id', $id)->first();
    }

    public function deleteMaterial(int $id): bool
    {
        return (bool) $this->delete($id);
    }
}
