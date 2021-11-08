<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Modules\Asll\Entities\VoyageActivity;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\Vessel;

class VoyageActivityRepository
{
    public function getVoyageActivity()
    {
        try {
            $query = VoyageActivity::join('tblVoyage', 'tblVoyage.intID', 'tblVoyageActivity.intVoyageID')
                ->join('tblVessel', 'tblVessel.intID', 'tblVoyage.intVesselID')
                ->leftJoin('tblVoyageActivityVlsf', 'tblVoyageActivityVlsf.intVoyageActivityID', 'tblVoyageActivity.intID');

            $search = request()->search;
            $voyage = request()->voyage;
            $vessel = request()->vessel;

            if ($search) {
                $query->where('decSeaDistance', (int) $search);
            }

            if ($voyage) {
                $query->where('intVoyageID', $voyage);
            }

            if ($vessel) {
                $query = $query->where('tblVessel.intID', $vessel);
            }
            $query->select(
                'tblVoyageActivity.intID',
                'tblVoyageActivity.decSeaDistance',
                'tblVoyageActivity.decLatitude',
                'tblVoyageActivity.decLongitude',
                'tblVoyageActivity.dteCreatedAt',
                'tblVoyageActivity.decEngineSpeed',
                'tblVoyage.strVesselName',
                'tblVoyage.intID as intVoyageID',
                'tblVoyage.intVoyageNo',
                'tblVoyageActivityVlsf.decBunkerLsmgoCon',
                'tblVoyageActivityVlsf.decBunkerLsmgoRob',
                'tblVoyageActivityVlsf.decBunkerVlsfoRob',
                'tblVoyageActivityVlsf.decBunkerVlsfoCon',
            );

            $voyageActivity = $query->orderBy('tblVoyageActivity.intID', 'desc')->get();
            return $voyageActivity;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getWindDirection()
    {
        $arrayData = [
            [
                'name' => 'N',
                'id' => 1,
            ],
            [
                'name' => 'NNE',
                'id' => 2,
            ],
            [
                'name' => 'NE',
                'id' => 3,
            ],
            [
                'name' => 'ENE',
                'id' => 4,
            ],
            [
                'name' => 'E',
                'id' => 5,
            ],
            [
                'name' => 'ESE',
                'id' => 6,
            ],
            [
                'name' => 'SE',
                'id' => 7,
            ],
            [
                'name' => 'SSE',
                'id' => 8,
            ],
            [
                'name' => 'S',
                'id' => 9,
            ],
            [
                'name' => 'SSW',
                'id' => 10,
            ],
            [
                'name' => 'SW',
                'id' => 11,
            ],
            [
                'name' => 'WSW',
                'id' => 12,
            ],
            [
                'name' => 'W',
                'id' => 13,
            ],
            [
                'name' => 'WNW',
                'id' => 14,
            ],
            [
                'name' => 'NW',
                'id' => 15,
            ],
            [
                'name' => 'NNW',
                'id' => 16,
            ],
        ];
        return $arrayData;
    }



    /**
     * store new voyageActivity to voyageActivity
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function store(Request $request)
    {
        $voyageActivity = $this->getVoyageActivityByDate($request->dteCreatedAt, $request->intVoyageID);
        // $voyageActivity = $this->getVoyageActivityByDate($request->boilerlists[0]["dteCreatedAt"]);

        if (!is_null($voyageActivity)) {
            $voyageActivity = $this->update($request, $voyageActivity->intID);
            return $voyageActivity;
        }

        $intEmployeeId = 1;
        try {
            $voyageActivity = VoyageActivity::create([
                'intUnitId' => $request->intUnitId ? $request->intUnitId : 17,
                'intVoyageID' => $request->intVoyageID,
                'intShipPositionID' => $request->intShipPositionID,
                'intShipConditionTypeID' => $request->intShipConditionTypeID,
                'dteCreatedAt' => $request->dteCreatedAt,
                'decLatitude' => $request->decLatitude ? $request->decLatitude : 0,
                'decLongitude' => $request->decLongitude ? $request->decLongitude : 0,
                'intCourse' => $request->intCourse ? $request->intCourse : 0,
                'timeSeaStreaming' => $request->timeSeaStreaming,
                'timeSeaStoppage' => $request->timeSeaStoppage,
                'decSeaDistance' => $request->decSeaDistance,
                'decSeaDailyAvgSpeed' => $request->decSeaDailyAvgSpeed,
                'decSeaGenAvgSpeed' => $request->decSeaGenAvgSpeed,
                'strSeaDirection' => $request->strSeaDirection,
                'strSeaState' => $request->strSeaState,
                'strWindDirection' => $request->strWindDirection,
                'decWindBF' => $request->decWindBF,
                'intETAPortToID' => $request->intETAPortToID,
                'strETAPortToName' => $request->strETAPortToName,
                'strETADateTime' => $request->strETADateTime,
                'intETDPortToID' => $request->intETDPortToID,
                'strETDPortToName' => $request->strETDPortToName,
                'strETDDateTime' => $request->strETDDateTime,
                'strRemarks' => $request->strRemarks,
                'intVoyagePortID' => $request->intVoyagePortID,
                'decTimePortWorking' => $request->decTimePortWorking,
                'strPortDirection' => $request->strPortDirection,
                'strPortDSS' => $request->strPortDSS,
                'decCargoTobeLD' => $request->decCargoTobeLD,
                'decCargoPrevLD' => $request->decCargoPrevLD,
                'decCargoDailyLD' => $request->decCargoDailyLD,
                'decCargoTTLLD' => $request->decCargoTTLLD,
                'decCargoBalanceCGO' => $request->decCargoBalanceCGO,
                'strRPM' => $request->strRPM,
                'decEngineSpeed' => $request->decEngineSpeed,
                'decSlip' => $request->decSlip,
                'intCreatedBy' => $request->intEmployeeId ? $request->intEmployeeId : null,
                'decProduction' => $request->decProduction,
                'decConsumption' => $request->decConsumption,
                'decSeaTemp' => $request->decSeaTemp,
                'decAirTemp' => $request->decAirTemp,
                'decBaroPressure' => $request->decBaroPressure,
                'decTotalDistance' => $request->decTotalDistance,
                'decDistanceToGo' => $request->decDistanceToGo,
                'ysnActive' => 1,
                'synced' => 0,
            ]);
            return $voyageActivity;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * show voyage activity by id
     *
     * @param integer $id
     * @return object voyage object
     */
    public function show($id)
    {

        try {
            $voyageActivity = VoyageActivity::with('bunker', 'aux1', 'aux2', 'aux3', 'boiler')->find($id);
            return $voyageActivity;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Voyage Activity Not Found !');
        }
    }

    /**
     * show voyage activity by date
     *
     * @param string $date
     * @return object voyage object
     */
    public function showByDate($date, $voyageID)
    {

        try {
            $query1 = VoyageActivity::with('shipCondition')->with('shipPosition')->with('etaPortTo')->with('etdPortTo');
            $voyageActivity = $query1->where('dteCreatedAt', $date)->where('intVoyageID', $voyageID)->first();

            if (is_null($voyageActivity)) {
                $query1 = VoyageActivity::with('shipCondition')->with('shipPosition')->with('etaPortTo')->with('etdPortTo')->where('intVoyageID', $voyageID);
            } else {
                return $voyageActivity;
            }
            return $query1->orderby('intID', 'desc')->first();
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Voyage Activity Not Found !');
        }
    }


    public function getVoyageActivityByDate($date, $voyageID)
    {

        // try {
        $voyageActivity = VoyageActivity::where('dteCreatedAt', $date)
            ->where('intVoyageID', $voyageID)
            ->first();
        return $voyageActivity;
        // } catch (\Exception $e) {
        //     throw new \Exception('Sorry, Voyage Activity Not Found !');
        // }
    }

    /**
     * update voyage by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated voyage object
     */
    public function update(Request $request, $id)
    {
        $intEmployeeId = 1;
        $voyageActivity = VoyageActivity::find($id);

        try {
            VoyageActivity::where('intID', $id)
                ->update([
                    'intShipPositionID' => $request->intShipPositionID ? $request->intShipPositionID : $voyageActivity->intShipPositionID,
                    'intShipConditionTypeID' => $request->intShipConditionTypeID ? $request->intShipConditionTypeID : $voyageActivity->intShipConditionTypeID,
                    // 'dteCreatedAt'=> $request->dteCreatedAt,
                    'decLatitude' => $request->decLatitude ? $request->decLatitude : $voyageActivity->decLatitude,
                    'decLongitude' => $request->decLongitude ? $request->decLongitude : $voyageActivity->decLongitude,
                    'intCourse' => $request->intCourse ? $request->intCourse : $voyageActivity->intCourse,
                    'timeSeaStreaming' => $request->timeSeaStreaming ? $request->timeSeaStreaming : $voyageActivity->timeSeaStreaming,
                    'timeSeaStoppage' => $request->timeSeaStoppage ? $request->timeSeaStoppage : $voyageActivity->timeSeaStoppage,
                    'decSeaDistance' => $request->decSeaDistance ? $request->decSeaDistance : $voyageActivity->decSeaDistance,
                    'decSeaDailyAvgSpeed' => $request->decSeaDailyAvgSpeed ? $request->decSeaDailyAvgSpeed : $voyageActivity->decSeaDailyAvgSpeed,
                    'decSeaGenAvgSpeed' => $request->decSeaGenAvgSpeed ? $request->decSeaGenAvgSpeed : $voyageActivity->decSeaGenAvgSpeed,
                    'strSeaDirection' => $request->strSeaDirection ? $request->strSeaDirection : $voyageActivity->strSeaDirection,
                    'strSeaState' => $request->strSeaState ? $request->strSeaState : $voyageActivity->strSeaState,
                    'strWindDirection' => $request->strWindDirection ? $request->strWindDirection : $voyageActivity->strWindDirection,
                    'decWindBF' => $request->decWindBF ? $request->decWindBF : $voyageActivity->decWindBF,
                    'intETAPortToID' => $request->intETAPortToID ? $request->intETAPortToID : $voyageActivity->intETAPortToID,
                    'strETAPortToName' => $request->strETAPortToName ? $request->strETAPortToName : $voyageActivity->strETAPortToName,
                    'strETADateTime' => $request->strETADateTime ? $request->strETADateTime : $voyageActivity->strETADateTime,
                    'intETDPortToID' => $request->intETDPortToID ? $request->intETDPortToID : $voyageActivity->intETDPortToID,
                    'strETDPortToName' => $request->strETDPortToName ? $request->strETDPortToName : $voyageActivity->strETDPortToName,
                    'strETDDateTime' => $request->strETDDateTime ? $request->strETDDateTime : $voyageActivity->strETDDateTime,
                    'strRemarks' => $request->strRemarks ? $request->strRemarks : $voyageActivity->strRemarks,
                    'intVoyagePortID' => $request->intVoyagePortID ? $request->intVoyagePortID : $voyageActivity->intVoyagePortID,
                    'decTimePortWorking' => $request->decTimePortWorking ? $request->decTimePortWorking : $voyageActivity->decTimePortWorking,
                    'strPortDirection' => $request->strPortDirection ? $request->strPortDirection : $voyageActivity->strPortDirection,
                    'strPortDSS' => $request->strPortDSS ? $request->strPortDSS : $voyageActivity->strPortDSS,
                    'decCargoTobeLD' => $request->decCargoTobeLD ? $request->decCargoTobeLD : $voyageActivity->decCargoTobeLD,
                    'decCargoPrevLD' => $request->decCargoPrevLD ? $request->decCargoPrevLD : $voyageActivity->decCargoPrevLD,
                    'decCargoDailyLD' => $request->decCargoDailyLD ? $request->decCargoDailyLD : $voyageActivity->decCargoDailyLD,
                    'decCargoTTLLD' => $request->decCargoTTLLD ? $request->decCargoTTLLD : $voyageActivity->decCargoTTLLD,
                    'decCargoBalanceCGO' => $request->decCargoBalanceCGO ? $request->decCargoBalanceCGO : $voyageActivity->decCargoBalanceCGO,
                    'decProduction' => $request->decProduction ? $request->decProduction : $voyageActivity->decProduction,
                    'decConsumption' => $request->decConsumption ? $request->decConsumption : $voyageActivity->decConsumption,
                    'decSeaTemp' => $request->decSeaTemp ? $request->decSeaTemp : $voyageActivity->decSeaTemp,
                    'decAirTemp' => $request->decAirTemp ? $request->decAirTemp : $voyageActivity->decAirTemp,
                    'decBaroPressure' => $request->decBaroPressure ? $request->decBaroPressure : $voyageActivity->decBaroPressure,
                    'decTotalDistance' => $request->decTotalDistance ? $request->decTotalDistance : $voyageActivity->decTotalDistance,
                    'decDistanceToGo' => $request->decDistanceToGo ? $request->decDistanceToGo : $voyageActivity->decDistanceToGo,
                    'synced' => 0
                ]);
            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function voyageActivitySeaDistenceCalculation($intVoyageID)
    {

        $voyageActivityCalculation = VoyageActivity::select(
            DB::raw('intVoyageID,SUM(decSeaDistance) as seaDistance,SUM(decSeaDailyAvgSpeed) as SeaDailyAvgSpeed,SUM(decSeaGenAvgSpeed) as SeaGenAvgSpeed,SUM(CAST(timeSeaStreaming as float)) as timestream')
        )
            ->where('intVoyageID', $intVoyageID)
            ->groupBy('intVoyageID')
            ->first();
        if (!is_null($voyageActivityCalculation)) {
        }
        return  $voyageActivityCalculation;
    }
}
