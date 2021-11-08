<?php

namespace Modules\ASLLHR\Repositories;

// use App\Helpers\ImageUploadHelper;

use App\Helpers\Base64Encoder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\ASLLHR\Entities\AdditionDeductionDetails;
use Modules\ASLLHR\Entities\EmployeeSignInOut;
use Modules\ASLLHR\Entities\OpeningClosingAccount;
use Modules\ASLLHR\Entities\TransactionType;
use Modules\ASLLHR\Entities\VesselAccount;

class ASLLHRAdditionDeductionRepository
{

    public function additionDeductionListByEmployee($intEmployeeId)
    {
        try {
            $additionDeductionList = DB::table(config('constants.DB_ASLL') . ".tblAdditionDeductionDetails")
                ->leftjoin(config('constants.DB_ASLL') . ".tblASLLEmployee", 'tblAdditionDeductionDetails.intEmployeeId', 'tblASLLEmployee.intID')
                ->select(
                    'tblAdditionDeductionDetails.intID',
                    'intAdditionDeductionId',
                    'intAdditionDeductionTypeId',
                    'strAdditionDeductionTypeName',
                    'amount',
                    'tblAdditionDeductionDetails.updated_at',
                    'tblAdditionDeductionDetails.created_at',
                    'tblASLLEmployee.strName'
                )
                ->where('intEmployeeId', $intEmployeeId)
                ->orderBy('intID', 'desc')
                ->get();
            return $additionDeductionList;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * get transaction type list for addition deduction
     */

    public function getTransactionType()
    {
        try {
            $transactionType = TransactionType::orderBy('intID','asc')->get();
            return $transactionType;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function createAdditionDeduction($request)
    {
        $employeeRepository = new ASLLHREmployeeRepository();
        // Add Single Entry in tblStoreIssue table
        // and multiple in tblStoreIssueByItem
        // return $request['intVesselId'];
        if (count($request) == 0) {
            return "No Item Given";
        }

        $vesselId = null;
        if (!is_null($request['intVesselId'])) {
            $vesselId = $request['intVesselId'];
        }

        try {
            DB::beginTransaction();
            $intAdditionDeductionId = null;

            $intAdditionDeductionId = DB::table(config('constants.DB_ASLL') . ".tblAdditionDeduction")->insertGetId(
                [
                    'intEmployeeId' => $request['intEmployeeId'],
                    'decTotal' => $request['decTotal'],
                    'currencyId' => $request['currencyId'],
                    'strCurrencyName' => $request['strCurrencyName'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
            $employeeLastVesselData = null;
            if (is_null($vesselId)) {
                $employeeLastVesselData = $employeeRepository->getLastVesselIdByEmployeeId($request['intEmployeeId']);
                $vesselId = !is_null($employeeLastVesselData) ? $employeeLastVesselData->intVesselId : null;
            }

            if (is_null($vesselId)) {
                throw new Exception('Sorry, No Vessel Found For this employee');
            } else {
                $vesselAccountData = VesselAccount::where('intVesselId', $vesselId)->first();
                $intRequestId = null;
                $bondPreviousBalance = $vesselAccountData->decBondAccountBalance;
                $cashPreviousBalance = $vesselAccountData->decCashAccountBalance;
                $bondDeductionAmount = 0;
                $cashDeductionAmount = 0;

                $vesselData = null;

                if (is_null($request['intVesselId'])) {
                    $vesselData = EmployeeSignInOut::orderBy('intID', 'desc')
                        ->where('intEmployeeId', $request['intEmployeeId'])
                        ->first();
                }

                if (!is_null($vesselData)) {
                    $intVesselId = (int)$vesselData->intVesselId;
                } else {
                    $intVesselId = $request['intVesselId'];
                }
                $additionDeductionType=null;
                foreach ($request['additionDeductionMultipleList'] as $multiple) {
                    // if($multiple['intTypeId']=="1"){
                    //     $additionDeductionType=1;
                    // }else if($multiple['intTypeId']=="4"){
                    //     $additionDeductionType=2;
                    // }
                    //old Opening Data
                    $openingData = null;
                    if (!is_null($intVesselId)) {
                        $openingData = OpeningClosingAccount::orderBy('intID', 'desc')
                            ->where('intVesselId', $intVesselId)
                            ->where('intAdditionDeductionTypeId',$multiple['intTypeId'])
                            ->first();
                    }
                    //Opening Closing Add
                    if (!is_null($openingData)) {
                        $this->addOpeningClosing($openingData, $multiple, $request, $intVesselId);
                    }


                    //addition Deduction Add
                    if (!is_null($multiple['strAttachment'])) {
                        $strAttachment = Base64Encoder::uploadBase64File($multiple['strAttachment'], "/assets/images/asllAdditionDeduction/", $multiple['strTypeName'], 'type');
                    } else {
                        $strAttachment = $multiple['strAttachment'];
                    }

                    if ($intAdditionDeductionId > 0) {
                        $intRequestId = DB::table(config('constants.DB_ASLL') . ".tblAdditionDeductionDetails")->insertGetId(
                            [
                                'intAdditionDeductionId' => $intAdditionDeductionId,
                                'intAdditionDeductionTypeId' => $multiple['intTypeId'],
                                'strAdditionDeductionTypeName' => $multiple['strTypeName'],
                                'amount' => $multiple['strAmount'],
                                'intTransactionTypeId' => $multiple['intTransactionTypeId'],
                                'intEmployeeId' => (isset($request['intEmployeeId']) && $request['intEmployeeId'] !== null) ? $request['intEmployeeId'] : null,
                                'intVesselId' => $vesselId,
                                'intMonthId' => $multiple['intMonthId'],
                                "strAttachment" => $strAttachment,
                                'decQty' => $multiple['decQty'],
                                'strRemarks' => $multiple['strRemarks'],
                                'intVesselItemId' => $multiple['intVesselItemId'],
                                'strVesselItemName' => $multiple['strVesselItemName'],
                                'intYear' => $multiple['intYear'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]
                        );
                    }

                    if ($multiple['strTypeName'] == "Bond Issue") {
                        $bondDeductionAmount += $multiple['strAmount'] * $multiple['decQty'];
                    }
                    if ($multiple['strTypeName'] == "Cash Advance") {
                        $cashDeductionAmount += $multiple['strAmount'] * $multiple['decQty'];
                    }
                }

                VesselAccount::where('intVesselId', $vesselId)
                    ->update([
                        'decBondAccountBalance' => $bondPreviousBalance - $bondDeductionAmount,
                        'decCashAccountBalance' => $cashPreviousBalance - $cashDeductionAmount,
                        'updated_at' => Carbon::now(),
                    ]);
            }
            DB::commit();
            return $intRequestId;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function deleteAdditionDetailsData($intID)
    {
        $vesselAccountRepo = new AsllVesselAccountRepository();
        try {
            $details = AdditionDeductionDetails::find($intID);
            if (!is_null($details)) {
                $details->delete();
            }
            if ($details->intAdditionDeductionTypeId == 1 && $details->intAdditionDeductionTypeId == 4) {
                $differenceAmount = $details->amount;
                $isIncrement = true;
                $vesselAccountRepo->IncOrDecVesselAccountInfo($details->intVesselId, $differenceAmount, $isIncrement,  $details->intAdditionDeductionTypeId);
            }
            return $details;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function updateAdditionDetailsData($intID, $amount)
    {
        $vesselAccountRepo = new AsllVesselAccountRepository();
        try {
            $details = AdditionDeductionDetails::find($intID);
            // get this vessel id, detail amount data, id
            $differenceAmount = ((float) $amount - $details->amount);
            $isIncrement = $differenceAmount > 0 ? true : false;
            $differenceAmount = abs($differenceAmount);
            $details->amount = $amount;
            $details->save();

            // Update Vessel Account Data
            $vesselAccountRepo->IncOrDecVesselAccountInfo($details->intVesselId, $differenceAmount, $isIncrement,  $details->intAdditionDeductionTypeId);

            return $details;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function addOpeningClosing($openingData, $multiple, $request, $intVesselId)
    {

        $insertOpening = new OpeningClosingAccount();
        $insertOpening->intEmployeeId = $request['intEmployeeId'];
        $insertOpening->intAdditionDeductionTypeId = $openingData->intAdditionDeductionTypeId;
        $insertOpening->intTransactionTypeId = $multiple['intTransactionTypeId'];
        $insertOpening->intVesselId = $intVesselId;
        $insertOpening->decOpening = $openingData->decClosing;

            if ($multiple['intTransactionTypeId'] == "1") {
                $insertOpening->decReceive = $multiple['strAmount'];
                $insertOpening->decClosing = $openingData->decClosing + $multiple['strAmount'];
            } else {
                $insertOpening->decReceive = 0;
            }

            if ($multiple['intTransactionTypeId'] == "2") {
                $insertOpening->decIssue = $multiple['strAmount'];
                $insertOpening->decClosing = $openingData->decClosing - $multiple['strAmount'];
            } else {
                $insertOpening->decIssue = 0;
            }


        $insertOpening->strRemarks = $multiple['strRemarks'];
        $insertOpening->intActionBy = auth()->user()->intEnroll;
        $insertOpening->dteActionDate = Carbon::now();
        $insertOpening->created_at = Carbon::now();
        $insertOpening->updated_at = Carbon::now();
        $insertOpening->save();
    }
}
