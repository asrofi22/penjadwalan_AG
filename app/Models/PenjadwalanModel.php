<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjadwalanModel extends Model
{
    protected $table        ='riwayat_penjadwalan';
    protected $primaryKey   = 'id';
    protected $allowedFields = ['id_pengampu', 'id_hari', 'id_jam', 'kode_ruang'];

}