<?php

namespace Modules\VoyageLighter\Repositories;

use App\Helpers\Base64Encoder;
use App\Helpers\ImageUploadHelper;
use App\Helpers\UploadHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\VoyageLighter\Entities\ChartererList;
use Modules\VoyageLighter\Entities\DeamandSheetAprvDetaills;
use Modules\VoyageLighter\Entities\LighterLoadingPoint;
use Modules\VoyageLighter\Entities\ShipperList;
use Modules\VoyageLighter\Entities\VesselDemandSheet;
use Modules\VoyageLighter\Entities\VesselDemandSheetApprove;
use Modules\VoyageLighter\Entities\VesselDemandSheetDetaills;

class VesselDemandSheetRepository
{


    public function postvesselDemandQntStore(Request $request)
    {
        try {
            $decTotal = 0;
            foreach ($request->demandSheetData as $ud) {
                $decTotal += $ud['intQuantity'];
            }
            $vesselDemandSheet = VesselDemandSheet::create([
                'dteLayCanFromDate' => $request->dteLayCanFromDate,
                'dteLayCanToDate' => $request->dteLayCanToDate,
                'intCountryID' => $request->intCountryID,
                'strCountry' => $request->strCountry,
                'decGrandQuantity' => $decTotal,
                'dteETADateFromLoadPort' => $request->dteETADateFromLoadPort,
                'dteETADateToLoadPort' => $request->dteETADateToLoadPort,
                'strComments' => $request->strComments,
                'ysnActive' => 1,
                'intCreatedBy' => $request->intCreatedBy,
                'created_at' => Carbon::now(),
                'intPortFrom' => $request->intPortFrom,
                'strPortFrom' => $request->strPortFrom,
                'intPortTo' => $request->intPortTo,
                'strPortTo' => $request->strPortTo,
                'ysnApprove' => 0,
                'strImagePath' =>  null,
                'intCharterer' => $request->intCharterer,
                'strCharterer' => $request->strCharterer,
                'intShipper' => $request->intShipper,
                'strShipper' => $request->strShipper,
            ]);

            foreach ($request->demandSheetData as $demandSheetData) {
                if (isset($demandSheetData['images']) && !is_null($demandSheetData['images']) && $demandSheetData['images'] !== "") {
                    $fileName = Base64Encoder::uploadBase64File($demandSheetData['images'], "/assets/images/demand-sheet/", time(), 'demandSheetData');
                } else {
                    $fileName = null;
                }



                $vesselDemandSheetDetaills = VesselDemandSheetDetaills::create([
                    'intVesselDemandSheetID' => $vesselDemandSheet->intID,
                    'intItemId' => $demandSheetData['intItemId'],
                    'strItemName' => $demandSheetData['strItemName'],
                    'intQuantity' => $demandSheetData['intQuantity'],
                    'strAttachment' => $fileName,
                ]);
            }
            return $vesselDemandSheetDetaills;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function postvesselDemandQntApproveStore(Request $request)
    {
        try {
            $decTotal = 0;
            foreach ($request->demandSheetAprvData as $ud) {
                $decTotal += $ud['intQuantity'];
            }
            $intDemandSheetId = $request->intVesselDemandSheetID;
            $vesselDemandSheet = VesselDemandSheet::find($intDemandSheetId);

            $vesselDemandSheetApprove = VesselDemandSheetApprove::create([
                'intVesselDemandSheetID' => $request->intVesselDemandSheetID,
                'dteLayCanFromDate' => $request->dteLayCanFromDate,
                'dteLayCanToDate' => $request->dteLayCanToDate,
                'intCountryID' => $request->intCountryID,
                'strCountry' => $request->strCountry,
                'decGrandQuantity' => $decTotal,
                'dteETADateFromLoadPort' => $request->dteETADateFromLoadPort,
                'dteETADateToLoadPort' => $request->dteETADateToLoadPort,
                'strComments' => $request->strComments,
                'ysnActive' => 1,
                'intCreatedBy' => $request->intCreatedBy,
                'created_at' => Carbon::now(),
                'intPortFrom' => $request->intPortFrom,
                'strPortFrom' => $request->strPortFrom,
                'intPortTo' => $request->intPortTo,
                'strPortTo' => $request->strPortTo
            ]);

            foreach ($request->demandSheetAprvData as $demandSheetAprvData) {
                // Check if already an entry in demandSheetAprvDataMain table
                // $lighter = VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)->first();

                $deamandSheetAprvDetaills = DeamandSheetAprvDetaills::create([
                    'intVesselDemandSheetAprvID' => $vesselDemandSheetApprove->intID,
                    'intItemId' => $demandSheetAprvData['intItemId'],
                    'strItemName' => $demandSheetAprvData['strItemName'],
                    'intQuantity' => $demandSheetAprvData['intQuantity']
                ]);
            }

            $vesselDemandSheet->ysnApprove = 1;
            $vesselDemandSheet->save();

            return $deamandSheetAprvDetaills;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }


    public function getPendingDataForAprv()
    {
        $unloadCatgList = VesselDemandSheet::where('ysnApprove', 0)
            ->orderBy('intID', 'DESC')
            ->get();
        return $unloadCatgList;
    }

    public function getDemandSheetDetailByID($intID)
    {
        $unloadCatgList = VesselDemandSheet::where('intID', $intID)
            ->with('details')
            ->first();
        return $unloadCatgList;
    }

    public function getShipperList()
    {
        $shipperList = ShipperList::where('ysnActive', 1)

            ->get();
        return $shipperList;
    }
    public function getChartererList()
    {
        $chartererList = ChartererList::where('isActive', 1)

            ->get();
        return $chartererList;
    }

    public function getApproveDataDemandSheet()
    {
        $vesselDemandSheetaprvList = VesselDemandSheetApprove::where('ysnActive', 1)
            ->orderBy('intID', 'DESC')
            ->get();
        return $vesselDemandSheetaprvList;
    }


    public function updateApprovedInformationDataDemandSheet(Request $request)
    {

        $intID = $request->intID;
        try {
            VesselDemandSheetApprove::where('intID', $intID)
                ->update([
                    'strComments' => $request->strComments,
                    'intUpdatedBy' => $request->intUpdatedBy,
                    'updated_at' =>  Carbon::now(),
                ]);
            $data = VesselDemandSheetApprove::where('intID', $intID)->first();
            return $data;
            // return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getApproveDataByID($intID)
    {
        // return $intID;

        $vesselDemandSheetaprvList = VesselDemandSheetApprove::where('intID', $intID)
        ->with('details')
        ->first();
        return $vesselDemandSheetaprvList;
    }
}
