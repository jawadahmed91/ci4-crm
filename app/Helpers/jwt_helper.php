<?php
use \Firebase\JWT\JWT;

function generate_sso_jwt($user)
{
    $key = env('JWT_SECRET'); // same as Laravel's .env SSO_JWT_SECRET
    $payload = [
        'iss' => 'CI App',
        'sub' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'],
        'iat' => time(),
        'exp' => time() + (60 * 60) // 1 hour
    ];

    return JWT::encode($payload, $key, 'HS256');
}
