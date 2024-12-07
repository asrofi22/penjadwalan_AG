<?php

namespace App\Models;

use CodeIgniter\Model;

class JamModel extends Model
{
    protected $table = 'jam2';
    protected $primaryKey = 'id';

    protected $allowedFields = ['range_jam', 'sks', 'sesi', 'id_jam'];

    // Optional: Tambahkan rules validasi jika diperlukan
    protected $validationRules = [
        'range_jam' => 'required|max_length[50]',
        'sks'       => 'required|integer',
        'sesi'      => 'required|integer',
        'id_jam'    => 'required|max_length[5]',
    ];
}
