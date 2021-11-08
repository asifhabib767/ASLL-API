<?php

namespace Modules\ASLLHR\Repositories;

use Modules\ASLLHR\Entities\AsllEmployee;
use Illuminate\Support\Facades\DB;
use Modules\ASLLHR\Entities\AsllCrCriteriaOptionResponse;
use Modules\ASLLHR\Entities\AsllCRReportCriteriaMain;
use Modules\ASLLHR\Entities\AsllCRRreport;
use Illuminate\Support\Facades\Crypt;

class AsllCrReportRepository
{

    public function getCrReportCriteriaOption()
    {

        try {
            $criterias = AsllCRReportCriteriaMain::select('intID', 'strName')
                ->with('options')->get();
            return $criterias;
        } catch (\Exception $e) {
            return false;
        }
    }



    public function getCrReportCriteriaOptionById($intCrReportId)
    {

        try {
            $criterias = AsllCRReportCriteriaMain::select('intID', 'strName')
                ->with('options')->get();

            $updatedCriterias = $criterias;
            foreach ($updatedCriterias as $criteria) {
                $j = 0;
                foreach ($criteria->options as $option) {

                    $hasResponse = AsllCrCriteriaOptionResponse::where('intCriteriaMainId', $criteria->intID)
                        ->where('intOptionMainId', $option->intID)
                        ->where('intCrReportId', $intCrReportId)
                        ->exists();

                    if ($hasResponse) {
                        $option->ysnChecked = true;
                    } else {
                        $option->ysnChecked = false;
                    }

                    $criteria->options[$j] = $option;
                    $j++;
                }
            }
            return $updatedCriterias;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCrReportEmployeeInfoByEmployeeId($employeeId)
    {
        try {
            $query = AsllEmployee::leftJoin('tblVessel', 'tblASLLEmployee.intVesselID', 'tblVessel.intID')
                ->select(
                    'tblASLLEmployee.intID',
                    'tblASLLEmployee.intVesselID',
                    'tblASLLEmployee.strRank',
                    'tblASLLEmployee.intRankId',
                    'tblVessel.strVesselName',
                )
                ->with('status')
                ->where('tblASLLEmployee.intID', $employeeId)
                ->get();

            return $query;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCrReportList()
    {
        try {
            $query = AsllCRRreport::leftJoin('tblASLLEmployee', 'tblCRReport.intEmployeeId', '=', 'tblASLLEmployee.intID')
                ->leftJoin('tblVessel', 'tblCRReport.intVesselId', 'tblVessel.intID')
                ->leftJoin('tblRank', 'tblCRReport.intRankId', 'tblRank.intID')
                ->select(
                    'tblCRReport.*',
                    'tblVessel.intID as vesselId',
                    'tblVessel.strVesselName',
                    'tblASLLEmployee.strName',
                    'tblRank.strRankName',
                )
                ->orderBy('tblCRReport.intID', 'desc');
            $data = [];
            if (request()->isPaginated) {
                $paginateNo = request()->paginateNo ? request()->paginateNo : 20;
                $data = $query->paginate($paginateNo);
            } else {
                $data = $query->get();
            }

            foreach ($data as $d) {
                $d->strEncryptedId = Crypt::encrypt($d->intID);
            }

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCrReportDetails($intCrReportId)
    {
        try {
            $query = AsllCRRreport::leftJoin('tblASLLEmployee', 'tblCRReport.intEmployeeId', '=', 'tblASLLEmployee.intID')
                ->leftJoin('tblVessel', 'tblCRReport.intVesselId', 'tblVessel.intID')
                ->leftJoin('tblRank', 'tblCRReport.intRankId', 'tblRank.intID')
                ->select(
                    'tblCRReport.*',
                    'tblVessel.intID as vesselId',
                    'tblVessel.strVesselName',
                    'tblASLLEmployee.strName',
                    'tblRank.strRankName',
                )
                ->where('tblCRReport.intID', $intCrReportId)
                ->first();
            return $query;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $pkId =  DB::table(config('constants.DB_ASLL') . ".tblCRReport")
                ->insertGetId(
                    [
                        'intEmployeeId' => $request->intEmployeeId,
                        'intRankId' => $request->intRankId,
                        'intVesselId' => $request->intVesselId,
                        'dteFromDate' => $request->dteFromDate,
                        'dteToDate' =>  $request->dteToDate,
                        'strReasonOfAppraisal' => $request->strReasonOfAppraisal,
                        'strOverallPerformance' => $request->strOverallPerformance,
                        'ysnPromotionRecomanded' => $request->ysnPromotionRecomanded,
                        'ysnFurtherRecomanded' => $request->ysnFurtherRecomanded,
                        'strPromotionRecomandedDate' => $request->strPromotionRecomandedDate,
                        'strFurtherRecomandedDate' => $request->strFurtherRecomandedDate,
                        'strMasterSign' => $request->strMasterSign,
                        'strCESign' => $request->strCESign,
                    ]
                );

            if ($pkId > 0) {
                $data = "";

                // foreach ($request['options'] as $option) {
                //     if($option['ysnIsChecked']){
                //         DB::table(config('constants.DB_ASLL') . ".tblCRCriteriaOptionResponse")->insert(
                //             [
                //                 'intCriteriaMainId' => $option['intCriteriaMainId'],
                //                 'intCrReportId' =>  $pkId,
                //                 'intOptionMainId' => $option['intOptionMainId'],
                //                 'strOptionValue' => $option['strOptionValue'],
                //                 'ysnIsChecked' => $option['ysnIsChecked'],
                //             ]
                //         );
                //     }
                // }

                foreach ($request['criterias'] as $criteria) {
                    foreach ($criteria['options'] as $option) {
                        if ($option['ysnChecked']) {
                            DB::table(config('constants.DB_ASLL') . ".tblCRCriteriaOptionResponse")->insert(
                                [
                                    'intCriteriaMainId' => $option['intCriteriaMainId'],
                                    'intCrReportId' =>  $pkId,
                                    'intOptionMainId' => $option['intID'],
                                    'strOptionValue' => $option['strName'],
                                    'ysnIsChecked' => $option['ysnChecked'],
                                ]
                            );
                        }
                    }
                }
                //
            }

            DB::commit();
            return  $pkId;
        } catch (\Throwable $e) {
            //throw $th;
            $e->getMessage();
        }
    }
}
