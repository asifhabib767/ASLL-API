<?php

namespace Modules\Accounts\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounts\Repositories\AccountRepository;

class AccountsController extends Controller
{

    public $accountRepository;
    public $responseRepository;

    public function __construct(AccountRepository $accountRepository, ResponseRepository $rp)
    {
        $this->accountRepository = $accountRepository;
        $this->responseRepository = $rp;
    }







    /**
     * @OA\GET(
     *     path="/api/v1/accounts/getOnlineBankListByUnitID",
     *     tags={"Online Bank"},
     *     summary="getOnlineBankListByUnitID",
     *     description="Item Types List",
     *     operationId="getOnlineBankListByUnitID",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getOnlineBankListByUnitID"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getOnlineBankListByUnitID(Request $request)
    {
        $intUnitID = $request->intUnitID;
        try {
            $data = $this->accountRepository->getOnlineBankListByUnitID($intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Online Bank List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/accounts/getOnlineDepositMode",
     *     tags={"Online Bank"},
     *     summary="getOnlineDepositMode",
     *     description="Item Types List",
     *     operationId="getOnlineDepositMode",
     
     *     @OA\Response(response=200,description="getOnlineDepositMode"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getOnlineDepositMode(Request $request)
    {

        try {
            $data = $this->accountRepository->getOnlineDepositMode();
            return $this->responseRepository->ResponseSuccess($data, 'Online Bank List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\POST(
     *     path="/api/v1/accounts/postDepositNItemInformationByApps",
     *     tags={"Deposit N Item Information By Apps"},
     *     summary="Create New DepositNItemInformationByApps",
     *     description="Create New DepositNItemInformationByApps",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intCustID", type="integer", example=1),
     *                 @OA\Property(property="intCOAID", type="integer", example=1),
     *                 @OA\Property(property="dteDepositDate", type="string", example="2020-09-09"),
     *                 @OA\Property(property="intUnitID", type="integer", example=4),
     *                 @OA\Property(property="intInsertBy", type="integer", example=1272),
     *                 @OA\Property(property="strNarration", type="string", example="NA"),
     *                 @OA\Property(
     *                      property="products",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intProductID", type="integer", example=761),
     *                              @OA\Property(property="strProductName", type="string", example="OPC"),
     *                              @OA\Property(property="monRate", type="integer", example=100),
     *                              @OA\Property(property="decQnt", type="integer", example=1)
     *                       )
     *                  ),
     *                 @OA\Property(
     *                      property="banks",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intBankID", type="integer", example=1),
     *                              @OA\Property(property="strBankName", type="string", example="IBBL"),
     *                              @OA\Property(property="intDepositModeTypeID", type="integer", example=1),
     *                              @OA\Property(property="strDepositModeTypeName", type="string", example="Check"),
     *                              @OA\Property(property="strBranch", type="string", example="Test"),
     *                              @OA\Property(property="strRTGSChequeNMtr", type="string", example="Test")
     *                       )
     *                  )
     *              )
     *           ),
     *      operationId="postDepositNItemInformationByApps",
     *      @OA\Response( response=200, description="Create New DepositNItemInformationByApps" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function postDepositNItemInformationByApps(Request $request)
    {
        try {
            $data = $this->accountRepository->postDepositNItemInformationByApps($request);
            return $this->responseRepository->ResponseSuccess($data, 'Store Data');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/accounts/getDepositInformationByCustomer",
     *     tags={"Online Bank"},
     *     summary="getDepositInformationByCustomer",
     *     description="Item Types List",
     *     operationId="getDepositInformationByCustomer",
     *     @OA\Parameter( name="intCustID", description="intCustID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getDepositInformationByCustomer"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDepositInformationByCustomer(Request $request)
    {
        $intCustID = $request->intCustID;

        try {
            $data = $this->accountRepository->getDepositInformationByCustomer($intCustID);
            return $this->responseRepository->ResponseSuccess($data, 'Online Bank List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
