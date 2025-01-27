<?php
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table      = 'users'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key tabel

    protected $allowedFields = ['email', 'username', 'password_hash', 'user_image']; 

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';
}