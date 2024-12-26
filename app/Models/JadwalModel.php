<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwalkuliah';
    protected $primaryKey = 'id_pengampu';
    protected $allowedFields = ['id_pengampu', 'id_hari', 'id_jam', 'id_ruang'];
}