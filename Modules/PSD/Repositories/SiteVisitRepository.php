<?php

namespace Modules\PSD\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\PSD\Entities\SiteVisit;

class SiteVisitRepository
{
    public function getSiteVisit()
    {
        try {
            $siteVisit = SiteVisit::where('ysnActive', 1)
            ->orderBy('intID', 'desc')
            ->get();
            return $siteVisit;
        }   catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new Site Visit to Site Visit
     *
     * @param Request $request
     * @return object Site Visit object which is created
     */
    public function siteVisitStore(Request $request)
    {
        $intEmployeeId = 1;
        try {

            $siteVisit = SiteVisit::create([
                'intUnitId'=>$request->intUnitId,
                'strActivityDate'=>$request->strActivityDate,
                'intActivityTypeId'=>$request->intActivityTypeId,
                'strActivityTypeName'=>$request->strActivityTypeName,
                'strNextFollowUpdate'=>$request->strNextFollowUpdate,
                'strOwnerName'=>$request->strOwnerName,
                'strAddress'=>$request->strAddress,
                'strMobileNumber'=>$request->strMobileNumber,
                'intConstructionTypeId'=>$request->intConstructionTypeId,
                'strConstructionTypeName'=>$request->strConstructionTypeName,
                'intFeedbackTypeId'=>$request->intFeedbackTypeId,
                'strFeedbackTypeName'=>$request->strFeedbackTypeName,
                'decApproxConsumption'=> (float) $request->decApproxConsumption,
                'decStepsRecomended'=> (float) $request->decStepsRecomended,
                'strNextFollowUpdate'=>$request->strNextFollowUpdate,
                'dteCreatedAt'=>Carbon::now(),
                'intCreatedBy'=> $request->intCreatedBy,
            ]);
            DB::commit();
            return $siteVisit;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * update Site Visit by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated Site Visit object
     */
    public function siteVisitUpdate(Request $request, $id)
    {
        try {
            SiteVisit::where('intID', $id)
            ->update([
                'intUnitId'=>$request->intUnitId,
                'strActivityDate'=>$request->strActivityDate,
                'intActivityTypeId'=>$request->intActivityTypeId,
                'strActivityTypeName'=>$request->strActivityTypeName,
                'strNextFollowUpdate'=>$request->strNextFollowUpdate,
                'strOwnerName'=>$request->strOwnerName,
                'strAddress'=>$request->strAddress,
                'strMobileNumber'=>$request->strMobileNumber,
                'intConstructionTypeId'=>$request->intConstructionTypeId,
                'strConstructionTypeName'=>$request->strConstructionTypeName,
                'intFeedbackTypeId'=>$request->intFeedbackTypeId,
                'strFeedbackTypeName'=>$request->strFeedbackTypeName,
                'decApproxConsumption'=> (float) $request->decApproxConsumption,
                'decStepsRecomended'=> (float) $request->decStepsRecomended,
                'strNextFollowUpdate'=>$request->strNextFollowUpdate,
                'dteCreatedAt'=>Carbon::now(),
                'intCreatedBy'=> $request->intCreatedBy,
            ]);
            return $this->show($id);
    }   catch (\Exception $e) {
        return false;
    }
}

    /**
     * show Site Visit boiler by id
     *
     * @param integer $id
     * @return object Site Visit boiler object
     */
    public function show($id)
    {
        try {
            $siteVisit = SiteVisit::find($id);
            return $siteVisit;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Site Visit Not Found !');
        }
    }

    /**
     * delete eng Or Consultant by id
     *
     * @param integer $id
     * @return object Deleted eng Or Consultant Object
     */
    public function siteVisitDelete($id)
    {
        try {
            $siteVisit = $this->show($id);
            $siteVisit->delete();
            return $siteVisit;
        } catch (\Exception $e) {
            return false;
        }
    }

}
