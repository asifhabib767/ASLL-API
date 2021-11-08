<?php

namespace Modules\Asll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Asll\Entities\CargoType;

class CargoTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        $data =
            [
                [
                    'intUnitId' => 17,
                    'strCargoTypeName' => 'Container Cargo'
                ],
                [
                    'intUnitId' => 17,
                    'strCargoTypeName' => 'Liquid Bulk'
                ],
                [
                    'intUnitId' => 17,
                    'strCargoTypeName' => 'Ro-ro'
                ]
            ];

        CargoType::unguard();
        CargoType::insert($data);
        CargoType::reguard();
    }
}
