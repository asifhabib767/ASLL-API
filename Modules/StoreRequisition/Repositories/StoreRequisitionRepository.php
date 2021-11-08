<?php

namespace Modules\StoreRequisition\Repositories;

use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class StoreRequisitionRepository
{

    public function getRequisitionListByUnitId($intUnitId, $dteStartDate = null, $dteEndDate = null, $intWHID = null)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";
        $query = DB::table(config('constants.DB_Inventory') . ".tblRequisition")
            ->join(config('constants.DB_HR') . ".tblDepartment", 'tblRequisition.intDeptID', 'tblDepartment.intDepartmentID')
            ->join(config('constants.DB_HR') . ".tblEmployee", 'tblRequisition.intReqBy', 'tblEmployee.intEmployeeID');

        if (!is_null($intWHID)) {
            $query->where('tblRequisition.intWHID', $intWHID);
        }

        $output = $query->select(
            [
                'tblRequisition.intReqID',
                'tblRequisition.intDeptID',
                'tblRequisition.dteReqDate',
                'tblRequisition.intUnitID',
                'tblRequisition.strCode',
                'tblRequisition.intReqBy',
                'tblEmployee.strEmployeeName as strRequestByName',
                'tblRequisition.ysnActive',
                'tblDepartment.strDepatrment',
                'tblRequisition.strCode',
            ]
        )
            ->where('tblRequisition.ysnActive', true)
            ->where('tblRequisition.intUnitID', $intUnitId)
            ->whereBetween('tblRequisition.dteInsertDateTime', [$startDate, $endDate])
            ->orderBy('tblRequisition.intReqID', 'desc')
            ->get();

        return $output;
    }

    public function getRequisitionListByEmployeeId($intEmployeeId, $dteStartDate = null, $dteEndDate = null)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";
        $query = DB::table(config('constants.DB_Inventory') . ".tblRequisition")
            ->join(config('constants.DB_HR') . ".tblDepartment", 'tblRequisition.intDeptID', 'tblDepartment.intDepartmentID')
            ->join(config('constants.DB_HR') . ".tblEmployee", 'tblRequisition.intReqBy', 'tblEmployee.intEmployeeID');

        $output = $query->select(
            [
                'tblRequisition.intReqID',
                'tblRequisition.intDeptID',
                'tblRequisition.dteReqDate',
                'tblRequisition.intUnitId',
                'tblRequisition.strCode',
                'tblRequisition.ysnActive',
                'tblEmployee.strEmployeeName as strRequestByName',
                'tblDepartment.strDepatrment',
                'tblRequisition.strCode',
            ]
        )
            ->where('tblRequisition.ysnActive', true)
            ->where('tblRequisition.intReqBy', $intEmployeeId)
            ->whereBetween('tblRequisition.dteInsertDateTime', [$startDate, $endDate])
            ->orderBy('tblRequisition.intReqID', 'desc')
            ->get();

        return $output;
    }


    public function getRequisitionDetailsByRequisitionId($intReqID)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblRequisitionDetail")
            ->join(config('constants.DB_Inventory') . ".tblItemList", 'tblRequisitionDetail.intItemID', 'tblItemList.intItemID');


        $output = $query->select(
            [
                'intReqID',
                'tblRequisitionDetail.intItemID as intItemID',
                'tblItemList.strItemName',
                'tblItemList.strUoM',
                'dteDueDate',
                'strRemarks',
                'numReqQty',
                'intApproveBy',
                'dteApproveDate',
                'numApproveQty',
                'numIssueQty',
                'ysnEdited',
                'intAutoID',
                'numActualProduction',
                'numIndentQty',
                'numSupervisorApproveQty',
                'dteSupervisorApproveDate',
                'ysnSupervisorApprove',
                'intDeptHeadApproveBy',
                'numDeptHeadApproveQty',
                'dteDeptHeadApproveDate',
                'ysnDeptHeadApprove',
                'intTechnicalApproveBy',
                'numTechnicalApproveQty',
                'dteTechnicalApproveDate',
                'ysnTechnicalApprove',
                'intAdminApproveBy',
                'numAdminApproveQty',
                'dteAdminApproveDate',
                'ysnAdminApprove',
            ]
        )
            ->where('intReqID', $intReqID)
            ->get();

        return $output;
    }

    public function getRequisitionOriginDetailsByRequisitionId($intReqID)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblRequisition");

        $output = $query->select(
            [
                'intReqID',
                'intDeptID',
                'intSectionID',
                'intReqBy',
                'dteReqDate',
                'intUnitID',
                'intWHID',
                'ysnActive',
                'strCode',
                'strSection',
                'intMaintenanceID',
                'intProdOrderID',
                'intCCenterID',
                'intIndentId',
                'intInsertBy',
                'dteInsertDateTime',
            ]
        )
            ->where('tblRequisition.intReqID', $intReqID)
            ->first();

        return $output;
    }


    public function storeStoreRequisition(Request $request)
    {

        // return $request->requisitions;
        // Add Single Entry in tblRequisition table
        // and multiple in tblRequisitionDetail
        if (count($request->requisitions) == 0) {
            return "No Item Given";
        }
        try {
            // DB::beginTransaction();
            $i = 1;

            $firstRequisition = $request->requisitions[0];

            $intReqID = DB::table(config('constants.DB_Inventory') . ".tblRequisition")->insertGetId(
                [
                    // Required Fields
                    "dteInsertDateTime" => Carbon::now(),
                    "intDeptID" => $firstRequisition['intDeptID'],
                    "intUnitID" => $firstRequisition['intUnitID'],
                    "intWHID" => $firstRequisition['intWHID'],
                    "dteReqDate" => $firstRequisition['dteReqDate'],

                    // Other fields
                    "intSectionID" => null,
                    "intReqBy" => $firstRequisition['intInsertBy'],
                    "ysnActive" => true,
                    "strCode" => $this->generateStoreRequisitionCode($firstRequisition['dteReqDate']),
                    "strSection" => null,
                    "intMaintenanceID" => null,
                    "intProdOrderID" => null,
                    "intCCenterID" => null,
                    "intIndentId" => null,
                    "intInsertBy" => $firstRequisition['intInsertBy']
                ]
            );

            foreach ($request->requisitions as $requisition) {
                if ($intReqID > 0) {
                    DB::table(config('constants.DB_Inventory') . ".tblRequisitionDetail")->insertGetId(
                        [
                            'intReqID' => $intReqID,
                            'intItemID' => $requisition['intItemID'],
                            'dteDueDate' => $requisition['dteReqDate'],
                            'strRemarks' => $requisition['strRemarks'],
                            'numReqQty' => $requisition['numReqQty'],
                            'intApproveBy' => null,
                            'dteApproveDate' => null,
                            'numApproveQty' => null,
                            'numIssueQty' => $requisition['numReqQty'],
                            'ysnEdited' => null,
                            'numActualProduction' => null,
                            'numIndentQty' => null,
                            'numSupervisorApproveQty' => null,
                            'dteSupervisorApproveDate' => null,
                            'ysnSupervisorApprove' => null,
                            'intDeptHeadApproveBy' => null,
                            'numDeptHeadApproveQty' => null,
                            'dteDeptHeadApproveDate' => null,
                            'ysnDeptHeadApprove' => null,
                            'intTechnicalApproveBy' => null,
                            'numTechnicalApproveQty' => null,
                            'dteTechnicalApproveDate' => null,
                            'ysnTechnicalApprove' => null,
                            'intAdminApproveBy' => null,
                            'numAdminApproveQty' => null,
                            'dteAdminApproveDate' => null,
                            'ysnAdminApprove' => null,
                        ]
                    );
                }
                $i++;
            }
            // DB::commit();
            return $intReqID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }




    /**
     * generateStoreRequisitionCode
     *
     * @example string REQ-Aug20-11191
     *
     * @return string $strCode
     */
    public function generateStoreRequisitionCode($date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }
        $year = Carbon::parse($date)->format('Y');
        $month = Carbon::parse($date)->format('M');
        $yearLast2Digit = substr($year, 2, 2);


        // Get total requisition no in this month and year
        $startDate = $year . "-" . Carbon::parse($date)->format('m') . "-01";
        $lastDate = $year . "-" . Carbon::parse($date)->format('m') . "-" . Carbon::parse($date)->format('t');

        $requisitions = DB::table(config('constants.DB_Inventory') . ".tblRequisition")->select('intReqID')
            ->whereBetween('dteReqDate', [$startDate, $lastDate])
            ->get();
        $totalCount = count($requisitions) + 1;

        $strCode = "REQ-";
        $strCode .=  $month . $yearLast2Digit . "-" . $totalCount;
        return $strCode;
    }

    /**
     * update and approve store requisition
     *
     * QUERY:
        Update dtls set dtls.intApproveBy = @actionby, dteApproveDate=Getdate(), numApproveQty= ml.Quantity
        ,numSupervisorApproveQty=ml.Quantity
        from ERP_Inventory.dbo.tblRequisitionDetail dtls inner join @tblXml ml on dtls.intItemID=ml.Item
        where dtls.intReqID = @id
     *
     * @param Request $request
     * @return void
     */
    public function updateAndApproveStoreRequisition(Request $request)
    {
        if (!$request->intItemID) {
            throw new \Exception('Item Not Found !');
        }
        if ($request->quantity > $request->numReqQty) {
            throw new \Exception('Approve Error, Approve Quantity is greater than Request Quantity');
        }

        try {
            DB::beginTransaction();
            DB::table(config('constants.DB_Inventory') . ".tblRequisitionDetail")
                ->where('intReqID', $request->intReqID)
                ->where('intItemID', $request->intItemID)
                ->update(
                    [
                        'intApproveBy' => $request->intApproveBy,
                        'dteApproveDate' => Carbon::now(),
                        'numApproveQty' => $request->quantity,
                        'numSupervisorApproveQty' => $request->quantity,
                    ]
                );
            DB::commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
