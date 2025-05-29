<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SalesTeamSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'phone' => '1112223333',
            ],
            [
                'name' => 'Bob Martin',
                'email' => 'bob@example.com',
                'phone' => '4445556666',
            ]
        ];

        $this->db->table('sales_team')->insertBatch($data);
    }
}