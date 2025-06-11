<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function ssoLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('email', $email)->get()->getRow();

        if ($user && password_verify($password, $user->password)) {
            $key = getenv('JWT_SECRET'); // Make sure this is defined in .env
            $payload = array(
                "iss" => "ci4-crm", // issuer
                "exp" => time() + 3600, // expires in 1 hour
                "user" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "role" => $user->role ?? null // optional: role info
                ]
            );

            $token = JWT::encode($payload, $key, 'HS256');

            // Return JSON response instead of redirecting
            return $this->response->setJSON([
                'token' => $token,
                'user' => $user
            ]);

            // For Web 
            // return redirect()->to("http://laravel-chat-app.test/sso-login?token={$token}");
        } else {
            return $this->response->setJSON(['error', 'Invalid credentials']);

            // For Web 
            // return redirect()->to("http://laravel-chat-app.test/invalid");
        }
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('email', $email)->get()->getRow();

        // Generate RSA key
        if (!extension_loaded('openssl')) {
            throw new \Exception('OpenSSL extension is required');
        }

        // Generate private key
        $keySize = 2048;
        // Note: You need to install phpseclib via composer
        // composer require phpseclib/phpseclib
        
        if (!class_exists('\phpseclib3\Crypt\RSA')) {
            throw new \Exception('phpseclib is required. Install via: composer require phpseclib/phpseclib');
        }
        
        $rsa = \phpseclib3\Crypt\RSA::createKey($keySize);
        $privateKey = $rsa->toString('PKCS1');
        $publicKey = $rsa->getPublicKey()->toString('PKCS1');
        
        // $db->table('oauth_public_keys')->insert([
        //     'client_id' => 'user_'.$user->id,
        //     'public_key' => $publicKey,
        //     'private_key' => $privateKey, // encrypt is CI helper or use custom
        //     'encryption_algorithm' => 'RS256',
        // ]);
            
        $keyRow = $db->table('oauth_public_keys')->where('client_id', 'user_'.$user->id)->get()->getRow();
        $privateKey = $keyRow->private_key; // CI helper

        $header = [
        "alg"=> "RS256",
        "typ"=> "JWT"
        ];
        $payload = [
            'user_id' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (15 * 60),
            'jti' => bin2hex(random_bytes(16)),
        ];

        $accessToken = JWT::encode($payload, $privateKey, 'RS256');
        echo $accessToken;
        return;
       
        $refreshToken = bin2hex(random_bytes(64));
        $db->table('oauth_refresh_tokens')->insert([
            'refresh_token' => $refreshToken,
            'user_id' => $user->id,
            'expires' => date('Y-m-d H:i:s', strtotime('+7 days')),
            'scope' => 'chat:read chat:write',
        ]);

        if ($user && password_verify($password, $user->password)) {
            session()->set('logged_user', $user);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        session()->remove('logged_user');
        return redirect()->to('/login');
    }

    public function publicKey($userId)
    {
        $db = \Config\Database::connect();
        $key = $db->table('oauth_public_keys')->where('client_id', 'user_'.$userId)->get()->getRow();

        if (!$key) {
            return $this->failNotFound('No public key');
        }

        return $this->response->setJSON([
            'user_id' => $userId,
            'public_key' => $key->public_key,
            'algorithm' => $key->encryption_algorithm,
        ]);
    }
}