<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'ABC Supplies',
                'contact_person' => 'Mark Lee',
                'phone' => '7778889999',
                'email' => 'mark@abcsupplies.com',
                'address' => '123 Main St, City'
            ],
            [
                'name' => 'XYZ Distributors',
                'contact_person' => 'Sara Kim',
                'phone' => '6665554444',
                'email' => 'sara@xyzdist.com',
                'address' => '456 Oak Rd, Town'
            ]
        ];

        $this->db->table('suppliers')->insertBatch($data);
    }
}