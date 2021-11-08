<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLEmployeePromotionRepository;

class ASLLHREmployeePromotionController extends Controller
{


    public $aSLLEmployeePromotionRepository;
    public $responseRepository;


    public function __construct(ASLLEmployeePromotionRepository $aSLLEmployeePromotionRepository, ResponseRepository $rp)
    {
        $this->aSLLEmployeePromotionRepository = $aSLLEmployeePromotionRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/promotion/addEmployeePromotion",
     *     tags={"ASLL Promotion"},
     *     summary="Add addEmployeePromotion",
     *     description="Add addEmployeePromotion",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intEmployeeID", type="integer", example=11),
     *                 @OA\Property(property="monPromotedSalary", type="integer", example=200),
     *                 @OA\Property(property="intPromotedDesignationID", type="integer", example=1),
     *                 @OA\Property(property="dteEffectiveFromDate", type="string", example="2020-10-28 12:00:00"),
     *                 @OA\Property(property="intInsertBy", type="integer", example=439590),
     *              )
     *           ),
     *      operationId="addEmployeePromotion",
     *      @OA\Response( response=200, description="Add addEmployeePromotion" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function addEmployeePromotion(Request $request)
    {
        try {
            $request->validate([
                'intInsertBy' => 'required',
                'intEmployeeID' => 'required',
                'monPromotedSalary' => 'required',
                'intPromotedDesignationID' => 'required',
                'dteEffectiveFromDate' => 'required'
            ]);

            $data = $this->aSLLEmployeePromotionRepository->addEmployeePromotion($request);
            return $this->responseRepository->ResponseSuccess($data, 'Promotion Added Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/promotion/getEmployeePromotionList",
     *     tags={"ASLL Promotion"},
     *     summary="Get Employee Promotion List By Employee",
     *     description="Get Employee Promotion List By Employee",
     *      operationId="getEmployeePromotionList",
     *      @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", example="11", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Get Employee Promotion List By Employee"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeePromotionList(Request $request)
    {
        try {
            $data = $this->aSLLEmployeePromotionRepository->getEmployeePromotionList($request->intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Promotion List By Employee ID');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/promotion/updateEmployeePromotion",
     *     tags={"ASLL Promotion"},
     *     summary="Add updateEmployeePromotion",
     *     description="Add updateEmployeePromotion",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intID", type="integer", example=11),
     *                 @OA\Property(property="monPromotedSalary", type="integer", example=200),
     *                 @OA\Property(property="intPromotedDesignationID", type="integer", example=1),
     *                 @OA\Property(property="dteEffectiveFromDate", type="string", example="2020-10-28 12:00:00"),
     *              )
     *           ),
     *      operationId="updateEmployeePromotion",
     *      @OA\Response( response=200, description="Add updateEmployeePromotion" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function updateEmployeePromotion(Request $request)
    {
        try {
            $request->validate([
                'intID' => 'required',
                'monPromotedSalary' => 'required',
                'intPromotedDesignationID' => 'required',
                'dteEffectiveFromDate' => 'required'
            ]);

            $data = $this->aSLLEmployeePromotionRepository->updateEmployeePromotion($request);
            return $this->responseRepository->ResponseSuccess($data, 'Promotion Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\DELETE(
     *     path="/api/v1/asllhr/promotion/deleteEmployeePromotion",
     *     tags={"ASLL Promotion"},
     *     summary="Delete Promotion Data",
     *     description="Delete Promotion Data",
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      operationId="deleteEmployeePromotion",
     *      @OA\Response(response=200,description="Delete Promotion Data"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteEmployeePromotion(Request $request)
    {
        try {
            $data = $this->aSLLEmployeePromotionRepository->deleteEmployeePromotion($request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Promotion Data Deleted !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
