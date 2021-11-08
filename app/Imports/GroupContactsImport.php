<?php

namespace App\Imports;

use App\Helpers\NumbersHelper;
use App\Models\GroupContact;
use App\Repositories\GroupRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GroupContactsImport implements ToCollection
{
    public $group_id;

    public function __construct($group_id = null)
    {
        $this->group_id = $group_id;
    }

    public function collection(Collection $rows)
    {
        // $numbers = '';
        // foreach ($rows as $row) {
        //     $numbers .= $row[0] . ',';
        // }

        // $groupRepository = new GroupRepository();
        // $numbers_data = NumbersHelper::generateArraysFromNumbers($numbers);
        // $invalid_numbers = $numbers_data['count_invalid_numbers'];
        // $numbers = $numbers_data['numbers'];
        // $inserted_data = $groupRepository->insertMultipleNumberData($numbers, $this->group_id);
        // $duplicate_numbers = $inserted_data['duplicate_numbers'];
        // $total_inserted_numbers = $inserted_data['total'];

        // $data = [
        //         [
        //             'total_number' => $total_inserted_numbers,
        //             'invalid_numbers' => $invalid_numbers,
        //             'duplicate_numbers' => $duplicate_numbers,
        //             'group' => null,
        //         ]
        // ];
        // return $data;
    }
}
