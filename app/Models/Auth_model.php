<?php

namespace App\Models;

use CodeIgniter\Model;

class Auth_model extends Model{

    protected $table = "users";

    public function register($data)
    {
        $cek = $this->table($this->table)
            ->where('email', $data['email'])->orWhere('username', $data['username'])
            ->countAllResults();
        if ($cek > 0){
            return false;
        }else{
            $query = $this->db->table($this->table)->insert($data);
            return $query ? true : false;
        }
    }

    public function cek_login($username)
    {
        $query = $this->table($this->table)
            ->where('email', $username)->orWhere('username', $username)
            ->countAll();

        if($query >  0){
            $hasil = $this->table($this->table)
                ->where('email', $username)
                ->orWhere('username', $username)
                ->limit(1)
                ->get()
                ->getRowArray();
        } else {
            $hasil = array();
        }
        return $hasil;
    }
}
