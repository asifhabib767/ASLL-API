<?php

namespace Modules\PSD\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\PSD\Entities\ComplaintProblemType;

class ProblemTypeSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = [
            [ 'strProblemTypeName'=> 'Slow Setting', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Cement Color', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Greening (Green/Blue)', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Lumps/Stone Cement', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Concrete/Plaster Crack', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Plaster Griping', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Whitish Layer', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Honeycomb', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Strength Variation', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Porous Concrete', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()],
            [ 'strProblemTypeName'=> 'Brittle Concrete', 'intCreatedBy'=> 439590, 'dteCreatedAt'=> Carbon::now()]
        ];
        
        ComplaintProblemType::insert($data);
    }
}
