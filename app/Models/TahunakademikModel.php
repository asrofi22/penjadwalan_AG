<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunakademikModel extends Model
{
    protected $table = 'tahun_akademik';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun'];
}
