<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;
use phpDocumentor\Reflection\Types\Null_;

class AuthFilter implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arg = null)
    {
        $key        = Services::getSecretKey();
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');
        $arr        = explode(' ', $authHeader);
//        print_r($arr);
        $token      = $arr[1];

        try
        {
//            JWT::decode($token, $key, ['HS256']);
            $jwt = JWT::decode($token, $key, ['HS256']);
//            print_r($jwt);
        }
        catch (\Exception $e)
        {
            return Services::response()
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arg = null)
    {
        // Do something here
    }
}
