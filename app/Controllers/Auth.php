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
}