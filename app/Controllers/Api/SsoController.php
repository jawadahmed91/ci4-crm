<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;

class SsoController extends BaseController
{
/**
 * Generates a JWT token if the user is logged in via session.
 *
 * @return ResponseInterface
 */
    public function getToken(): ResponseInterface
    {
        // // Method 1: Using Request URI (Recommended)
        // $baseUrl = $this->request->getUri()->getBaseURL();
        // $domain  = $this->request->getUri()->getHost();
        // $port    = $this->request->getUri()->getPort();
        // $scheme  = $this->request->getUri()->getScheme();

        // // Method 2: Using helpers
        // $baseUrlHelper    = base_url();
        // $domainFromHelper = parse_url(base_url(), PHP_URL_HOST);

        // // Method 3: Server variables
        // $httpHost   = $_SERVER['HTTP_HOST'] ?? '';
        // $serverName = $_SERVER['SERVER_NAME'] ?? '';

        // return $this->response->setJSON([
        //     'base_url'           => $baseUrl,
        //     'domain'             => $domain,
        //     'port'               => $port,
        //     'scheme'             => $scheme,
        //     'base_url_helper'    => $baseUrlHelper,
        //     'domain_from_helper' => $domainFromHelper,
        //     'http_host'          => $httpHost,
        //     'server_name'        => $serverName,
        //     'full_url'           => $scheme . '://' . $domain . ($port ? ':' . $port : ''),
        // ]);
        // Get CI4 session instance
        $session = session();

        // Check if user is logged in
        if (! $session->has('logged_user')) {
            return $this->response->setJSON([
                'error'     => 'Not logged in',
                'logged_in' => false,
            ])->setStatusCode(401);
        }

        // Get user data from session
        $user = $session->get('logged_user');

                                     // Prepare JWT payload
        $key = getenv('JWT_SECRET'); // Make sure this is set in .env
        if (! $key) {
            return $this->response->setJSON([
                'error' => 'Server misconfiguration: JWT_SECRET missing',
            ])->setStatusCode(500);
        }

        $payload = [
            'iss'  => 'ci4-crm',     // Issuer
            'exp'  => time() + 3600, // Token expires in 1 hour
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role ?? null, // Optional: include role if available
            ],
        ];

        // Generate JWT token
        try {
            $token = JWT::encode($payload, $key, 'HS256');
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error'   => 'Failed to generate token',
                'message' => $e->getMessage(),
            ])->setStatusCode(500);
        }

        // Return token as JSON
        return $this->response->setJSON([
            'token'     => $token,
            'user'      => $payload['user'],
            'logged_in' => true,
        ]);
    }
}
