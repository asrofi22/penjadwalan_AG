<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunakademikModel extends Model
{
    protected $table = 'tahun_akademik';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun'];

    public function semua_tahun(){
		$query = $this->db->query("SELECT * FROM tahun_akademik order by kode asc");
		return $query->getResult();
    }
}
