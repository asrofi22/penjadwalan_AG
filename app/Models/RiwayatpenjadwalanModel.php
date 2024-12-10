<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatpenjadwalanModel extends Model
{
    protected $table = 'prodi';
    protected $primaryKey = 'id';

    protected $allowedFields = ['prodi', 'id_prodi'];
}
