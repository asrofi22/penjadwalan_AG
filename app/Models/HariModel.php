<?php

namespace App\Models;

use CodeIgniter\Model;

class HariModel extends Model
{
    protected $table = 'hari';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'id_hari'];

    // Method untuk mengambil semua data hari
    public function get()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }
}
