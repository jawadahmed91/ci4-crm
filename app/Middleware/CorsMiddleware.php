<?php
namespace App\Middleware;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CorsMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Handle OPTIONS request (CORS preflight)
        if ($request->getMethod() === 'options') {
            return $this->setResponse(response());
        }

        // Set headers for every request
        return $this->setResponse();
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $this->setResponse($response);
    }

    private function setResponse($response = null)
    {
        $allowedOrigin = 'http://localhost:5173'; // Vue dev server

        $response = $response ?? response();

        return $response
            ->setHeader('Access-Control-Allow-Origin', $allowedOrigin)
            ->setHeader('Access-Control-Allow-Credentials', 'true')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
    }
}
