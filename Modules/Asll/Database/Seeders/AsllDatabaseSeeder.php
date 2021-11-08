<?php

namespace Modules\Asll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AsllDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(CargoTypeSeeder::class);
        $this->call(VesselTypeSeeder::class);
    }
}
