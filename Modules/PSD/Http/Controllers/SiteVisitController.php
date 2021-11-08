<?php

namespace Modules\PSD\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PSD\Repositories\SiteVisitRepository;
use Modules\PSD\Http\Requests\PSD\SiteVisitCreateRequest;

class SiteVisitController extends Controller
{
    public $siteVisitRepository;
    public $responseRepository;


    public function __construct(SiteVisitRepository $siteVisitRepository, ResponseRepository $rp)
    {
        $this->siteVisitRepository = $siteVisitRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/siteVisit/indexSiteVisit",
     *     tags={"PSD"},
     *     summary="Get Site Visit List",
     *     description="Get Site Visit List",
     *      operationId="indexSiteVisit",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Site Visit List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexSiteVisit()
    {
        try {
            $data = $this->siteVisitRepository->getSiteVisit();
            return $this->responseRepository->ResponseSuccess($data, 'Eng Or Consultant List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/psd/siteVisit/siteVisitStore",
     *     tags={"PSD"},
     *     summary="Create site Visit successful",
     *     description="Create site Visit successful",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="strActivityDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="strOwnerName", type="string", example="Name"),
     *              @OA\Property(property="strAddress", type="string", example="Address"),
     *              @OA\Property(property="intActivityTypeId", type="integer", example=2),
     *              @OA\Property(property="strActivityTypeName", type="string", example="Activity"),
     *              @OA\Property(property="strMobileNumber", type="string", example="MobileNo"),
     *              @OA\Property(property="intConstructionTypeId", type="integer", example=2),
     *              @OA\Property(property="strConstructionTypeName", type="string", example="akij"),
     *              @OA\Property(property="intFeedbackTypeId", type="integer", example=2),
     *              @OA\Property(property="strFeedbackTypeName", type="string", example="akij"),
     *              @OA\Property(property="decStepsRecomended", type="integer", example=2),
     *              @OA\Property(property="decApproxConsumption", type="integer", example=2),
     *              @OA\Property(property="strNextFollowUpdate", type="string", example="Steps"),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18 13:23:44"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *           )
     *      ),
     *      operationId="siteVisitStore",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create siteVisit successful"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function siteVisitStore(Request $request)
    {
        try {
            $data = $this->siteVisitRepository->siteVisitStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Creat siteVisit successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\PUT(
     *     path="/api/v1/psd/siteVisit/siteVisitUpdate",
     *     tags={"PSD"},
     *     summary="Update Site Visit",
     *     description="Update Site Visit",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intID", type="integer", example=43),
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="strActivityDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="strOwnerName", type="string", example="Name"),
     *              @OA\Property(property="strAddress", type="string", example="Address"),
     *              @OA\Property(property="intActivityTypeId", type="integer", example=2),
     *              @OA\Property(property="strActivityTypeName", type="string", example="Activity"),
     *              @OA\Property(property="strMobileNumber", type="string", example="MobileNo"),
     *              @OA\Property(property="intConstructionTypeId", type="integer", example=2),
     *              @OA\Property(property="strConstructionTypeName", type="string", example="akij"),
     *              @OA\Property(property="intFeedbackTypeId", type="integer", example=2),
     *              @OA\Property(property="strFeedbackTypeName", type="string", example="akij"),
     *              @OA\Property(property="decStepsRecomended", type="integer", example=2),
     *              @OA\Property(property="decApproxConsumption", type="integer", example=2),
     *              @OA\Property(property="strNextFollowUpdate", type="string", example="Steps"),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18 13:23:44"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              )
     *      ),
     *      operationId="siteVisitUpdate",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Site Visit"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function siteVisitUpdate(Request $request)
    {
        try {
            $data = $this->siteVisitRepository->siteVisitUpdate($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Site Visit Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *      path="/api/v1/psd/siteVisit/siteVisitDelete/{id}",
     *      tags={"PSD"},
     *      summary="Delete Site Visit",
     *      description="Delete Site Visit",
     *      operationId="siteVisitDelete",
     *     security={{"bearer": {}}},
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Delete Site Visit"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function siteVisitDelete($id)
    {
        try {
            $data = $this->siteVisitRepository->siteVisitDelete($id);
            return $this->responseRepository->ResponseSuccess($data, 'Site Visit Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
