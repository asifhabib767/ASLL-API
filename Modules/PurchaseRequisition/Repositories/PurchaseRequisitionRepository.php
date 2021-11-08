<?php

namespace Modules\PurchaseRequisition\Repositories;

use App\Helpers\Base64Encoder;
use App\Helpers\UploadHelper;
use App\Imports\GroupContactsImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Excel;
// use File;
use Image;
use Modules\StoreRequisition\Repositories\StoreRequisitionRepository;
use stdClass;

class PurchaseRequisitionRepository
{

    public $storeRequisitionRepository;

    public function __construct(StoreRequisitionRepository $storeRequisitionRepository)
    {
        $this->storeRequisitionRepository = $storeRequisitionRepository;
    }

    /**
     * Purchase Requisition Bulk Import
     * 
     * QUERY: 
     *
     * @param Request $request
     * @return void
     */
    public function fileInput($request)
    {
        if ($request->uploadFile) {
            // $file = UploadHelper::upload('uploadFile', $request->uploadFile, time(), 'assets/fielInput');
            // return $file;

            // Process it
            $file = $request->uploadFile;
            $requisitions = [];
            $extension = $file->getClientOriginalExtension();
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $data = Excel::toArray(new GroupContactsImport(), $request->uploadFile);
                foreach ($data as $key => $value) {
                    $i = 1;
                    foreach ($value as $val) {
                        if ($i > 1) {
                            $requisitions[] = $val;
                        }
                        $i++;
                    }
                }
            } else {
                session()->flash('error', 'File is a ' . $extension . ' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }

            $postRequisitions = [];
            foreach ($requisitions as $requisition) {
                $data = [];
                $data['intWHID'] = (int) $request->intWarehouseId;
                $data['dteDueDate'] = $request->dteDueDate;
                $data['intItemID'] = (int) $requisition[0];
                $data['numQty'] =  (int) $requisition[1];
                $data['intDepartmentID'] = (int) $request->intDepartmentId;
                $data['intEmployeeId'] = (int) $request->intInsertBy;
                $data['intUnitID'] = (int) $request->intUnitID;
                $data['intCostCenter'] = null;
                $data['strIndentType'] = $request->strIndentType;
                $data['strAccountRemarks'] = $request->strAccountRemarks;
                $postRequisitions[] = $data;
            }
            $request->requisitions = $postRequisitions;
            // return $request->requisitions;
            // return $this->storeRequisitionRepository->storeStoreRequisition($request);

            $data = $this->storePurchaseRequisition($request);
        }
        return $data;
    }

    public function storePurchaseRequisition(Request $request)
    {
        // Add Single Entry in tblPurchaseIndent table 
        // and multiple in tblPurchaseIndentDetail
        if (count($request->requisitions) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();
            $i = 1;
            $firstRequisition = $request->requisitions[0];
            $intIndentID = DB::table(config('constants.DB_Inventory') . ".tblPurchaseIndent")->insertGetId(
                [
                    // Required Fields
                    'dteIndentDate' => Carbon::now(),
                    'dteDueDate' => $firstRequisition['dteDueDate'],
                    'strIndentType' => $firstRequisition['strIndentType'],
                    'intLastActionBy' => $firstRequisition['intEmployeeId'],
                    'intUnitID' => $firstRequisition['intUnitID'],

                    // Other fields
                    'intApproveBy' => null,
                    'dteApproveDate' => null,
                    'ysnFullPO' => null,
                    'ysnReject' => false,
                    'strIndentCode' => null,
                    'intWHID' => $firstRequisition['intWHID'],
                    'ysnActive' => true,
                    'ysnAccountsApprove' => false,
                    'intAccountApproveBy' => null,
                    'dteAccountApproveTime' => null,
                    'ysnAccountsReject' => false,
                    'intGlobalCOA' => null,
                    'strAccountRemarks' => $firstRequisition['strAccountRemarks'],
                    'dteBudgetMonth' => null,
                    'intAccountRejectBy' => null,
                    'dteAccountsRejectDate' => null,
                    'strApprovalStatus' => null,
                    'intCostCenter' => $firstRequisition['intCostCenter'],
                    'intDepartmentID' => $firstRequisition['intDepartmentID'],
                    'ysnClose' => false,
                    'intcloseby' => null
                ]
            );

            // $intIndentID = null;
            foreach ($request->requisitions as $requisition) {
                if ($intIndentID > 0 && $requisition['intItemID'] > 0 && $requisition['numQty'] > 0) {
                    DB::table(config('constants.DB_Inventory') . ".tblPurchaseIndentDetail")->insertGetId(
                        [
                            'intIndentID' => $intIndentID,
                            'intItemID' => $requisition['intItemID'],
                            'numQty' => $requisition['numQty'],
                            'intApproveBy' => $requisition['intEmployeeId'],
                            'dteApproveDate' => null,
                            'ysnPOIssued' => false,
                            'ysnReject' => false,
                            'strPurpose' => $requisition['strAccountRemarks'],
                            'intQcByID' => null,
                            'strSpecification' => null,
                            'intLastActionBy' => $requisition['intEmployeeId'],
                            'dteLastActionTime' => null,
                            'numUpdateQty' => 0,
                            'intLastUpdateBy' => null,
                            'dteLastUpdateTime' => null,
                            'ysnAccApprove' => false,
                            'intAccApproveBy' => null,
                            'dteAccApproveDate' => null,
                            'ysnAccReject' => false,
                            'intAccRejectBy' => null,
                            'dteAccRejectDate' => null
                        ]
                    );
                }
                $i++;
            }
            DB::commit();
            return $intIndentID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function getPurchaseListDetailsByPurchaseId($intIndentID)
    {

        $query = DB::table(config('constants.DB_Inventory') . ".tblPurchaseIndentDetail");

        $output = $query->select(
            [
                'intIndentID',
                'intItemID',
                'numQty',
                'intApproveBy',
                'dteApproveDate',
                'ysnPOIssued',
                'ysnFullPOIssued',
                'ysnReject',
                'strPurpose',
                'intQcByID',
                'intID',
                'strSpecification',
                'intLastActionBy',
                'dteLastActionTime',
                'numUpdateQty',
                'intLastUpdateBy',
                'dteLastUpdateTime',
                'ysnAccApprove',
                'intAccApproveBy',
                'dteAccApproveDate',
                'ysnAccReject',
                'intAccRejectBy',
                'dteAccRejectDate',
                // DB::raw('vld.qty_available + transaction_sell_lines.quantity AS qty_available')
            ]
        )
            ->where('intIndentID', $intIndentID)
            // ->orderBy('tbltrip.intId', 'desc')
            ->get();

        return $output;
    }

    public function getPurchaseListByUnitId($intUnitID, $dteStartDate = null, $dteEndDate = null)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        $query = DB::table(config('constants.DB_Inventory') . ".tblPurchaseIndent")
            ->leftjoin(config('constants.DB_Accounts') . ".tblCostCenter", 'tblPurchaseIndent.intCostCenter', '=', 'tblCostCenter.intCostCenterID');

        $output = $query->select(
            [
                'tblPurchaseIndent.intIndentID',
                'tblPurchaseIndent.dteIndentDate',
                'tblPurchaseIndent.dteDueDate',
                'tblPurchaseIndent.strIndentType',
                'tblPurchaseIndent.intLastActionBy',
                'tblPurchaseIndent.intUnitID',
                'tblPurchaseIndent.intApproveBy',
                'tblPurchaseIndent.dteApproveDate',
                'tblPurchaseIndent.ysnFullPO',
                'tblPurchaseIndent.ysnReject',
                'tblPurchaseIndent.strIndentCode',
                'tblPurchaseIndent.intWHID',
                'tblPurchaseIndent.ysnActive',
                'tblPurchaseIndent.ysnAccountsApprove',
                'tblPurchaseIndent.intAccountApproveBy',
                'tblPurchaseIndent.dteAccountApproveTime',
                'tblPurchaseIndent.ysnAccountsReject',
                'tblPurchaseIndent.intGlobalCOA',
                'tblPurchaseIndent.strAccountRemarks',
                'tblPurchaseIndent.dteBudgetMonth',
                'tblPurchaseIndent.intAccountRejectBy',
                'tblPurchaseIndent.dteAccountsRejectDate',
                'tblPurchaseIndent.strApprovalStatus',
                'tblPurchaseIndent.intCostCenter',
                'tblPurchaseIndent.intDepartmentID',
                'tblPurchaseIndent.ysnClose',
                'tblPurchaseIndent.intcloseby',
                'tblCostCenter.strCCName'
                // DB::raw('vld.qty_available + transaction_sell_lines.quantity AS qty_available')
            ]
        )
            ->where('tblPurchaseIndent.intUnitID', $intUnitID)
            ->orderBy('tblPurchaseIndent.intIndentID', 'desc')
            ->whereBetween('tblPurchaseIndent.dteIndentDate', [$startDate, $endDate])
            ->get();

        return $output;
    }

    public function getPurchaseOriginDetailsByRequisitionId($intIndentID)
    {

        $query = DB::table(config('constants.DB_Inventory') . ".tblPurchaseIndent");

        $output = $query->select(
            [
                'intIndentID',
                'dteIndentDate',
                'dteDueDate',
                'strIndentType',
                'intLastActionBy',
                'intUnitID',
                'intApproveBy',
                'dteApproveDate',
                'ysnFullPO',
                'ysnReject',
                'strIndentCode',
                'intWHID',
                'ysnActive',
                'ysnAccountsApprove',
                'intAccountApproveBy',
                'dteAccountApproveTime',
                'ysnAccountsReject',
                'intGlobalCOA',
                'strAccountRemarks',
                'dteBudgetMonth',
                'intAccountRejectBy',
                'dteAccountsRejectDate',
                'strApprovalStatus',
                'intCostCenter',
                'intDepartmentID',
                'ysnClose',
                'intcloseby',
                // DB::raw('vld.qty_available + transaction_sell_lines.quantity AS qty_available')
            ]
        )
            ->where('intIndentID', $intIndentID)
            // ->orderBy('tbltrip.intId', 'desc')
            ->get();

        return $output;
    }
}
