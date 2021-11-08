<?php

namespace Modules\PSD\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\PSD\Entities\EngOrConsultant;

class EngConsultantRepository
{
    public function getEngOrConsultant($intCreatedBy=null)
    {
        try {
            if(is_null($intCreatedBy)){
                $engOrConsultant = EngOrConsultant::where('ysnActive', 1)->orderBy('intID', 'desc')
                ->get();
            }else{
                $engOrConsultant = EngOrConsultant::where('ysnActive', 1)->where('intCreatedBy', $intCreatedBy)->get();
            }

            return $engOrConsultant;
        }   catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new EngOrConsultant to EngOrConsultant
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function engConsultantStore(Request $request)
    {
        try {
            $engOrConsultant = EngOrConsultant::create([
                'intUnitId'=> $request->intUnitId,
                'strActivityDate'=>$request->strActivityDate,
                'intEngConsultantId'=>$request->intEngConsultantId,
                'strEngConsultantName'=>$request->strEngConsultantName,
                'strAddress'=>$request->strAddress,
                'strMobileNumber'=>$request->strMobileNumber,
                'strEmail'=>$request->strEmail,
                'strFarmInstOfficeName'=>$request->strFarmInstOfficeName,
                'intOngoingProject'=>$request->intOngoingProject,
                'intCoordinatedProject'=>$request->intCoordinatedProject,
                'intCreatedBy'=> $request->intCreatedBy,
                'dteCreatedAt'=>Carbon::now()
            ]);
            // DB::commit();
            return $engOrConsultant;
        } catch (\Exception $e) {
            // DB::rollback();
            return false;
        }
    }

    /**
     * update EngOrConsultant by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated EngOrConsultant object
     */
    public function engConsultantUpdate(Request $request, $id)
    {
        try {
           EngOrConsultant::where('intID', $id)
            ->update([
                // 'intID'=>$request->intID,
                'strActivityDate'=>$request->strActivityDate,
                'intEngConsultantId'=>$request->intEngConsultantId,
                'strEngConsultantName'=>$request->strEngConsultantName,
                'strAddress'=>$request->strAddress,
                'strMobileNumber'=>$request->strMobileNumber,
                'strEmail'=>$request->strEmail,
                'strFarmInstOfficeName'=>$request->strFarmInstOfficeName,
                'intOngoingProject'=>$request->intOngoingProject,
                'intCoordinatedProject'=>$request->intCoordinatedProject,
                'dteCreatedAt'=>Carbon::now()
            ]);
        return $this->show($id);
    } catch (\Exception $e) {
        return false;
    }
    }

    /**
     * show voyege activity boiler by id
     *
     * @param integer $id
     * @return object voyage activity boiler object
     */
    public function show($id)
    {
        try {
            $engOrConsultant = EngOrConsultant::find($id);
            return $engOrConsultant;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, EngOrConsultant Not Found !');
        }
    }

    /**
     * delete eng Or Consultant by id
     *
     * @param integer $id
     * @return object Deleted eng Or Consultant Object
     */
    public function engConsultantDelete($id)
    {
        try {
            $engOrConsultant = $this->show($id);
            $engOrConsultant->delete();
            return $engOrConsultant;
        } catch (\Exception $e) {
            return false;
        }
    }

}
