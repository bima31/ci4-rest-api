<?php namespace App\Controllers;

use Config\Services;
use \Firebase\JWT\JWT;
use App\Models\Auth_model;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    public $session;
    public function __construct()
    {
        $this->auth = new Auth_model();
        $this->session = session();
    }

//    public function privateKey()
//    {
//        $privateKey = <<<EOD
//            -----BEGIN RSA PRIVATE KEY-----
//            MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
//            vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
//            5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
//            AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
//            bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
//            Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
//            cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
//            5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
//            ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
//            k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
//            qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
//            eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
//            B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
//            -----END RSA PRIVATE KEY-----
//            EOD;
//        return $privateKey;
//    }

    public function register()
    {
        $nama  = $this->request->getPost('nama');
        $bidang   = $this->request->getPost('bidang');
        $username      = $this->request->getPost('username');
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');
        $status   = $this->request->getPost('status');

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $data = json_decode(file_get_contents("php://input"));

        $dataRegister = [
            'nama' => $nama,
            'bidang' => $bidang,
            'email' => $email,
            'username' => $username,
            'status' => $status,
            'password' => $password_hash
        ];

        $register = $this->auth->register($dataRegister);

        if($register == true){
            $output = [
                'status' => 200,
                'message' => 'Berhasil register'
            ];
            return $this->respond($output, 200);
        } else{
            $output = [
                'status' => 400,
                'message' => 'Gagal register, username atau email sudah terdaftar'
            ];
            return $this->respond($output, 400);
        }
    }

    public function login()
    {
        $username      = $this->request->getPost('username');
        $password   = $this->request->getPost('password');

        $cek_login = $this->auth->cek_login($username);

        // var_dump($cek_login['password']);

        if(password_verify($password, $cek_login['password']))
        {
//            $secret_key = $this->privateKey();
            $secret_key = Services::getSecretKey();
            $issuer_claim = "THE_CLAIM"; // this can be the servername. Example: https://domain.com
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 3600; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $cek_login['id'],
                    "nama" => $cek_login['nama'],
                    "bidang" => $cek_login['bidang'],
                    "email" => $cek_login['email'],
                    "status" => $cek_login['status']
                )
            );

            $this->session->set($token['data']);
            $token = JWT::encode($token, $secret_key);
            $output = [
                'status' => 200,
                'message' => 'Berhasil login',
                "token" => $token,
                "username" => $username,
                "expireAt" => $expire_claim
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 401,
                'message' => 'Login failed',
                "password" => $password
            ];
            return $this->respond($output, 401);
        }
    }

}
