<?php
namespace App\Controllers;

// Panggil JWT
use Config\Services;
use \Firebase\JWT\JWT;
// panggil class Auht
use App\Controllers\Auth;
// panggil restful api codeigniter 4
use CodeIgniter\RESTful\ResourceController;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class Web extends ResourceController
{

    public function __construct()
    {
        // inisialisasi class Auth dengan $this->protect
        $this->protect = new Auth();
    }

    public function index()
    {
        try{
            // ambil dari controller auth function public private key
//            $secret_key = $this->protect->privateKey();
            $secret_key        = Services::getSecretKey();
            $token = null;

            $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');

            $arr = explode(" ", $authHeader);

            $token = $arr[1];

            if ($token) {

                try {

                    $decoded = JWT::decode($token, $secret_key, array('HS256'));

                    // Access is granted. Add code of the operation here
                    if ($decoded) {
                        // response true
                        $output = [
                            'message' => 'Access granted'
                        ];
                        return $this->respond($output, 200);
                    }


                } catch (\Exception $e) {

                    $output = [
                        'message' => 'Access denied',
                        "error" => 'Token Salah '.$e->getMessage()
                    ];

                    return $this->respond($output, 401);
                }
            }
        } catch (\Exception $e) {

            $output = [
                'message' => 'Access denied',
                "error" => 'Token Belum di isi '.$e->getMessage()
            ];

            return $this->respond($output, 401);
        }
    }

}
