<?php

namespace Modules\VoyageLighter\Http\Controllers;


use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\VoyageLighter\Repositories\VoyageLighterRepository;

class VoyageLighterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct(VoyageLighterRepository $voyageLighterRepository, ResponseRepository $rp)
    {
        $this->voyageLighterRepository = $voyageLighterRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getVoyageLighter",
     *      tags={"Voyage Lighter"},
     *      summary="Get Voyage Lighter List",
     *      description="Get Voyage Lighter List",
     *      operationId="getVoyageLighter",
     *      @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Voyage Lighter List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getVoyageLighter(Request $request)
    {
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;
        try {
            $data = $this->voyageLighterRepository->getVoyageLighter($dteStartDate, $dteEndDate);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Lighter List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getVoyageLighterDetails/{intVoyageLighterId}",
     *      tags={"Voyage Lighter"},
     *      summary="Get Lighter Voyage Detail",
     *      description="Get Lighter Voyage Detail",
     *      operationId="getVoyageLighterDetails",
     *      @OA\Parameter( name="intVoyageLighterId", description="intVoyageLighterId, eg; 1", example=1, required=false, in="path", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Lighter Voyage Detail"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVoyageLighterDetails(Request $request)
    {
        $intVoyageLighterId = $request->intVoyageLighterId;
        try {
            $data = $this->voyageLighterRepository->getVoyageLighterDetails($intVoyageLighterId);
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Voyage Details');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLighterStatus",
     *      tags={"Voyage Lighter"},
     *      summary="Get Lighter Status List",
     *      description="Get Lighter Status List",
     *      operationId="getLighterStatus",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Lighter Status List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLighterStatus(Request $request)
    {
        try {
            $data = $this->voyageLighterRepository->getLighterStatus();
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Status List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getVoyageLighterVesselId",
     *      tags={"Voyage Lighter"},
     *      summary="Get Voyage Lighter List",
     *      description="Get Voyage Lighter List",
     *      operationId="getVoyageLighterVesselId",
     *      @OA\Parameter( name="intVesselId", description="intVesselId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Voyage Lighter List By vessel Id"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVoyageLighterVesselId(Request $request)
    {
        try {
            $data = $this->voyageLighterRepository->getVoyageLighterVesselId($request->intVesselId);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Lighter List By Vessel Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLighter",
     *      tags={"Voyage Lighter"},
     *      summary="Get Lighter List",
     *      description="Get Lighter List",
     *      operationId="getLighter",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Lighter List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLighter()
    {
        try {
            $data = $this->voyageLighterRepository->getLighter();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Lighter List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getItemType",
     *      tags={"Voyage Lighter"},
     *      summary="Get Item List",
     *      description="Get Item List",
     *      operationId="getItemType",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Item List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getItemType()
    {
        try {
            $data = $this->voyageLighterRepository->getItemType();
            return $this->responseRepository->ResponseSuccess($data, 'Item List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLoadingPointType",
     *      tags={"Voyage Lighter"},
     *      summary="Get Loading Point List",
     *      description="Get Loading Point List",
     *      operationId="getLoadingPointType",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Loading Point List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLoadingPointType()
    {
        try {
            $data = $this->voyageLighterRepository->getLoadingPointType();
            return $this->responseRepository->ResponseSuccess($data, 'Loading Point List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/voyageLighter/voyageLighterStore",
     *     tags={"Voyage Lighter"},
     *     summary="Create Voyage Lighter Lighter",
     *     description="Create Voyage Lighter Lighter",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="dteDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="intLoadingPointId", type="integer", example=1),
     *              @OA\Property(property="strLoadingPointName", type="string", example="Kutubdia"),
     *              @OA\Property(property="intLighterId", type="integer", example=1),
     *              @OA\Property(property="strLighterName", type="string" , example="Akij Lighter"),
     *              @OA\Property(property="strCode", type="string" , example="20"),
     *              @OA\Property(property="intLighterVoyageNo", type="integer" , example=1),
     *              @OA\Property(property="intMasterId", type="integer", example=1),
     *              @OA\Property(property="strMasterName", type="string", example="Farid"),
     *              @OA\Property(property="strUnloadStartDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="strUnloadCompleteDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="intDriverId", type="integer", example=1),
     *              @OA\Property(property="strDriverName", type="string", example="Farid Uddin"),
     *              @OA\Property(property="strComments", type="text", example="Comments"),
     *              @OA\Property(property="ysnActive", type="integer", example=1),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(
     *              property="voyageLighters",
     *              type="array",
     *              @OA\Items(
     *                        @OA\Property(property="intItemId", type="integer", example=1),
     *                        @OA\Property(property="strItemName", type="string", example="Oxygen"),
     *                        @OA\Property(property="intQuantity", type="integer", example=1),
     *                        @OA\Property(property="intVesselId", type="integer", example=1),
     *                        @OA\Property(property="strVesselName", type="string", example="Noor"),
     *                        @OA\Property(property="dteETAVessel", type="string", example="2020-11-24"),
     *                        @OA\Property(property="intVoyageId", type="integer", example=1),
     *                        @OA\Property(property="intVoyageNo", type="integer", example=1),
     *                        @OA\Property(property="strLCNo", type="string", example="1"),
     *                        @OA\Property(property="intBoatNoteQty", type="integer", example=1),
     *                        @OA\Property(property="intSurveyNo", type="integer", example=1),
     *                        @OA\Property(property="intSurveyQty", type="integer", example=1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="voyageLighterStore",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Voyage Lighter"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function voyageLighterStore(Request $request)
    {
        try {
            $data = $this->voyageLighterRepository->voyageLighterStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Lighter Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\PUT(
     *      path="/api/v1/voyageLighter/voyageLighterUpdate",
     *      tags={"Voyage Lighter"},
     *      summary="Update Voyage Lighter Lighter",
     *      description="Update Voyage Lighter Lighter",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="dteDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="intLoadingPointId", type="integer", example=1),
     *              @OA\Property(property="strLoadingPointName", type="string", example="Kutubdia"),
     *              @OA\Property(property="intLighterId", type="integer", example=1),
     *              @OA\Property(property="strLighterName", type="string" , example="Akij Lighter"),
     *              @OA\Property(property="strCode", type="string" , example="20"),
     *              @OA\Property(property="intLighterVoyageNo", type="integer" , example=1),
     *              @OA\Property(property="intMasterId", type="integer", example=1),
     *              @OA\Property(property="strMasterName", type="string", example="Farid"),
     *              @OA\Property(property="strUnloadStartDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="strUnloadCompleteDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="intDriverId", type="integer", example=1),
     *              @OA\Property(property="strDriverName", type="string", example="Farid Uddin"),
     *              @OA\Property(property="strComments", type="text", example="Comments"),
     *              @OA\Property(property="ysnActive", type="integer", example=1),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(
     *              property="voyageLighters",
     *              type="array",
     *              @OA\Items(
     *                        @OA\Property(property="intItemId", type="integer", example=1),
     *                        @OA\Property(property="strItemName", type="string", example="Oxygen"),
     *                        @OA\Property(property="intQuantity", type="integer", example=1),
     *                        @OA\Property(property="intVesselId", type="integer", example=1),
     *                        @OA\Property(property="strVesselName", type="string", example="Noor"),
     *                        @OA\Property(property="dteETAVessel", type="string", example="2020-11-24"),
     *                        @OA\Property(property="intVoyageId", type="integer", example=1),
     *                        @OA\Property(property="intVoyageNo", type="integer", example=1),
     *                        @OA\Property(property="strLCNo", type="string", example="1"),
     *                        @OA\Property(property="intBoatNoteQty", type="integer", example=1),
     *                        @OA\Property(property="intSurveyNo", type="integer", example=1),
     *                        @OA\Property(property="intSurveyQty", type="integer", example=1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="voyageLighterUpdate",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Expense"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function voyageLighterUpdate(Request $request)
    {
        try {
            $data = $this->voyageLighterRepository->voyageLighterUpdate($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Expense Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('voyagelighter::show');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/GetVoyageExistenceStatus",
     *      tags={"Voyage Lighter"},
     *      summary="Get Trip Count List",
     *      description="Get Trip Count List",
     *      operationId="GetVoyageExistenceStatus",
     *      @OA\Parameter( name="intTripID", description="intTripID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Trip Count List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetVoyageExistenceStatus(Request $request)
    {

        $intTripID = $request->intTripID;


        try {
            $data = $this->voyageLighterRepository->GetVoyageExistenceStatus($intTripID);
            return $this->responseRepository->ResponseSuccess($data, 'Get Trip Count List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getEmployeeList",
     *      tags={"Voyage Lighter"},
     *      summary="Get Employee List",
     *      description="Get Employee List",
     *      operationId="getEmployeeList",
     *      @OA\Parameter( name="intEmployeeType", description="intEmployeeType, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Employee List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeList(Request $request)
    {
        $intEmployeeType = $request->intEmployeeType;

        try {
            $data = $this->voyageLighterRepository->getEmployeeList($intEmployeeType);
            return $this->responseRepository->ResponseSuccess($data, 'Employee List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getEmployeeListByLighterId",
     *      tags={"Voyage Lighter"},
     *      summary="Get Employee List By Lighter Id",
     *      description="Get Employee List By Lighter Id",
     *      operationId="getEmployeeListByLighterId",
     *      @OA\Parameter( name="intLighterId", description="intLighterId, eg; 5", required=false, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Employee List By Lighter Id"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeListByLighterId(Request $request)
    {
        $intLighterId = $request->intLighterId;

        try {
            $data = $this->voyageLighterRepository->getEmployeeListByLighterId($intLighterId);
            return $this->responseRepository->ResponseSuccess($data, 'Employee List By Lighter Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *      path="/api/v1/voyageLighter/lighterEmployeeUpdate",
     *      tags={"Voyage Lighter"},
     *      summary="Update Lighter Employee",
     *      description="Update Lighter Employee",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intLighterEmployeeId", type="integer", example=1272),
     *              @OA\Property(property="strLighterEmployeeName", type="string", example="Kamal"),
     *              @OA\Property(property="intEmployeeType", type="integer", example=1),
     *              @OA\Property(property="intLighterId", type="integer", example=5),
     *              @OA\Property(property="strLighterName", type="string" , example="Akij Lighter"),
     *              @OA\Property(property="intUpdatedBy", type="integer", example=1272),
     *              )
     *      ),
     *      operationId="lighterEmployeeUpdate",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Lighter Employee"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function lighterEmployeeUpdate(Request $request)
    {
        try {
            $data = $this->voyageLighterRepository->lighterEmployeeUpdate($request, $request->intLighterEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Employee Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
