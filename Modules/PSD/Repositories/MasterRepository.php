<?php

namespace Modules\PSD\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\PSD\Entities\ConstructionType;
use Modules\PSD\Entities\ActivityType;
use Modules\PSD\Entities\ComplaintProblemType;
use Modules\PSD\Entities\ComplaintSolvedType;
use Modules\PSD\Entities\ComplaintForwardedType;
use Modules\PSD\Entities\FeedBackType;
use Modules\PSD\Entities\PromotionProgramType;

class MasterRepository
{
    public function getConstruction()
    {

        try {
            $constructionType = ConstructionType::select(
                'intConstructionTypeId',
                'strConstructionTypeName'
            )->get();
            return $constructionType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getActivity()
    {

        try {
            $activityType = ActivityType::select(
                'intActivityTypeId',
                'strActivityTypeName',
            )->get();
            return $activityType;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function getFeedBack()
    {

        try {
            $feedBackType = FeedBackType::select(
                'intFeedbackTypeId',
                'strFeedBackTypeName',
            )->get();
            return $feedBackType;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function getComplaintProblemType()
    {

        try {
            $complaintProblemType = ComplaintProblemType::select(
                'intProblemTypeId',
                'strProblemTypeName'
            )->get();
            return $complaintProblemType;
        } catch (\Exception $e) {
            return false;
        }
    }

    // public function getComplaintSolvedType()
    // {

    //     try {
    //         $complaintSolvedType = ComplaintSolvedType::select(
    //             'intID',
    //             'strComplaintSolvedTypeName'
    //         )->get();
    //         return $complaintSolvedType;
    //     } catch (\Exception $e) {
    //         return false;
    //     }
    // }

    // public function getComplaintForwardedType()
    // {

    //     try {
    //         $complaintForwardedType = ComplaintForwardedType::select(
    //             'intID',
    //             'strComplaintForwardedTypeName'
    //         )->get();
    //         return $complaintForwardedType;
    //     } catch (\Exception $e) {
    //         return false;
    //     }
    // }

    public function getProgramType()
    {

        try {
            $programType = PromotionProgramType::where('intProgramTypeId',432)->get();
            return $programType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function programTypeStore(array $data)
    {
        try {
            $programType = PromotionProgramType::create([
                'strProgramTypeName'=> $data['strProgramTypeName'],
                'dteCreatedAt'=> Carbon::now()->format('h/m/s'),
                'ysnActive'=> $data['ysnActive'],
            ]);
            return $programType;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function show($id)
    {
        try {
            $ProgramType = PromotionProgramType::find($id);
            return $ProgramType;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Program Type Not Found !');
        }
    }

    public function programTypeUpdate(array $data, $id)
    {
        try {
            $programType = PromotionProgramType::where('intProgramTypeId', $id)
            ->update([
                'strProgramTypeName'=>$data['strProgramTypeName'],
                'ysnActive'=>$data['ysnActive'],
                'dteCreatedAt'=>Carbon::now()
            ]);
            return $programType;
    }
    catch (\Exception $e) {
        return false;
    }
    }

    public function programTypeDelete($intProgramTypeId)
    {
        // try {
            // return (int) $id;
            $programTypeDelete = PromotionProgramType::find($intProgramTypeId);
            // return $programTypeDelete;
            $programTypeDelete->delete();
            return $programTypeDelete;
        // } catch (\Exception $e) {
        //     return false;
        // }
    }

}
