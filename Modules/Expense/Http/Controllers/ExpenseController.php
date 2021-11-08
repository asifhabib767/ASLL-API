<?php

namespace Modules\Expense\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Expense\Repositories\ExpenseRepository;
use Modules\Expense\Http\Requests\Expense\EngConsultantCreateRequest;
use Modules\Expense\Http\Requests\Expense\EngConsultantUpdateRequest;

class ExpenseController extends Controller
{
    public $expenseRepository;
    public $responseRepository;


    public function __construct(ExpenseRepository $expenseRepository, ResponseRepository $rp)
    {
        $this->expenseRepository = $expenseRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/expense/getExpenseType",
     *     tags={"Expense"},
     *     summary="Get Expense Type List",
     *     description="Get Expense Type List",
     *      operationId="getExpenseType",
     *      @OA\Parameter(name="intExpenseCategoryId", description="intExpenseCategoryId, eg; 1", required=false,  in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Expense Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getExpenseType(Request $request)
    {
        // return $intExpenseCategoryId;
        try {
            $data = $this->expenseRepository->getExpenseType($request);
            return $this->responseRepository->ResponseSuccess($data, 'Expense Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\GET(
     *     path="/api/v1/expense/getExpense",
     *     tags={"Expense"},
     *     summary="Get Expense List",
     *     description="Get Expense List",
     *      operationId="getExpense",
     *     @OA\Parameter(name="intActionBy", description="intActionBy, eg; 1", example=1, required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Expense List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getExpense(Request $request)
    {
        try {
            $data = $this->expenseRepository->getExpense($request->intActionBy);
            return $this->responseRepository->ResponseSuccess($data, 'Expense List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/expense/getExpenseById",
     *     tags={"Expense"},
     *     summary="Get Expense List",
     *     description="Get Expense List",
     *      operationId="getExpenseById",
     *     @OA\Parameter(name="intExpenseId", description="intExpenseId, eg; 1", example=1, required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Expense List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getExpenseById(Request $request)
    {
        try {
            $data = $this->expenseRepository->getExpenseById($request->intExpenseId);
            return $this->responseRepository->ResponseSuccess($data, 'Expense List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }





    /**
     * @OA\GET(
     *     path="/api/v1/expense/getExpenseCategoryType",
     *     tags={"Expense"},
     *     summary="Get Expense Category Type List",
     *     description="Get Expense Category Type List",
     *      operationId="getExpenseCategoryType",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Expense Category Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getExpenseCategoryType(Request $request)
    {
        try {
            $data = $this->expenseRepository->getExpenseCategoryType($request);
            return $this->responseRepository->ResponseSuccess($data, 'Expense Category Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/expense/getReferenceType",
     *     tags={"Expense"},
     *     summary="Get Reference Type List",
     *     description="Get Reference Type List",
     *      operationId="getReferenceType",
     *     @OA\Parameter(name="intExpenseTypeId", description="intExpenseTypeId, eg; 422905", example=1, required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Expense Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getReferenceType(Request $request)
    {
        try {
            $data = $this->expenseRepository->getReferenceType($request);
            return $this->responseRepository->ResponseSuccess($data, 'Reference Type');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/expense/getReference",
     *     tags={"Expense"},
     *     summary="Get Reference List",
     *     description="Get Reference List",
     *      operationId="getReference",
    *       security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Reference List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getReference(Request $request)
    {
        try {
            $data = $this->expenseRepository->getReference($request);
            return $this->responseRepository->ResponseSuccess($data, 'Reference List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\GET(
     *     path="/api/v1/expense/getTransactionType",
     *     tags={"Expense"},
     *     summary="Get Transiction Type List",
     *     description="Get Transiction Type List",
     *      operationId="getTransactionType",
     *      @OA\Parameter(name="intExpenseTypeId", description="intExpenseTypeId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Transiction Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getTransactionType(Request $request)
    {
        try {
            $data = $this->expenseRepository->getTransactionType($request);
            return $this->responseRepository->ResponseSuccess($data, 'Transaction Type');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/expense/getTransaction",
     *     tags={"Expense"},
     *     summary="Get Transiction List",
     *     description="Get Transiction List",
     *      operationId="getTransaction",
      *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Transiction List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getTransaction(Request $request)
    {
        try {
            $data = $this->expenseRepository->getTransaction($request);
            return $this->responseRepository->ResponseSuccess($data, 'Transaction List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *      path="/api/v1/expense/storeExpense",
     *      tags={"Expense"},
     *      summary="Create New expense",
     *      description="Create New expense",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strExpenseCode", type="string", example="1"),
     *              @OA\Property(property="intBusinessUnitId", type="integer", example=1),
     *              @OA\Property(property="intBusinessUnitName", type="string", example="Shipping"),
     *              @OA\Property(property="intExpenseCategoryId", type="integer", example=1),
     *              @OA\Property(property="strExpenseCategoryName", type="string", example="Category"),
     *              @OA\Property(property="intSBUId", type="integer", example=1),
     *              @OA\Property(property="strSBUName", type="string", example="sub"),
     *              @OA\Property(property="intCountryId", type="integer", example=1),
     *              @OA\Property(property="strCountryName", type="string", example="Bangladesh"),
     *              @OA\Property(property="intCurrencyId", type="integer", example=1),
     *              @OA\Property(property="strCurrencyName", type="string", example="Taka"),
     *              @OA\Property(property="intExpenseForId", type="integer", example=1),
     *              @OA\Property(property="dteFromDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="dteToDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="intProjectId", type="integer", example=1),
     *              @OA\Property(property="strProjectName", type="string", example="Iapps"),
     *              @OA\Property(property="intCostCenterId", type="integer", example=1),
     *              @OA\Property(property="strCostCenterName", type="string", example="Akij House"),
     *              @OA\Property(property="intInstrumentId", type="integer", example=1),
     *              @OA\Property(property="strInstrumentName", type="string", example="Guiter"),
     *              @OA\Property(property="intDisbursementCenterId", type="integer", example=1),
     *              @OA\Property(property="strDisbursementCenterName", type="string", example="Akij House"),
     *              @OA\Property(property="strReferenceNo", type="string", example="1"),
     *              @OA\Property(property="numTotalAmount", type="integer", example=1),
     *              @OA\Property(property="numTotalApprovedAmount", type="integer", example=1),
     *              @OA\Property(property="numAdjustmentAmount", type="integer", example=1),
     *              @OA\Property(property="numPendingAmount", type="integer", example=1),
     *              @OA\Property(property="strComments", type="string", example="Comments"),
     *              @OA\Property(property="ysnComplete", type="boolean", example=0),
     *              @OA\Property(property="ysnActive", type="boolean", example=1),
     *              @OA\Property(property="intActionBy", type="integer", example=1),
     *              @OA\Property(property="dteLastActionDateTime", type="string", example="2020-10-18"),
     *              @OA\Property(property="dteServerDateTime", type="string", example="2020-10-18"),
     *              @OA\Property(
     *                      property="expenseRowLists",
     *                      type="array",
     *                      @OA\Items(
     *
     *                              @OA\Property(property="intExpenseId", type="integer", example=1),
     *                              @OA\Property(property="strExpenseCode", type="string", example="4576"),
     *                              @OA\Property(property="dteExpenseDate", type="string", example="2020-10-18"),
     *                              @OA\Property(property="intExpenseCategoryId", type="integer", example=1),
     *                              @OA\Property(property="strExpenseCategoryName", type="string", example="Category"),
     *                              @OA\Property(property="intExpenseTypeId", type="integer", example=1),
     *                              @OA\Property(property="strExpenseTypeName", type="string", example="Row"),
     *                              @OA\Property(property="intExpenseReferenceId", type="integer", example=1),
     *                              @OA\Property(property="strExpenseReferenceName", type="string", example="Akij"),
     *                              @OA\Property(property="strReferenceNo", type="string", example="1"),
     *                              @OA\Property(property="intTransactionTypeId", type="integer", example=1),
     *                              @OA\Property(property="intReferenceId", type="integer", example=null),
     *                              @OA\Property(property="strTransactionTypeName", type="string", example="1"),
     *                              @OA\Property(property="strComments", type="string", example="Comments"),
     *                              @OA\Property(property="numQuantity", type="integer", example=1),
     *                              @OA\Property(property="numRate", type="integer", example=1),
     *                              @OA\Property(property="numAmount", type="integer", example=1),
     *                              @OA\Property(property="strExpenseLocation", type="string", example="Dhaka"),
     *                              @OA\Property(property="strAttachmentLink", type="string", example="Link"),
     *                              @OA\Property(property="ysnComplete", type="boolean", example=0),
     *                              @OA\Property(property="ysnActive", type="integer", example=1),
     *                              @OA\Property(property="intActionBy", type="integer", example=1),
     *                              @OA\Property(property="dteLastActionDateTime", type="string", example="2020-10-18"),
     *                              @OA\Property(property="dteServerDateTime", type="string", example="2020-10-18"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="storeExpense",
      *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Multuple Expense"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeExpense(Request $request)
    {
        try {
            $data = $this->expenseRepository->storeExpense($request);
            return $this->responseRepository->ResponseSuccess($data, 'Expense Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\PUT(
     *      path="/api/v1/expense/updateExpense",
     *      tags={"Expense"},
     *      summary="Update expense",
     *      description="Update expense",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intExpenseId", type="integer", example=1),
     *              @OA\Property(property="strExpenseCode", type="string", example="1"),
     *              @OA\Property(property="intBusinessUnitId", type="integer", example=1),
     *              @OA\Property(property="intBusinessUnitName", type="string", example="Shipping"),
     *              @OA\Property(property="intExpenseCategoryId", type="integer", example=1),
     *              @OA\Property(property="strExpenseCategoryName", type="string", example="Category"),
     *              @OA\Property(property="intSBUId", type="integer", example=1),
     *              @OA\Property(property="strSBUName", type="string", example="sub"),
     *              @OA\Property(property="intCountryId", type="integer", example=1),
     *              @OA\Property(property="strCountryName", type="string", example="Bangladesh"),
     *              @OA\Property(property="intCurrencyId", type="integer", example=1),
     *              @OA\Property(property="strCurrencyName", type="string", example="Taka"),
     *              @OA\Property(property="intExpenseForId", type="integer", example=1),
     *              @OA\Property(property="dteFromDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="dteToDate", type="string", example="2020-10-18"),
     *              @OA\Property(property="intProjectId", type="integer", example=1),
     *              @OA\Property(property="strProjectName", type="string", example="Iapps"),
     *              @OA\Property(property="intCostCenterId", type="integer", example=1),
     *              @OA\Property(property="strCostCenterName", type="string", example="Akij House"),
     *              @OA\Property(property="intInstrumentId", type="integer", example=1),
     *              @OA\Property(property="strInstrumentName", type="string", example="Guiter"),
     *              @OA\Property(property="intDisbursementCenterId", type="integer", example=1),
     *              @OA\Property(property="strDisbursementCenterName", type="string", example="Akij House"),
     *              @OA\Property(property="strReferenceNo", type="string", example="1"),
     *              @OA\Property(property="numTotalAmount", type="integer", example=1),
     *              @OA\Property(property="numTotalApprovedAmount", type="integer", example=1),
     *              @OA\Property(property="numAdjustmentAmount", type="integer", example=1),
     *              @OA\Property(property="numPendingAmount", type="integer", example=1),
     *              @OA\Property(property="strComments", type="string", example="Comments"),
     *              @OA\Property(property="ysnComplete", type="boolean", example=0),
     *              @OA\Property(property="ysnActive", type="boolean", example=1),
     *              @OA\Property(property="intActionBy", type="integer", example=1),
     *              @OA\Property(property="dteLastActionDateTime", type="string", example="2020-10-18"),
     *              @OA\Property(property="dteServerDateTime", type="string", example="2020-10-18"),
     *              @OA\Property(
     *                      property="expenseRowLists",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intExpenseId", type="integer", example=1),
     *                              @OA\Property(property="intExpenseRowId", type="integer", example=1),
     *                              @OA\Property(property="strExpenseCode", type="string", example="4576"),
     *                              @OA\Property(property="dteExpenseDate", type="string", example="2020-10-18"),
     *                              @OA\Property(property="intExpenseCategoryId", type="integer", example=1),
     *                              @OA\Property(property="strExpenseCategoryName", type="string", example="Category"),
     *                              @OA\Property(property="intExpenseTypeId", type="integer", example=1),
     *                              @OA\Property(property="strExpenseTypeName", type="string", example="Row"),
     *                              @OA\Property(property="intExpenseReferenceId", type="integer", example=1),
     *                              @OA\Property(property="strExpenseReferenceName", type="string", example="Akij"),
     *                              @OA\Property(property="strReferenceNo", type="string", example="1"),
     *                              @OA\Property(property="intTransactionTypeId", type="integer", example=1),
     *                              @OA\Property(property="strTransactionTypeName", type="string", example="1"),
     *                              @OA\Property(property="strComments", type="string", example="Comments"),
     *                              @OA\Property(property="numQuantity", type="integer", example=1),
     *                              @OA\Property(property="numRate", type="integer", example=1),
     *                              @OA\Property(property="numAmount", type="integer", example=1),
     *                              @OA\Property(property="strExpenseLocation", type="string", example="Dhaka"),
     *                              @OA\Property(property="strAttachmentLink", type="string", example="Link"),
     *                              @OA\Property(property="ysnComplete", type="boolean", example=0),
     *                              @OA\Property(property="ysnActive", type="integer", example=1),
     *                              @OA\Property(property="intActionBy", type="integer", example=1),
     *                              @OA\Property(property="dteLastActionDateTime", type="string", example="2020-10-18"),
     *                              @OA\Property(property="dteServerDateTime", type="string", example="2020-10-18"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="updateExpense",
      *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Expense"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateExpense(Request $request)
    {
        try {
            $data = $this->expenseRepository->updateExpense($request, $request->intExpenseId);
            return $this->responseRepository->ResponseSuccess($data, 'Expense Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *      path="/api/v1/expense/deleteExpense/{id}",
     *      tags={"Expense"},
     *      summary="Delete expense",
     *      description="Delete expense",
     *      operationId="deleteExpense",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
      *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Delete Expense"),
     * )
     */

    public function deleteExpense($id)
    {
        try {
            $data = $this->expenseRepository->deleteExpense($id);
            return $this->responseRepository->ResponseSuccess($data, 'Expense Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/expense/getSupervisorAprvPending",
     *     tags={"Expense"},
     *     summary="Get Expense List",
     *     description="Get Expense List",
     *      operationId="getSupervisorAprvPending",
     *      @OA\Parameter(name="supervisorID", description="supervisorID, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
      *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Expense List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSupervisorAprvPending(Request $request)
    {
        try {
            $data = $this->expenseRepository->getSupervisorAprovePending($request->supervisorID);
            return $this->responseRepository->ResponseSuccess($data, 'Expense List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
