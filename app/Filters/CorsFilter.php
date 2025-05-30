<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CorsFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Define allowed origins
        $allowedOrigins = [
            'http://localhost:8081', // Your Vue.js app
            'http://localhost:3000', // If you use different ports
            'http://127.0.0.1:8081',
            'https://yourdomain.com', // Production domain
        ];

        $origin = $request->getHeaderLine('Origin');

        $response = service('response');

        // Check if origin is allowed
        if (in_array($origin, $allowedOrigins)) {
            $response->setHeader('Access-Control-Allow-Origin', $origin);
        }

        // Set CORS headers
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');
        $response->setHeader('Access-Control-Max-Age', '86400'); // 24 hours

        // Handle preflight OPTIONS request
        if ($request->getMethod() === 'OPTIONS') {
            return $response->setStatusCode(200);
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
}
