<?php

namespace Modules\PSD\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PSD\Repositories\ComplaintHandlingRepository;
use Modules\PSD\Http\Requests\PSD\ComplaintHandlingCreateRequest;
use Modules\PSD\Http\Requests\PSD\ComplaintHandlingUpdateRequest;

class ComplaintHandlingController extends Controller
{
    public $complaintHandlingRepository;
    public $responseRepository;


    public function __construct(ComplaintHandlingRepository $complaintHandlingRepository, ResponseRepository $rp)
    {
        $this->complaintHandlingRepository = $complaintHandlingRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/complaintHandling/indexComplaintHandling",
     *     tags={"PSD"},
     *     summary="Get Eng Or Consultant List",
     *     description="Get Eng Or Consultant List",
     *      operationId="indexComplaintHandling",
     *      @OA\Response(response=200,description="Get Eng Or Consultant List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexComplaintHandling()
    {
        try {
            $data = $this->complaintHandlingRepository->getComplaintHandling();
            return $this->responseRepository->ResponseSuccess($data, 'Eng Or Consultant List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/psd/complaintHandling/complaintHandlingStore",
     *     tags={"PSD"},
     *     summary="Create Complain Handling successful",
     *     description="Create Complaint Handling successful",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="strActivityDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="intComplaineeId", type="integer", example=2),
     *              @OA\Property(property="strComplaineeName", type="string", example="Name"),
     *              @OA\Property(property="strAddress", type="string", example="Address"),
     *              @OA\Property(property="strMobileNumber", type="string", example="MobileNo"),
     *              @OA\Property(property="intProblemTypeId", type="integer", example=2),
     *              @OA\Property(property="strProblemTypeName", type="string", example="akij"),
     *              @OA\Property(property="strProblemTypeDetails", type="string", example="Problem Details"),
     *              @OA\Property(property="strActionTaken", type="string", example="Taken"),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18 13:23:44"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(property="ysnSolved", type="boolean", example=0),
     *              @OA\Property(property="ysnForwardedTo", type="boolean", example=0),
     *           )
     *      ),
     *      operationId="ComplaintHandlingStore",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Complain Handling successful"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function complaintHandlingStore(Request $request)
    {
        try {
            $data = $this->complaintHandlingRepository->complaintHandlingStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Creat ComplaintHandling successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\PUT(
     *     path="/api/v1/psd/complaintHandling/complaintHandlingUpdate",
     *     tags={"PSD"},
     *     summary="Update complaint Handling",
     *     description="Update complaint Handling",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="intID", type="integer", example=7),
     *              @OA\Property(property="strActivityDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="intComplaineeId", type="integer", example=2),
     *              @OA\Property(property="strComplaineeName", type="string", example="Name"),
     *              @OA\Property(property="strAddress", type="string", example="Address"),
     *              @OA\Property(property="strMobileNumber", type="string", example="MobileNo"),
     *              @OA\Property(property="intProblemTypeId", type="integer", example=2),
     *              @OA\Property(property="strProblemTypeName", type="string", example="akij"),
     *              @OA\Property(property="strProblemTypeDetails", type="string", example="Problem Details"),
     *              @OA\Property(property="strActionTaken", type="string", example="Taken"),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18 13:23:44"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(property="ysnSolved", type="boolean", example=0),
     *              @OA\Property(property="ysnForwardedTo", type="boolean", example=0),
     *              )
     *      ),
     *      operationId="complaintHandlingUpdate",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update complain Handling"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function complaintHandlingUpdate(Request $request)
    {
        try {
            $data = $this->complaintHandlingRepository->complaintHandlingUpdate($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'complaint Handling Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *      path="/api/v1/psd/complaintHandling/complaintHandlingDelete/{id}",
     *      tags={"PSD"},
     *      summary="Delete Complaint Handling",
     *      description="Delete Complaint Handling",
     *      operationId="complaintHandlingDelete",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Delete Complaint Handling"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function complaintHandlingDelete($id)
    {
        try {
            $data = $this->complaintHandlingRepository->complaintHandlingDelete($id);
            return $this->responseRepository->ResponseSuccess($data, 'complaint Handling Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
