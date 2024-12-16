<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunakademikModel extends Model
{
    protected $table = 'tahun_akademik';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun'];

    public function tahun_awal($id){
		$query = $this->db->query("SELECT * FROM tahun_akademik WHERE kode='$id' ");
		return $query->getResult();
	
	}
}
