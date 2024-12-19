<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunakademikModel extends Model
{
    protected $table      = 'tahun_akademik';
    protected $primaryKey = 'id'; // Asumsikan 'id' adalah primary key.  Ubah jika berbeda.
    protected $allowedFields = ['tahun'];


    public function cek_tahun(string $tahun): bool
    {
        $builder = $this->db->table($this->table);
        $builder->where('tahun', $tahun);
        return $builder->countAllResults() > 0; // Lebih efisien daripada query terpisah
    }

    public function detail_tahun(int $id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id', $id); // Menggunakan 'id' untuk detail
        return $builder->get()->getRow(); // Gunakan getRow() untuk satu baris
    }

    public function edit_tahun(int $id, string $tahun): bool
    {
        $data = ['tahun' => $tahun];
        return $this->update($id, $data); // Gunakan update() bawaan
    }

    public function hapus_tahun(int $id): bool
    {
        return $this->delete($id); // Gunakan delete() bawaan
    }

    public function semua_tahun(): array
    {
        return $this->orderBy('id', 'asc')->findAll(); // Gunakan findAll() dan orderBy()
    }

    public function tahun_awal(int $id)
    {
        return $this->find($id); // Gunakan find() jika 'id' adalah primary key
    }

    public function simpan_tahun(string $tahun): bool
    {
        $data = ['tahun' => $tahun];
        return $this->insert($data); // Gunakan insert() bawaan
    }
}