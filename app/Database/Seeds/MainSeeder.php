<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('CustomerSeeder');
        $this->call('SalesTeamSeeder');
        $this->call('SupplierSeeder');
    }

    // php spark db:seed MainSeeder
}