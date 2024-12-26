<?php

namespace App\Models;

use CodeIgniter\Model;

class WaktuModel extends Model
{
    protected $table = 'waktu'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key tabel, jika berbeda sesuaikan
    protected $useAutoIncrement = true; // Jika primary key auto-increment
    protected $returnType = 'array'; // Mengatur tipe data yang dikembalikan (array atau object)

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields = [
        'id',
        'id_hari',
        'id_jam'
    ];


}
