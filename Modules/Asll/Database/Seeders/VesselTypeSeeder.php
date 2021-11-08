<?php

namespace Modules\Asll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Asll\Entities\VesselType;

class VesselTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
            [
                [
                    'intUnitId' => 17,
                    'strName' => 'Container Ships'
                ],
                [
                    'intUnitId' => 17,
                    'strName' => 'Bulk Carrier'
                ],
                [
                    'intUnitId' => 17,
                    'strName' => 'Tanker Ships'
                ],
                [
                    'intUnitId' => 17,
                    'strName' => 'Passenger Ships'
                ],
                [
                    'intUnitId' => 17,
                    'strName' => 'Naval Ships'
                ],
                [
                    'intUnitId' => 17,
                    'strName' => 'Offshore Ships'
                ],
                [
                    'intUnitId' => 17,
                    'strName' => 'Special Purpose Ships'
                ],
            ];

        VesselType::unguard();
        VesselType::insert($data);
        VesselType::reguard();
    }
}
