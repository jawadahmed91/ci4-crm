<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('admin123', PASSWORD_DEFAULT);

        $data = [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => $password,
        ];

        $this->db->table('users')->insert($data);
    }
}