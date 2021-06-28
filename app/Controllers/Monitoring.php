<?php

namespace App\Controllers;

use App\Models\Monitoring_model;
use App\Models\Relasi_model;
use CodeIgniter\RESTful\ResourceController;

class Monitoring extends ResourceController
{
    /**
     * @var \CodeIgniter\Session\Session|null
     */
    public function __construct()
    {
        $this->session = session();
        $this->model = new Monitoring_model();
        $this->modelrelasi = new Relasi_model();
    }
    public function index()
    {
        $getMonitoring = $this->model->getMonitoring();
        $getAll = $this->model->getData();
        $mountData = [];
        $j = 0;
        foreach ($getMonitoring as $val){
            $mountData[$j]['id_monitoring'] = $val['id_monitoring'];
            $mountData[$j]['tgl_masuk_doc'] = $val['tgl_masuk_doc'];
            $mountData[$j]['nm_perusahaan'] = $val['nm_perusahaan'];
            $mountData[$j]['no_tagihan'] = $val['no_tagihan'];
            $mountData[$j]['nominal'] = $val['nominal'];
            $i = 0;
            $mountData1 = [];
            foreach ($getAll as $item){
                if ($val['id_monitoring'] == $item['id_monitoring']){
                    $mountData1[$i]['id_monitoring'] = $item['id_monitoring'];
                    $mountData1[$i]['username'] = $item['username'];
                    $mountData1[$i]['nama'] = $item['nama'];
                    $mountData1[$i]['bidang'] = $item['bidang'];
                    $mountData1[$i]['tgl_submit'] = $item['tgl_submit'];
                }
                $i++;
            }
            $mountData[$j]['data'] = $mountData1;
            $j++;
        }
        return $this->respond($mountData, 200);
//        return $this->respond(array($getMonitoring, $getAll), 200);
    }
    public function simpan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $sesi = $_SESSION;

        $tgl_masuk_doc  = $this->request->getPost('tgl_masuk');
        $nm_perusahaan   = $this->request->getPost('nama');
        $no_tagihan      = $this->request->getPost('no_tagihan');
        $nominal      = $this->request->getPost('nominal');

        $id_mon = str_replace('-','',date('Y-m-d', $tgl_masuk_doc));
        $cekid = $this->model->cek_id($id_mon);
        if ($cekid){
            $idMonitoring = intval($cekid)+1;
        }else{
            $idMonitoring = $id_mon.'01';
        }
        $dataSimpan = [
            'id_monitoring' => $idMonitoring,
            'tgl_masuk_doc' => date('Y-m-d H:i:s ', $tgl_masuk_doc),
            'nm_perusahaan' => $nm_perusahaan,
            'no_tagihan' => $no_tagihan,
            'nominal' => $nominal,
            'sts_data' => 1
        ];

        $dataSimpanRelasi = [
            'id' =>  $sesi['id'],
            'status_id' => $sesi['status'] == 1? 'admin': 'guest',
            'id_monitoring' => $idMonitoring,
            'tgl_submit' => date('Y-m-d H:i:s', $tgl_masuk_doc)
        ];

        $simpanData = $this->model->simpan($dataSimpan);
        $simpanDataRelasi = $this->modelrelasi->simpan($dataSimpanRelasi);

        if($simpanData == true && $simpanDataRelasi == true){
            $output = [
                'status' => 200,
                'message' => 'Berhasil Simpan Data'
            ];
            return $this->respond($output, 200);
        } else{
            $output = [
                'status' => 400,
                'message' => 'Gagal Simpan Data'
            ];
            return $this->respond($output, 400);
        }
    }

    public function simpan_guest(){
        date_default_timezone_set('Asia/Jakarta');
        $sesi = $_SESSION;
        $id_monitoring = $this->request->getPost('id_monitoring');
        $dataSimpan = [
            'id' =>  $sesi['id'],
            'status_id' => $sesi['status'] == 1? 'admin': 'guest',
            'id_monitoring' => $id_monitoring,
            'tgl_submit' => date('Y-m-d H:i:s')
        ];
        $cekid = $this->modelrelasi->cek_id($id_monitoring, $sesi['id']);
        if ($cekid){
            $output = [
                'status' => 400,
                'message' => 'Data Sudah Ada'
            ];
            return $this->respond($output, 400);
        }else{
             $this->model->set_sts($id_monitoring);
            $simpanDataRelasi = $this->modelrelasi->simpan($dataSimpan);
            if ($simpanDataRelasi){
                $output = [
                    'status' => 200,
                    'message' => 'Berhasil Simpan Data'
                ];
                return $this->respond($output, 200);
            }else{
                $output = [
                    'status' => 400,
                    'message' => 'Gagal Simpan Data'
                ];
                return $this->respond($output, 400);
            }
        }

    }
}
