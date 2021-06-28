<?php

namespace App\Models;

use CodeIgniter\Model;

class Relasi_model extends Model{

    protected $table = "relasi_monitoring_user";

    public function cek_id($id,$id2)
    {
        $cek = $this->table($this->table)
            ->where('id_monitoring', $id)
            ->where('id', $id2)
            ->get();
        if ($cek){
            return $cek->getResult();
        }else{
            return false;
        }
    }
    public function simpan($data)
    {
        $cek = $this->table($this->table)
            ->where('id_monitoring', $data['id_monitoring'])
            ->where('id', $data['id'])
            ->countAllResults();
        if ($cek > 0){
            return false;
        }else{
            $query = $this->db->table($this->table)->insert($data);
            return $query ? true : false;
        }
    }

}

