<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\ASLLHR\Repositories\ASLLHRAdditionDeductionRepository;

class ASLLHRAdditionDeductionController extends Controller
{

    public $asllhrAdditionDeductionRepository;
    public $responseRepository;


    public function __construct(ASLLHRAdditionDeductionRepository $asllhrAdditionDeductionRepository, ResponseRepository $rp)
    {
        $this->asllhrAdditionDeductionRepository = $asllhrAdditionDeductionRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/additionDeductionListByEmployee",
     *     tags={"ASLLHR"},
     *     summary="Get Employee Addition/Deduction List by Employee",
     *     description="Get Employee Addition/Deduction List by Employee",
     *      @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, example=281, in="query", @OA\Schema(type="integer")),
     *      operationId="additionDeductionListByEmployee",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Employee Addition/Deduction List by Employee"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function additionDeductionListByEmployee(Request $request)
    {
        try {
            $data = $this->asllhrAdditionDeductionRepository->additionDeductionListByEmployee($request->intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Addition/Deduction List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getTransactionType",
     *     tags={"ASLLHR"},
     *     summary="Get Transaction Type List",
     *     description="Get Transaction Type List",
     *      operationId="getTransactionType",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Transaction Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getTransactionType()
    {
        try {
            $data = $this->asllhrAdditionDeductionRepository->getTransactionType();
            return $this->responseRepository->ResponseSuccess($data, 'Employee Addition/Deduction List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/createAdditionDeduction",
     *     tags={"ASLLHR"},
     *     summary="Create New createAdditionDeduction",
     *     description="Create New createAdditionDeduction",
     *          @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *          @OA\Parameter( name="decTotal", description="decTotal, eg; 1", required=false, in="query", @OA\Schema(type="float")),
     *          @OA\Parameter( name="currencyId", description="currencyId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *          @OA\Parameter( name="strCurrencyName", description="strCurrencyName, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *         @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="additionDeductionMultiple",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intAdditionDeductionTypeId", type="integer", example=1),
     *                              @OA\Property(property="strAdditionDeductionTypeName", type="string", example="Night Allowence"),
     *                              @OA\Property(property="amount", type="float", example=3000),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=2)
     *                          ),
     *                      ),
     *              )
     *      ),
     *     operationId="createAdditionDeduction ",
     *      @OA\Response( response=200, description="Create New createAdditionDeduction" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createAdditionDeduction(Request $request)
    {

        $requisitionIssue = $this->asllhrAdditionDeductionRepository->createAdditionDeduction($request->all());

        try {
            $data = $requisitionIssue;
            return $this->responseRepository->ResponseSuccess($data, 'Addition Deduction Submitted Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/asllhr/deleteAdditionDetailsData",
     *     tags={"ASLLHR"},
     *     summary="Delete Addition Detail Data",
     *     description="Delete Addition Detail Data",
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      operationId="deleteAdditionDetailsData",
     *      @OA\Response(response=200,description="Delete Addition Detail Data"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteAdditionDetailsData(Request $request)
    {
        $deletedData = $this->asllhrAdditionDeductionRepository->deleteAdditionDetailsData($request->intID);
        try {
            $data = $deletedData;
            return $this->responseRepository->ResponseSuccess($data, 'Addition Deduction Deleted Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/updateAdditionDetailsData",
     *     tags={"ASLLHR"},
     *     summary="Delete Addition Detail Data",
     *     description="Delete Addition Detail Data",
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="amount", description="amount, eg; 100", required=true, in="query", @OA\Schema(type="integer")),
     *      operationId="updateAdditionDetailsData",
     *      @OA\Response(response=200,description="Delete Addition Detail Data"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateAdditionDetailsData(Request $request)
    {
        $updatedData = $this->asllhrAdditionDeductionRepository->updateAdditionDetailsData($request->intID, $request->amount);
        try {
            return $this->responseRepository->ResponseSuccess($updatedData, 'Data Updated Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
