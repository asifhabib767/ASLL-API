<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\Base64Encoder;
use App\Helpers\UploadHelper;
use App\Imports\GroupContactsImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Excel;
use Modules\ASLLHR\Http\Requests\UploadRequest;
// use File;
use Image;
use Modules\ASLLHR\Entities\AsllEmployee;
use Modules\ASLLHR\Entities\SalaryBulkData;
// use Modules\StoreRequisition\Repositories\StoreRequisitionRepository;
use stdClass;

class AdditionDeductionFileUploadRepository
{

    // public $storeRequisitionRepository;

    // public function __construct(StoreRequisitionRepository $storeRequisitionRepository)
    // {
    //     $this->storeRequisitionRepository = $storeRequisitionRepository;
    // }

    /**
     * Purchase Requisition Bulk Import
     * 
     * QUERY: 
     *
     * @param Request $request
     * @return void
     */
    public function fileInput(UploadRequest $request)
    {
        
        try {
            ini_set("memory_limit", "500M");
            ini_set('max_execution_time', 2000);

            return $request;
            if ($request->uploadFile) {
                $file = $request->uploadFile;
                $requisitions = [];
                $extension = $file->getClientOriginalExtension();

                if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                    $data = Excel::toArray(new GroupContactsImport(), $request->uploadFile);
                    foreach ($data as $key => $value) {
                        $i = 1;
                        foreach ($value as $val) {
                            if ($i > 2) {
                                $requisitions[] = $val;
                            }
                            $i++;
                        }
                    }
                } else {
                    session()->flash('error', 'File is a ' . $extension . ' file.!! Please upload a valid xls/csv file..!!');
                    return back();
                }

                $i = 0;

                $insertedTypes = [];
                $vesselData=[];
                foreach ($requisitions as $requisition) {

                    // return $requisition;
                    if ($i == 0) {
                        $vesselData= $requisitions[5];
                        for ($j = 0; $j < 17; $j++) {
                            if (!is_null($requisition[$j])) {
                               
                                $additionDeductionType = DB::table(config('constants.DB_ASLL') . ".tblAdditionDeductionType")
                                    ->where('ysnActive', 1)
                                    ->where('strTypeName', $requisition[$j])
                                    ->first();
                                $vesselName=$vesselData[5];
                                $intVesselId = DB::table(config('constants.DB_ASLL') . ".tblVessel")
                                    ->where('strVesselName', $vesselName)
                                    ->first();

                                if (!is_null($additionDeductionType)) {
                                    $data = [
                                        [
                                            'intAdditionDeductionTypeId' => $additionDeductionType->intID,
                                            'strAdditionDeductionTypeName' => $additionDeductionType->strTypeName,
                                            'position' => $j,
                                        ]
                                    ];
                                    $insertedTypes[] =  $data[0];
                                }
                            }
                        }
                    }
                    $totalEntry = count($insertedTypes);
                    if ($i > 0) {
                        $salaryBulkData = new SalaryBulkData();
                        $salaryBulkData->strOfficerName = $requisition[2];
                        $salaryBulkData->strRank = $requisition[3];
                        $cdc =  $requisition[4];
                        $strCDCNo = str_replace("\\", "", $cdc);
                        $salaryBulkData->strCDCNo = $strCDCNo;
                        // $salaryBulkData->decWagesMonth = $requisition[3];
                        // $salaryBulkData->strRemarks = $requisition[4];
                        // $salaryBulkData->decEarningOfMonth = $requisition[5];
                        // $salaryBulkData->intPreviousBalance = $requisition[6];
                        $salaryBulkData->save();
                        $intRequestId = $salaryBulkData->intID;

                        // $intRequestId = DB::table(config('constants.DB_ASLL') . ".tblSalaryBulkData")->insertGetId(
                        //     [
                        //         'strOfficerName' => $requisition[0],
                        //         'strRank' => $requisition[1],
                        //         'strCDCNo' => $requisition[2],
                        //         'decWagesMonth' => (float) $requisition[3],
                        //         'strRemarks' => (int) $requisition[4],
                        //         'decEarningOfMonth' => (float) $requisition[5],
                        //         'intPreviousBalance' => (float) $requisition[6],
                        //         'decAddIEarning' => (float) $requisition[7],
                        //         'decTotalEarning' => (float) $requisition[8],
                        //         'decAdvanceonBoard' => (float) $requisition[9],
                        //         'decFbbCallingCard' => (float) $requisition[10],
                        //         'decBondedItems' => (float) $requisition[11],
                        //         'decJoiningAdvance' => (float) $requisition[12],
                        //         'decTotalDeduction' => (float) $requisition[13],
                        //         'decPayableAmount' => (float) $requisition[14],
                        //         'created_at' =>  Carbon::now(),
                        //         'updated_at' => Carbon::now(),
                        //     ]
                        // );
                        // return $strCDCNo;
                        $employeedata = AsllEmployee::getEmployeeByCDC(str_replace("\\", "", $strCDCNo));
                        if (!is_null($employeedata)) {
                            $decTotal = 0;
                            // $decTotal = (float) (is_null($requisition[7]) ? 0 : $requisition[7])
                            //     - (float) (is_null($requisition[7]) ? 0 : $requisition[7])
                            //     - (float) (is_null($requisition[9]) ? 0 : $requisition[9])
                            //     - (float) (is_null($requisition[10]) ? 0 : $requisition[10])
                            //     - (float) (is_null($requisition[11]) ? 0 : $requisition[11])
                            //     - (float) (is_null($requisition[12]) ? 0 : $requisition[12]);
                            for ($l = 0; $l < $totalEntry; $l++) {
                                $item = $insertedTypes[$l];
                                $position = $item['position'];
                                $decTotal += (float) (is_null($requisition[$position]) ? 0 : $requisition[$position]);
                            }


                            $intAdditionDeductionId = DB::table(config('constants.DB_ASLL') . ".tblAdditionDeduction")
                                ->insertGetId(
                                    [
                                        'intEmployeeId' => $employeedata->intID,
                                        'decTotal' => $decTotal,
                                        'currencyId' => 1,
                                        'strCurrencyName' => 'USD',
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ]
                                );
                            for ($k = 0; $k < $totalEntry; $k++) {
                                $item = $insertedTypes[$k];
                                $position = $item['position'];
                                $intAdditionDeductionTypeId = $item['intAdditionDeductionTypeId'];
                                $amount = (float) (is_null($requisition[$position]) ? 0 : $requisition[$position]);
                                if ($amount > 0) {
                                    DB::table(config('constants.DB_ASLL') . ".tblAdditionDeductionDetails")
                                        ->insert([
                                            [
                                                'intAdditionDeductionId' => $intAdditionDeductionId,
                                                'intAdditionDeductionTypeId' => $intAdditionDeductionTypeId,
                                                'strAdditionDeductionTypeName' => $item['strAdditionDeductionTypeName'],
                                                'amount' => $amount,
                                                'intEmployeeId' => $employeedata->intID,
                                                'intMonthId' => (int)$request->intMonthId,
                                                'intYear' => (int)$request->intYear,
                                                'intVesselId' => (int)$intVesselId->intID,
                                                'created_at' =>  Carbon::now(),
                                                'updated_at' =>  Carbon::now()
                                            ]
                                        ]);
                                }

                                if ($intAdditionDeductionTypeId == 1) {
                                    $salaryBulkData->decBondedItems = $amount;
                                } else if ($intAdditionDeductionTypeId == 2) {
                                    $salaryBulkData->decJoiningAdvance = $amount;
                                } else if ($intAdditionDeductionTypeId == 3) {
                                    $salaryBulkData->decAddIEarning = $amount;
                                } else if ($intAdditionDeductionTypeId == 4) {
                                    $salaryBulkData->decAdvanceonBoard = $amount;
                                } else if ($intAdditionDeductionTypeId == 5) {
                                    $salaryBulkData->decVSatCallingCard = $amount;
                                } else if ($intAdditionDeductionTypeId == 6) {
                                    $salaryBulkData->dechatchCleaning = $amount;
                                } else if ($intAdditionDeductionTypeId == 7) {
                                    $salaryBulkData->decEngineCleaning = $amount;
                                } else if ($intAdditionDeductionTypeId == 8) {
                                    $salaryBulkData->decSpecialAllowance = $amount;
                                } else if ($intAdditionDeductionTypeId == 9) {
                                    $salaryBulkData->decHRAAllowance = $amount;
                                } else if ($intAdditionDeductionTypeId == 10) {
                                    $salaryBulkData->decFbbCallingCard = $amount;
                                }
                                $salaryBulkData->save();
                            }
                        }
                    }
                    $i++;
                }
                return $intRequestId;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
