<?php

namespace Modules\ASLLHR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ASLLHRDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('constants.DB_ASLL') . ".tblAdditionDeductionType")->insert(
            [
                'strTypeName' => "Add'I Earning",
                'ysnAddition' => true,
                'intUnitId' => 17,
            ],
        );
    }
}
