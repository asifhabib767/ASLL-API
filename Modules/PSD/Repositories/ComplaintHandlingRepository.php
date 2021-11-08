<?php

namespace Modules\PSD\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\PSD\Entities\ComplaintHandling;

class ComplaintHandlingRepository
{
    public function getComplaintHandling()
    {
        try {
            $complaintHandling = ComplaintHandling::where('ysnActive', 1)
                ->orderBy('intID', 'desc')
                ->get();
            return $complaintHandling;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new ComplaintHandling to ComplaintHandling
     *
     * @param Request $request
     * @return object complain object which is created
     */
    public function complaintHandlingStore(Request $request)
    {
        try {
            $complaintHandling = ComplaintHandling::create([
                'intUnitId'=> $request->intUnitId,
                'strActivityDate'=>$request->strActivityDate,
                'intComplaineeId'=>$request->intComplaineeId,
                'strComplaineeName'=>$request->strComplaineeName,
                'strAddress'=>$request->strAddress,
                'strMobileNumber'=>$request->strMobileNumber,
                'intProblemTypeId'=>$request->intProblemTypeId,
                'strProblemTypeName'=>$request->strProblemTypeName,
                'strProblemTypeDetails'=>$request->strProblemTypeDetails,
                'strActionTaken'=>$request->strActionTaken,
                'intCreatedBy'=> $request->intCreatedBy,
                'ysnForwardedTo'=> $request->ysnForwardedTo,
                'ysnSolved'=> $request->ysnSolved,
                'dteCreatedAt'=>Carbon::now()
            ]);
            DB::commit();
            return $complaintHandling;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * update complin by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated voyage object
     */
    public function complaintHandlingUpdate(Request $request, $id)
    {

        try {
           ComplaintHandling::where('intID', $id)
            ->update([
                'intUnitId'=> $request->intUnitId,
                // 'intID'=> $request->intID,
                'strActivityDate'=>$request->strActivityDate,
                'intComplaineeId'=>$request->intComplaineeId,
                'strComplaineeName'=>$request->strComplaineeName,
                'strAddress'=>$request->strAddress,
                'strMobileNumber'=>$request->strMobileNumber,
                'intProblemTypeId'=>$request->intProblemTypeId,
                'strProblemTypeName'=>$request->strProblemTypeName,
                'strProblemTypeDetails'=>$request->strProblemTypeDetails,
                'strActionTaken'=>$request->strActionTaken,
                'intCreatedBy'=> $request->intCreatedBy,
                'ysnForwardedTo'=> $request->ysnForwardedTo,
                'ysnSolved'=> $request->ysnSolved,
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
            $complaintHandling = ComplaintHandling::find($id);
            return $complaintHandling;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Complaint Handling Not Found !');
        }
    }

    /**
     * delete complaint Handling by id
     *
     * @param integer $id
     * @return object Deleted complaint Handling Object
     */
    public function complaintHandlingDelete($id)
    {
        try {
            $complaintHandling = $this->show($id);
            $complaintHandling->delete();
            return $complaintHandling;
        }   catch (\Exception $e) {
            return false;
        }
    }

}
