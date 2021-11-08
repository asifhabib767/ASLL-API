<?php

namespace Modules\PSD\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PSD\Http\Requests\PSD\PromotionProgramCreateRequest;
use Modules\PSD\Http\Requests\PSD\PromotionProgramUpdateRequest;
use Modules\PSD\Repositories\PromotionProgramRepository;



class PromotionProgramController extends Controller
{
    public $promotionProgramRepository;
    public $responseRepository;


    public function __construct(PromotionProgramRepository $promotionProgramRepository, ResponseRepository $rp)
    {
        $this->promotionProgramRepository = $promotionProgramRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *      path="/api/v1/psd/promotionProgram/indexPromotionProgram",
     *      tags={"PSD"},
     *      summary="Get Promotion Program List",
     *      description="Get Promotion Program List",
     *      operationId="indexPromotionProgram",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Promotion Program List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexPromotionProgram()
    {
        try {
            $data = $this->promotionProgramRepository->getPromotionProgramDetails();
            return $this->responseRepository->ResponseSuccess($data, "Promotion Program List");
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/psd/promotionProgram/promotionProgramStore",
     *     tags={"PSD"},
     *     summary="Create Promotion Program Activity",
     *     description="Create Promotion Program Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=17),
     *              @OA\Property(property="intProgramTypeId", type="integer", example=1),
     *              @OA\Property(property="strProgramTypeName", type="string", example="Program"),
     *              @OA\Property(property="strProgramDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="strVenueName", type="string", example="Venue"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18"),
     *              @OA\Property(
     *                      property="programlists",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intProgramMainId", type="integer", example=1),
     *                              @OA\Property(property="strParticipantName", type="string", example="Akash"),
     *                              @OA\Property(property="strMobileNumber", type="string", example="01714653696"),
     *                              @OA\Property(property="strAddress", type="string", example="Mohakhali"),
     *                              @OA\Property(property="intParticipantId", type="integer", example=1),
     *                              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="promotionProgramStore",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Promotion Program"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function promotionProgramStore(Request $request)
    {
        try {
            $data = $this->promotionProgramRepository->storepromotionProgram($request);
            return $this->responseRepository->ResponseSuccess($data, 'Promotion Program Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/psd/promotionProgram/promotionProgramUpdate",
     *     tags={"PSD"},
     *     summary="Update Promtion Program",
     *     description="Update Promtion Program",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=17),
     *              @OA\Property(property="intProgramTypeId", type="integer", example=1),
     *              @OA\Property(property="strProgramTypeName", type="string", example="Program"),
     *              @OA\Property(property="strProgramDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="strVenueName", type="string", example="Venue"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18"),
     *              @OA\Property(
     *                      property="programlists",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intProgramMainId", type="integer", example=1),
     *                              @OA\Property(property="strParticipantName", type="string", example="Akash"),
     *                              @OA\Property(property="strMobileNumber", type="string", example="01714653696"),
     *                              @OA\Property(property="strAddress", type="string", example="Mohakhali"),
     *                              @OA\Property(property="intParticipantId", type="integer", example=1),
     *                              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="promotionProgramUpdate",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Promtion Program"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function promotionProgramUpdate(Request $request)
    {
        try {
            $data = $this->promotionProgramRepository->updatePromotionProgram($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Promtion Program Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *      path="/api/v1/psd/promotionProgram/promotionProgramDelete/{id}",
     *      tags={"PSD"},
     *      summary="Delete Promotion Program",
     *      description="Delete Promotion Program",
     *      operationId="promotionProgramDelete",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Delete Promotion Program"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function promotionProgramDelete($id)
    {
        try {
            $data = $this->promotionProgramRepository->promotionProgramDelete($id);
            return $this->responseRepository->ResponseSuccess($data, 'Promotion Program has been Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
