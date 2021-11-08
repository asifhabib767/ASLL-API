<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\ResponseRepository;
use Modules\Supplier\Repositories\SupplierRepository;
use Illuminate\Http\Response;

class SupplierController extends Controller
{
    public $supplierRepository;
    public $responseRepository;

    public function __construct(SupplierRepository  $supplierRepository, ResponseRepository $rp)
    {
        $this->supplierRepository = $supplierRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/supplier/getSupplierList",
     *     tags={"Supplier"},
     *     summary="getSupplierList",
     *     description="getSupplierList",
     *     operationId="getSupplierList",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strName", description="strName, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSupplierList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSupplierList(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $strName = $request->strName;

        // return  $strName;
        try {
            $data = $this->supplierRepository->getSupplierList($intUnitId, $strName);
            return $this->responseRepository->ResponseSuccess($data, 'Supplier List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/supplier/getSupplierListForBridgeToTerritory",
     *     tags={"Supplier"},
     *     summary="getSupplierListForBridgeToTerritory",
     *     description="getSupplierListForBridgeToTerritory",
     *     operationId="getSupplierListForBridgeToTerritory",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSupplierListForBridgeToTerritory"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSupplierListForBridgeToTerritory(Request $request)
    {
        $intUnitId = $request->intUnitId;


        // return  $strName;
        try {
            $data = $this->supplierRepository->getSupplierListForBridgeToTerritory($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Supplier List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/supplier/getVehicleAcceptStatus",
     *     tags={"Supplier"},
     *     summary="getVehicleAcceptStatus",
     *     description="getVehicleAcceptStatus",
     *     operationId="getVehicleAcceptStatus",
     *     @OA\Parameter( name="ysnConfirmed", description="ysnConfirmed, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="fromdate", description="fromdate, eg; 2020-10-01", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="todate", description="todate, eg; 2020-10-03", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getVehicleAcceptStatus"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVehicleAcceptStatus(Request $request)
    {
        // $ysnAcceptstatus, $fromdate, $todate
        $ysnConfirmed = $request->ysnConfirmed;
        $fromdate = $request->fromdate;
        $todate = $request->todate;


        // return  $strName;
        try {
            $data = $this->supplierRepository->getVehicleAcceptStatus($ysnConfirmed, $fromdate, $todate);
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle Accept Status');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/supplier/getPoMrrInvoiceStatus",
     *     tags={"Supplier"},
     *     summary="getPoMrrInvoiceStatus",
     *     description="getPoMrrInvoiceStatus",
     *     operationId="getPoMrrInvoiceStatus",
     *     @OA\Parameter( name="intunit", description="intunit, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intSupplier", description="intSupplier, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="fromdate", description="fromdate, eg; 2020-10-01", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="todate", description="todate, eg; 2020-10-03", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPoMrrInvoiceStatus"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPoMrrInvoiceStatus(Request $request)
    {
        // $ysnAcceptstatus, $fromdate, $todate
        $intunit = $request->intunit;
        $intSupplierID = $request->intSupplier;
        $fromdate = $request->fromdate;
        $todate = $request->todate;


        // return  $strName;
        try {
            $data = $this->supplierRepository->getPoMrrInvoiceStatus($intunit, $intSupplierID, $fromdate, $todate);
            return $this->responseRepository->ResponseSuccess($data, 'Supplier Balance Status');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/supplier/getSupplierBalance",
     *     tags={"Supplier"},
     *     summary="getSupplierBalance",
     *     description="getSupplierBalance",
     *     operationId="getSupplierBalance",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intSupplier", description="intSupplier, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSupplierBalance"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSupplierBalance(Request $request)
    {
        // $ysnAcceptstatus, $fromdate, $todate
        $intUnitID = $request->intUnitID;
        $intSupplier = $request->intSupplier;


        // return  $strName;
        try {
            $data = $this->supplierRepository->getSupplierBalance($intUnitID, $intSupplier);
            return $this->responseRepository->ResponseSuccess($data, 'Supplier Balance Status');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/supplier/getUnitForSupplier",
     *     tags={"Supplier"},
     *     summary="getUnitForSupplier",
     *     description="getUnitForSupplier",
     *     operationId="getUnitForSupplier",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intSuppMasterID", description="intSuppMasterID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getUnitForSupplier"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getUnitForSupplier(Request $request)
    {
        // $ysnAcceptstatus, $fromdate, $todate
        $intSuppMasterID = $request->intSuppMasterID;



        // return  $strName;
        try {
            $data = $this->supplierRepository->getUnitForSupplier($intSuppMasterID);
            return $this->responseRepository->ResponseSuccess($data, 'Supplier vs Unit List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
