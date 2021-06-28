<?php

namespace App\Models;

use CodeIgniter\Model;

class Monitoring_model extends Model{

    protected $table = "monitoring";

    public function cek_id($id)
    {
        $cek = $this->table($this->table)
            ->like('id_monitoring', $id, 'both')
            ->orderBy('id_monitoring','desc')
            ->limit(1)
            ->get();
        foreach ($cek->getResult() as $var){
            if ($var){
                return $var->id_monitoring;
            }else{
                return false;
            }
        }
    }
    public function simpan($data)
    {
        $cek = $this->table($this->table)
            ->where('id_monitoring', $data['id_monitoring'])
            ->countAllResults();
        if ($cek > 0){
            return false;
        }else{
            $query = $this->db->table($this->table)->insert($data);
            return $query ? true : false;
        }
    }
    public function set_sts($id)
    {
        $cek = $this->table($this->table)
            ->where('id_monitoring', $id)
            ->get();
        foreach ($cek->getResult() as $var){
            if ($var){
                $query = $this->db->table($this->table)->update(['sts_data' => $var->sts_data+1], ['id_monitoring' => $id]);
                return $query ? true : false;
            }else{
                return false;
            }
        }
    }
    public function getData(){
        $result =  $this->table('monitoring')
        ->join('relasi_monitoring_user', 'monitoring.id_monitoring = relasi_monitoring_user.id_monitoring', 'LEFT')
        ->join('users', 'users.id = relasi_monitoring_user.id', 'LEFT')
        ->select('monitoring.*')
        ->select('users.*')
        ->select('relasi_monitoring_user.*')
        ->orderBy('monitoring.id_monitoring', 'desc')->findAll();

        return $result;
    }
    public function getMonitoring(){
        $result = $this->table($this->table)->orderBy('id_monitoring','desc')->findAll();
        return $result;
    }
}
