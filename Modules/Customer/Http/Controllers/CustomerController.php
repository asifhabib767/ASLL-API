<?php

namespace Modules\Customer\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Customer\Repositories\CustomerRepository;

class CustomerController extends Controller
{

    public $customerRepository;
    public $responseRepository;

    public function __construct(CustomerRepository $customerRepository, ResponseRepository $rp)
    {
        $this->customerRepository = $customerRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/customer/getCustomerVsShopInfo",
     *     tags={"Customer"},
     *     summary="getCustomerVsShopInfo",
     *     description="getCustomerVsShopInfo",
     *     operationId="getCustomerVsShopInfo",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCustomerVsShopInfo"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerVsShopInfo(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $intCustomerId = $request->intCustomerId;

        // return  $intCustomerId;
        try {
            $data = $this->customerRepository->getCustomerVsShopInfo($intUnitId, $intCustomerId);
            return $this->responseRepository->ResponseSuccess($data, 'Customer vs Shop');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\GET(
     *     path="/api/v1/customer/getCustomerVsShopInfoByEmail",
     *     tags={"Customer"},
     *     summary="getCustomerVsShopInfoByEmail",
     *     description="getCustomerVsShopInfoByEmail",
     *     operationId="getCustomerVsShopInfoByEmail",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strEmailAddress", description="strEmailAddress, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCustomerVsShopInfoByEmail"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerVsShopInfoByEmail(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $strEmailAddress = $request->strEmailAddress;

        // return  $strEmailAddress;
        try {
            $data = $this->customerRepository->getCustomerVsShopInfoByEmail($intUnitId, $strEmailAddress);
            return $this->responseRepository->ResponseSuccess($data, 'Customer vs Shop');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


     /**
     * @OA\GET(
     *     path="/api/v1/customer/getCustomerVsShopInforLevel3",
     *     tags={"Customer"},
     *     summary="getCustomerVsShopInforLevel3",
     *     description="getCustomerVsShopInforLevel3",
     *     operationId="getCustomerVsShopInforLevel3",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strEmailAddress", description="strEmailAddress, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCustomerVsShopInforLevel3"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerVsShopInforLevel3(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $strEmailAddress = $request->strEmailAddress;

        // return  $strEmailAddress;
        try {
            $data = $this->customerRepository->getCustomerVsShopInforLevel3($intUnitId, $strEmailAddress);
            return $this->responseRepository->ResponseSuccess($data, 'Customer vs Shop');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/customer/getCustomerVsSalesOrder",
     *     tags={"Customer"},
     *     summary="getCustomerVsSalesOrder",
     *     description="getCustomerVsSalesOrder",
     *     operationId="getCustomerVsSalesOrder",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intSalesOffId", description="intSalesOffId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 1", required=true, in="query", @OA\Schema(type="string")),

     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCustomerVsSalesOrder"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerVsSalesOrder(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;
        $intCustomerId = $request->intCustomerId;
        $intSalesOffId = $request->intSalesOffId;


        // return  $intCustomerId;
        try {
            $data = $this->customerRepository->getCustomerVsSalesOrder($intUnitId, $dteStartDate, $dteEndDate, $intCustomerId, $intSalesOffId);
            return $this->responseRepository->ResponseSuccess($data, 'Customer vs Ship');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/customer/getUnitvsShopSearching",
     *     tags={"Customer"},
     *     summary="getUnitvsShopSearching",
     *     description="getUnitvsShopSearching",
     *     operationId="getUnitvsShopSearching",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 8", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strDisPointName", description="strDisPointName, eg; new hope", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getUnitvsShopSearching"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getUnitvsShopSearching(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $strDisPointName = $request->strDisPointName;

        // return  $intCustomerId;
        try {
            $data = $this->customerRepository->getUnitvsShopSearching($intUnitId, $strDisPointName);
            return $this->responseRepository->ResponseSuccess($data, 'Customer vs Ship');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/customer/getSalesOfficevsShopList",
     *     tags={"Customer"},
     *     summary="getSalesOfficevsShopList",
     *     description="getSalesOfficevsShopList",
     *     operationId="getSalesOfficevsShopList",
     *     @OA\Parameter( name="intSalesOffId", description="intSalesOffId, eg; 8", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSalesOfficevsShopList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSalesOfficevsShopList(Request $request)
    {
        $intSalesOffId = $request->intSalesOffId;

        // return  $intCustomerId;
        try {
            $data = $this->customerRepository->getSalesOfficevsShopList($intSalesOffId);
            return $this->responseRepository->ResponseSuccess($data, 'Customer vs Ship');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/customer/getShopListLocationUpdatestatus",
     *     tags={"Customer"},
     *     summary="getShopListLocationUpdatestatus",
     *     description="getShopListLocationUpdatestatus",
     *     operationId="getShopListLocationUpdatestatus",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strEmailAddress", description="strEmailAddress, eg; 4", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getShopListLocationUpdatestatus"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getShopListLocationUpdatestatus(Request $request)
    {
        $intUnitID = $request->intUnitID;
        $strEmailAddress = $request->strEmailAddress;

        // return   $intUnitID;
        try {
            $data = $this->customerRepository->getShopListLocationUpdatestatus($intUnitID, $strEmailAddress);
            return $this->responseRepository->ResponseSuccess($data, 'Territory vs Shop');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }










    /**
     * @OA\GET(
     *     path="/api/v1/customer/getShopListReportConfiguration",
     *     tags={"Customer"},
     *     summary="getShopListReportConfiguration",
     *     description="getShopListReportConfiguration",
     *     operationId="getShopListReportConfiguration",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getShopListReportConfiguration"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getShopListReportConfiguration(Request $request)
    {
        $intUnitID = $request->intUnitID;


        // return   $intUnitID;
        try {
            $data = $this->customerRepository->getShopListReportConfiguration($intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Territory vs Shop');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/customer/getCustomerPendingSalesOrderList",
     *     tags={"Customer"},
     *     summary="getCustomerPendingSalesOrderList",
     *     description="getCustomerPendingSalesOrderList",
     *     operationId="getCustomerPendingSalesOrderList",
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCustomerPendingSalesOrderList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerPendingSalesOrderList(Request $request)
    {
        $intCustomerId = $request->intCustomerId;


        // return   $intCustomerId;
        try {
            $data = $this->customerRepository->getCustomerPendingSalesOrderList($intCustomerId);
            return $this->responseRepository->ResponseSuccess($data, 'Customer pending List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/customer/getManpowerGeoLevel",
     *     tags={"Customer"},
     *     summary="getManpowerGeoLevel",
     *     description="getManpowerGeoLevel",
     *     operationId="getManpowerGeoLevel",
     *     @OA\Parameter( name="strEmailAddress", description="strEmailAddress, eg; 4", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getManpowerGeoLevel"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getManpowerGeoLevel(Request $request)
    {
        $strEmailAddress = $request->strEmailAddress;


        // return   $strEmailAddress;
        try {
            $data = $this->customerRepository->getManpowerGeoLevel($strEmailAddress);
            return $this->responseRepository->ResponseSuccess($data, 'Customer pending List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/customer/getSupportInformationForAPPSUser",
     *     tags={"Customer"},
     *     summary="getSupportInformationForAPPSUser",
     *     description="getSupportInformationForAPPSUser",
     *     operationId="getSupportInformationForAPPSUser",
     *     @OA\Parameter( name="intEnrol", description="intEnrol, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSupportInformationForAPPSUser"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSupportInformationForAPPSUser(Request $request)
    {
        $intEnrol = $request->intEnrol;


        // return   $intEnrol;
        try {
            $data = $this->customerRepository->getSupportInformationForAPPSUser($intEnrol);
            return $this->responseRepository->ResponseSuccess($data, 'Support information for apps user');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


     /**
     * @OA\GET(
     *     path="/api/v1/customer/getProductPriceByCustomer",
     *     tags={"Customer"},
     *     summary="getProductPriceByCustomer",
     *     description="getProductPriceByCustomer",
     *     operationId="getProductPriceByCustomer",
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 302447", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intProductId", description="intProductId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getProductPriceByCustomer"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getProductPriceByCustomer(Request $request)
    {
        $intCustomerId = $request->intCustomerId;
        $intProductId = $request->intProductId;

        // return   $intCustomerId;
        try {
            $data = $this->customerRepository->getProductPriceByCustomer($intCustomerId,$intProductId);
            return $this->responseRepository->ResponseSuccess($data, 'Customer pending List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

/**
     * @OA\GET(
     *     path="/api/v1/customer/getProductPriceByCustomerFunction",
     *     tags={"Customer"},
     *     summary="getProductPriceByCustomerFunction",
     *     description="getProductPriceByCustomerFunction",
     *     operationId="getProductPriceByCustomerFunction",
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 302447", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intProductId", description="intProductId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intSalesType", description="intSalesType, eg; 302447", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intPriceVar", description="intPriceVar, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUOM", description="intUOM, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intCurrency", description="intCurrency, eg; 302447", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteDate", description="dteDate, eg; 4", required=true, in="query", @OA\Schema(type="string")),


     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getProductPriceByCustomerFunction"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getProductPriceByCustomerFunction(Request $request)
    {
        $intCustomerId = $request->intCustomerId;
        $intProductId = $request->intProductId;
        $intSalesType = $request->intSalesType;
        $intPriceVar = $request->intPriceVar;
        $intUOM = $request->intUOM;

        $intCurrency = $request->intCurrency;
        $dteDate = $request->dteDate;



        // return   $intCustomerId;
        try {
            $data = $this->customerRepository->getProductPriceByCustomerFunction($intCustomerId,$intProductId,$intSalesType,$intPriceVar,$intUOM,$intCurrency,$dteDate);
            return $this->responseRepository->ResponseSuccess($data, 'Customer pending List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    /**
     * @OA\GET(
     *     path="/api/v1/customer/getCustomerStatement",
     *     tags={"Customer"},
     *     summary="getCustomerStatement",
     *     description="getCustomerStatement",
     *     operationId="getCustomerStatement",
     *     @OA\Parameter( name="fromDate", description="fromDate, eg; 2021-02-01", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="toDate", description="toDate, eg; 2021-03-01", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="customerId", description="customerId, eg; 302447", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="userID", description="userID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="unitID", description="unitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCustomerStatement"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerStatement(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $customerId = $request->customerId;
        $userID = $request->userID;
        $unitID = $request->unitID;



        // return   $intCustomerId;
        try {
            $data = $this->customerRepository->getCustomerStatement($fromDate,$toDate,$customerId,$userID,$unitID);
            return $this->responseRepository->ResponseSuccess($data, 'Customer Statement');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
