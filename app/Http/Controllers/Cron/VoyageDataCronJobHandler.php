<?php

namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use Modules\Asll\Entities\Voyage;
use Modules\Asll\Entities\VoyageActivity;

class VoyageDataCronJobHandler
{
    public $iAppHost = "iapps.akij.net";
    public $localHost = "127.0.0.1";
    public $shipHost = "192.168.150.3:8080";
    public $companyHost = "172.17.17.30:8080";

    public $dbiApp = 'DB_ASLL_SQL';
    public $dbLocalhost = 'DB_ASLL_SQL';
    public $dbCompanyHost = 'DB_ASLL_COMPANY';
    public $dbShipHost = 'DB_ASLL_MYSQL';

    public $currentHost;
    public $getServerHost;
    public $sendServerHost;


    public function __construct()
    {
        $this->currentHost = request()->getHttpHost();
        // if($this->currentHost === $this->shipHost){
        //     $this->getServerHost = $companyHost;
        // }
    }


    public static function doVoyageCronJob(Request $request)
    {
       try {
            $message = "Sync Status ==> \n";
            $models = [
                'Modules\Asll\Entities\Voyage',
                'Modules\Asll\Entities\VoyageActivity',
                'Modules\Asll\Entities\VoyageActivityBoiler',
                'Modules\Asll\Entities\VoyageActivityBoilerMain',
                'Modules\Asll\Entities\VoyageActivityEngine',
                'Modules\Asll\Entities\VoyageActivityExhtEngine',
                'Modules\Asll\Entities\VoyageActivityGasNChemicalMain',
                'Modules\Asll\Entities\VoyageGasNChemical',
                'Modules\Asll\Entities\VoyageActivityVlsf',
            ];
            foreach ($models as $model) {
                $modalSynced = $this->syncModels($model, $request);
                $message .= $modalSynced ? "$model Synced. \n" : "$model Not Synced.\n";
            }
            return $message;
       } catch (\Exception $e) {
            return false;
       }
    }

    /**
     * Sync Models Data based on different hosting
     *
     * @param String $modelName
     * @param Request $request
     * @return void
     */
    public function syncModels($modelName, $request)
    {
        try {
            $modelsData = $modelName::where('synced', false)->get();
            foreach ($modelsData as $modelData) {
                $newModel = new $modelName();
                $this->setDBConnections($newModel); // Update Model on Another Server
                $matchCriteria = ['intID' => $modelData->intID];
                $newModel->updateOrCreate($matchCriteria, $modelData->toArray());
                $modelData->synced = 1; // Update Sync in this server
                $modelData->update();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setDBConnections($newModel)
    {
        if($this->currentHost === $this->iAppHost || $this->currentHost === $this->localHost){
            $newModel->setConnection($this->dbShipHost);
        }

        if($this->currentHost === $this->shipHost){
            $newModel->setConnection($this->dbCompanyHost);
        }

        if($this->currentHost === $this->companyHost){
            $newModel->setConnection($this->dbiApp);
        }
    }

    /**
     * Sync All Voyage Data
     *
     * @param Request $request
     * @return void
     */
    public function syncVoyages($request)
    {
        try {
            $voyges = Voyage::where('synced', false)->get();

            // Loop throw the voyages
            foreach ($voyges as $voyage) {
                // Update Voyages on MySQL Server Too
                $newModel = new Voyage();
                if($this->currentHost === $this->iAppHost || $this->currentHost === $this->localHost){
                    $newModel->setConnection('DB_ASLL_MYSQL');
                }else{
                    $newModel->setConnection('DB_ASLL_SQL');
                }
                $matchCriteria = ['intID'=>$voyage->intID];
                $newModel->updateOrCreate($matchCriteria, $voyage->toArray());
                $voyage->synced = 1;
                $voyage->update();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Sync All Voyage Activity Data
     *
     * @param Request $request
     * @return void
     */
    public function syncVoyageActivities($request)
    {
         try {
            $voyageActivities = VoyageActivity::where('synced', false)->get();

            // Loop throw the voyages
            foreach ($voyageActivities as $activity) {
                // Update Voyages on MySQL Server Too
                $newModel = new VoyageActivity();
                if($request->getHttpHost() === 'iapps.akij.net' || $request->getHttpHost() === '127.0.0.1:8000'){
                    $newModel->setConnection('DB_ASLL_MYSQL');
                }else{
                    $newModel->setConnection('DB_ASLL_SQL');
                }
                $matchCriteria = ['intID'=>$activity->intID];
                $newModel->updateOrCreate($matchCriteria, $activity->toArray());
                $activity->synced = 1;
                $activity->update();
            }
            return true;
         } catch (\Exception $e) {
             return false;
         }
    }

}
