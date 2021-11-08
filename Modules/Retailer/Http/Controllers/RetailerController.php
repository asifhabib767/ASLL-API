<?php

namespace Modules\Retailer\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Retailer\Repositories\RetailerRepository;

class RetailerController extends Controller
{
    public $retailerRepository;
    public $responseRepository;


    public function __construct(RetailerRepository $retailerRepository, ResponseRepository $rp)
    {
        $this->retailerRepository = $retailerRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/retailer/getRetailerByUnitId",
     *     tags={"Retailer"},
     *     summary="Get Retailer List",
     *     description="Get Retailer List",
     *      operationId="getRetailerByUnitId",
     *      @OA\Parameter(name="intUnitId", description="intUnitId, eg; 4", example=4, required=false, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Retailer List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getRetailerByUnitId(Request $request)
    {
        try {
            $data = $this->retailerRepository->getRetailerByUnitId($request);
            return $this->responseRepository->ResponseSuccess($data, 'Retailer List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


        /**
     * @OA\GET(
     *     path="/api/v1/retailer/getRetailerByCustomer",
     *     tags={"Retailer"},
     *     summary="Get Retailer List By Customer",
     *     description="Get Retailer List By Customer",
     *      operationId="getRetailerByCustomer",
     *      @OA\Parameter(name="intCustomerId", description="intCustomerId, eg; 1", example=302447, required=false, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Retailer List By Customer"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getRetailerByCustomer(Request $request)
    {
        try {
            $data = $this->retailerRepository->getRetailerByCustomer($request);
            return $this->responseRepository->ResponseSuccess($data, 'Retailer List By Customer');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/retailer/storeRetailer",
     *     tags={"Retailer"},
     *     summary="Create Retailer List",
     *     description="Create Retailer List",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intDisPointId", type="integer", example=1),
     *              @OA\Property(property="intUnitId", type="integer", example=1),
     *              @OA\Property(property="strName", type="string", example="Name"),
     *              @OA\Property(property="strAddress", type="string", example="Address"),
     *              @OA\Property(property="strContactPerson", type="string", example="ContactPerson"),
     *              @OA\Property(property="strContactNo", type="string", example="ContactNo"),
     *              @OA\Property(property="intCustomerId", type="integer", example=1),
     *              @OA\Property(property="intPriceCatagory", type="integer", example=1),
     *              @OA\Property(property="intLogisticCatagory", type="integer", example=1),
     *              @OA\Property(property="ysnEnable", type="boolean", example=1),
     *              @OA\Property(property="intFuelRouteID", type="integer", example=1),
     *              @OA\Property(property="dteInsertionDate", type="string", example="2020-11-16"),
     *              @OA\Property(property="ysnLocationTag", type="boolean", example=1),
     *              @OA\Property(property="ysnImageTag", type="boolean", example=1),
     *              @OA\Property(property="decLatitude", type="decimal", example=1),
     *              @OA\Property(property="decLongitude", type="decimal", example=1),
     *              @OA\Property(property="intZAxis", type="integer", example=1),
     *              @OA\Property(property="strGoogleMapName", type="string", example="GoogleMap"),
     *              @OA\Property(property="dteUpdateAt", type="string", example="2020-11-16"),
     *           )
     *      ),
     *      operationId="storeRetailer",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Retailer List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function storeRetailer(Request $request)
    {
        try {
            $data = $this->retailerRepository->storeRetailer($request);
            return $this->responseRepository->ResponseSuccess($data, 'Reatiler Created successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/retailer/updateRetailer",
     *     tags={"Retailer"},
     *     summary="Update Retailer list",
     *     description="Update Retailer list",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intDisPointId", type="integer", example=1),
     *              @OA\Property(property="intUnitId", type="integer", example=1),
     *              @OA\Property(property="strName", type="string", example="Name"),
     *              @OA\Property(property="strAddress", type="string", example="Address"),
     *              @OA\Property(property="strContactPerson", type="string", example="ContactPerson"),
     *              @OA\Property(property="strContactNo", type="string", example="ContactNo"),
     *              @OA\Property(property="intCustomerId", type="integer", example=1),
     *              @OA\Property(property="intPriceCatagory", type="integer", example=1),
     *              @OA\Property(property="intLogisticCatagory", type="integer", example=1),
     *              @OA\Property(property="ysnEnable", type="boolean", example=1),
     *              @OA\Property(property="intFuelRouteID", type="integer", example=1),
     *              @OA\Property(property="dteInsertionDate", type="string", example="2020-11-16"),
     *              @OA\Property(property="ysnLocationTag", type="boolean", example=1),
     *              @OA\Property(property="ysnImageTag", type="boolean", example=1),
     *              @OA\Property(property="decLatitude", type="decimal", example=1),
     *              @OA\Property(property="decLongitude", type="decimal", example=1),
     *              @OA\Property(property="intZAxis", type="integer", example=1),
     *              @OA\Property(property="strGoogleMapName", type="string", example="GoogleMap"),
     *              @OA\Property(property="dteUpdateAt", type="string", example="2020-11-16"),
     *              )
     *      ),
     *      operationId="updateRetailer",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Retailer list"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function updateRetailer(Request $request)
    {
        try {
            $data = $this->retailerRepository->updateRetailer($request, $request->intDisPointId);
            return $this->responseRepository->ResponseSuccess($data, 'Retailer Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


        /**
     * @OA\DELETE(
     *      path="/api/v1/retailer/deleteRetailer/{id}",
     *      tags={"Retailer"},
     *      summary="Delete Retailer List",
     *      description="Delete Retailer List",
     *      operationId="deleteRetailer",
     *      @OA\Parameter( name="intDisPointId", description="intDisPointId, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Delete Retailer List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteRetailer($id)
    {
        try {
            $data = $this->retailerRepository->deleteRetailer($id);
            return $this->responseRepository->ResponseSuccess($data, 'Retailer List Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




}
