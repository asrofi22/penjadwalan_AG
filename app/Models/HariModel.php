<?php

namespace App\Models;

use CodeIgniter\Model;

class HariModel extends Model
{
    protected $table = 'hari';
    protected $primaryKey = 'id';
    protected $allowedFields = ['hari', 'id_hari'];
}
