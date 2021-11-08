<?php

namespace Modules\PSD\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PSD\Repositories\EngConsultantRepository;
use Modules\PSD\Http\Requests\PSD\EngConsultantCreateRequest;
use Modules\PSD\Http\Requests\PSD\EngConsultantUpdateRequest;

class EngConsultantController extends Controller
{
    public $engConsultantRepository;
    public $responseRepository;


    public function __construct(EngConsultantRepository $engConsultantRepository, ResponseRepository $rp)
    {
        $this->engConsultantRepository = $engConsultantRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/engConsultant/indexEngConsultant",
     *     tags={"PSD"},
     *     summary="Get Eng Or Consultant List",
     *     description="Get Eng Or Consultant List",
     *      operationId="indexEngConsultant",
     *      @OA\Parameter(name="intCreatedBy", description="intCreatedBy, eg; 1", required=false, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Eng Or Consultant List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexEngConsultant(Request $request)
    {
        try {
            $data = $this->engConsultantRepository->getEngOrConsultant($request->intCreatedBy);
            return $this->responseRepository->ResponseSuccess($data, 'Eng Or Consultant List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/psd/engConsultant/engConsultantStore",
     *     tags={"PSD"},
     *     summary="Create Engineer Or Consultant",
     *     description="Create Engineer Or Consultant",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="strActivityDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="strEngConsultantName", type="string", example="Name"),
     *              @OA\Property(property="intEngConsultantId", type="integer", example=2),
     *              @OA\Property(property="strAddress", type="string", example="Address"),
     *              @OA\Property(property="strMobileNumber", type="string", example="MobileNo"),
     *              @OA\Property(property="strEmail", type="string", example="MobileNo@akij.net"),
     *              @OA\Property(property="strFarmInstOfficeName", type="string", example="AKij House"),
     *              @OA\Property(property="intOngoingProject", type="integer", example=2),
     *              @OA\Property(property="intCoordinatedProject", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18 13:23:44"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *           )
     *      ),
     *      operationId="engConsultantStore",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Engineer Or Consultant"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function engConsultantStore(Request $request)
    {
        try {
            $data = $this->engConsultantRepository->engConsultantStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Engineer Or Consultant successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\PUT(
     *     path="/api/v1/psd/engConsultant/engConsultantUpdate",
     *     tags={"PSD"},
     *     summary="Update Engineer/Consultant",
     *     description="Update Engineer/Consultant",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="intID", type="integer", example=2),
     *              @OA\Property(property="strActivityDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="strEngConsultantName", type="string", example="Name"),
     *              @OA\Property(property="intEngConsultantId", type="integer", example=2),
     *              @OA\Property(property="strAddress", type="string", example="Address"),
     *              @OA\Property(property="strMobileNumber", type="string", example="MobileNo"),
     *              @OA\Property(property="strEmail", type="string", example="MobileNo@akij.net"),
     *              @OA\Property(property="strFarmInstOfficeName", type="string", example="AKij House"),
     *              @OA\Property(property="intOngoingProject", type="integer", example=2),
     *              @OA\Property(property="intCoordinatedProject", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18 13:23:44"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              )
     *      ),
     *      operationId="engConsultantUpdate",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Engineer/Consultant"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function engConsultantUpdate(Request $request)
    {
        try {
            $data = $this->engConsultantRepository->engConsultantUpdate($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Engineer/Consultant Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *      path="/api/v1/psd/engConsultant/engConsultantDelete/{id}",
     *      tags={"PSD"},
     *      summary="Delete Engineer Or Consultant Visit",
     *      description="Delete Engineer Or Consultant Visit",
     *      operationId="engConsultantDelete",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Delete Engineer Or Consultant Visit"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function engConsultantDelete($id)
    {
        try {
            $data = $this->engConsultantRepository->engConsultantDelete($id);
            return $this->responseRepository->ResponseSuccess($data, 'Engineer Or Consultant Visit Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
