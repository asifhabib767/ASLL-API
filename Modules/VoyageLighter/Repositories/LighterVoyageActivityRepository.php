<?php

namespace Modules\VoyageLighter\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\VoyageLighter\Entities\CreditorList;
use Modules\VoyageLighter\Entities\LighterVoyageActivity;
use Modules\VoyageLighter\Entities\MotherVessel;
use Modules\VoyageLighter\Entities\VoyageLighterDetails;
use Modules\VoyageLighter\Entities\VoyageLighterMain;

use function GuzzleHttp\Promise\all;

class LighterVoyageActivityRepository
{
    public function getLighterVoyageActivity()
    {
        try {
            $voyageLighter = LighterVoyageActivity::where('ysnActive', 1)
                ->get();
            return $voyageLighter;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function lighterVoyageActivityStore(Request $request)
    {
        try {
            if($request->intLighterPositionStatusId != 1){
                $previusValue = $request->intLighterPositionStatusId - 1;
                $previousEntry = LighterVoyageActivity::where('intLighterVoyageId', $request->intLighterVoyageId)
                ->where('intLighterPositionStatusId', '=', $previusValue)
                ->first();
                if(is_null($previousEntry)){
                    return 0;
                }
            }

            $voyageLighterActivity = LighterVoyageActivity::create([
                'intLighterVoyageId' => $request->intLighterVoyageId,
                'intLighterPositionStatusId' => $request->intLighterPositionStatusId,
                'dteCompletionDate' => Carbon::now()->toDateString(),
                'strCompletionTime' => Carbon::now()->format('g:i A'),
                'intCreatedBy' => $request->intCreatedBy,
                'dteCreatedAt' => Carbon::now(),
                'strAdditionalStatus' => $request->strAdditionalStatus,
                'ysnStatus' => $request->ysnStatus,
                'ysnActive' => $request->ysnActive,
            ]);
            return $voyageLighterActivity;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }


    public function getLighterVoyageTopsheet($dteStartDate, $dteEndDate)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        try {
            $voyageLighter = VoyageLighterMain::where('ysnActive', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where ('intSurveyNumber', false)
                ->with('details')
                ->orderBy('intID', 'desc')
                ->get();
            return $voyageLighter;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function getLighterVoyageDetaillsByID($intID)
    {


        try {
            $voyageLighter = VoyageLighterMain::where('ysnActive', 1)

                ->where ('intID', $intID)
                ->with('details')

                ->get();
            return $voyageLighter;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function voyageActivityupdate(Request $request)
    {
        // return $request->all();
        $intID = $request->intID;
        $intVoyageLighterId = $request->intVoyageLighterId;
        try {
            VoyageLighterMain::where('intID', $intID)
                ->update([
                    'decTripCost' => $request->decTripCost,
                    'decPilotCoupon' => $request->decPilotCoupon,
                    'decFreightRate' => $request->decFreightRate,
                    'intSurveyNumber' => $request->intSurveyNumber,
                    'strPartyName' => $request->strPartyName,
                    'strPartyCode' => $request->strPartyCode,
                    'updated_at' =>  Carbon::now(),
                ]);
            $data = VoyageLighterMain::where('intID', $intID)->first();

            VoyageLighterDetails::where('intVoyageLighterId', $intVoyageLighterId)
            ->update([
                'intSurveyQty' => $request->intSurveyQty,
                'intQuantity' => $request->intSurveyQty,
            ]);
        $data = VoyageLighterDetails::where('intVoyageLighterId', $intVoyageLighterId)->first();




            return $data;
            // return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCreditorList()
    {


        try {
            $voyageLighter = CreditorList::where('ysnActive', 1)



                ->get();
            return $voyageLighter;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function getMotherVesselList()
    {


        try {
            $voyageLighter = MotherVessel::where('isActive', 1)



                ->get();
            return $voyageLighter;
        } catch (\Exception $e) {
            return false;
        }
    }

}
