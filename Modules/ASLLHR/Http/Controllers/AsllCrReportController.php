<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;

use Modules\ASLLHR\Repositories\AsllCrReportRepository;

class AsllCrReportController extends Controller
{

    public $asllCrReportRepository;
    public $responseRepository;


    public function __construct(AsllCrReportRepository $asllCrReportRepository, ResponseRepository $rp)
    {
        $this->asllCrReportRepository = $asllCrReportRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/crReport/getCrReportCriteriaOption",
     *     tags={"CR Report"},
     *     summary="Get CR Report Option Data",
     *     description="Get CR Report Option Data",
     *     security={{"bearer": {}}},
     *      operationId="getCrReportCriteriaOption",
     *      @OA\Response(response=200,description="Get CR Report Option Data"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCrReportCriteriaOption()
    {

        try {
            $data = $this->asllCrReportRepository->getCrReportCriteriaOption();
            return $this->responseRepository->ResponseSuccess($data, 'Cr Criteria List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/crReport/getCrReportEmployeeInfoByEmployeeId",
     *     tags={"CR Report"},
     *     summary="Get CR Report Option Data",
     *     description="Get CR Report Option Data",
     *      @OA\Parameter( 
     *      name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, example=281, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      operationId="getCrReportEmployeeInfoByEmployeeId",
     *      @OA\Response(response=200,description="Get CR Report Option Data"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getCrReportEmployeeInfoByEmployeeId(Request $request)
    {

        try {
            $data = $this->asllCrReportRepository->getCrReportEmployeeInfoByEmployeeId($request->intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Cr Criteria List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('asllhr::create');
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/crReport/getCrReportList",
     *     tags={"CR Report"},
     *     summary="Get CR Report Option Data",
     *     description="Get CR Report Option Data",
     *     @OA\Parameter(name="isPaginated", description="isPaginated, eg; 0", required=false, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="paginateNo", description="paginateNo, eg; 0", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      operationId="getCrReportList",
     *      @OA\Response(response=200,description="Get CR Report Option Data"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getCrReportList()
    {

        try {
            $data = $this->asllCrReportRepository->getCrReportList();
            return $this->responseRepository->ResponseSuccess($data, 'Cr Report List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/crReport/getCrReportCriteriaOptionById",
     *     tags={"CR Report"},
     *     summary="Get CR Report Details",
     *     description="Get CR Report Option Data",
     *      @OA\Parameter( name="intCriteriaMainId", description="intCriteriaMainId, eg; 1", required=true, example=1, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      operationId="getCrReportCriteriaOptionById",
     *      @OA\Response(response=200,description="Get CR Report Details"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCrReportCriteriaOptionById(Request $request)
    {

        try {
            $data = $this->asllCrReportRepository->getCrReportCriteriaOptionById($request->intCriteriaMainId);
            return $this->responseRepository->ResponseSuccess($data, 'Cr Report List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *    path="/api/v1/asllhr/crReport/store",
     *     tags={"CR Report"},
     *     summary="Create New CR Report",
     *     description="Create New  CR Report",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intEmployeeId", type="integer", example=1),
     *                 @OA\Property(property="intRankId", type="integer", example=1),
     *                 @OA\Property(property="intVesselId", type="integer", example=1),
     *                 @OA\Property(property="dteFromDate", type="string", example="2020-09-09"),
     *                 @OA\Property(property="dteToDate", type="string", example="2020-09-09"),
     *                 @OA\Property(property="strReasonOfAppraisal", type="string", example="Crew sign off"),
     *                 @OA\Property(property="strOverallPerformance", type="string", example="Outstanding"),
     *                 @OA\Property(property="ysnPromotionRecomanded", type="boolean", example=1),
     *                 @OA\Property(property="ysnFurtherRecomanded", type="boolean", example=1),
     *                 @OA\Property(property="strPromotionRecomandedDate", type="string", example="2020-09-09"),
     *                 @OA\Property(property="strFurtherRecomandedDate", type="string", example="2020-09-09"),
     *                 @OA\Property(property="strMasterSign", type="string", example="Crew sign off"),
     *                 @OA\Property(property="strCESign", type="string", example="Crew sign off"),
     *                   @OA\Property(
     *                      property="options",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intOptionMainId", type="integer",example=1),
     *                              @OA\Property(property="intCriteriaMainId", type="integer",example=1),
     *                              @OA\Property(property="strOptionValue", type="string",example="Hello"),
     *                              @OA\Property(property="ysnIsChecked", type="boolean", example=1),
     *                       )
     *                  ),
     *              )
     *           ),
     *      operationId="store",
     *      @OA\Response( response=200, description="Create New CR Report" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function store(Request $request)
    {

        try {
            $data = $this->asllCrReportRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Cr Report Save');
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
        return view('asllhr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('asllhr::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
     *     path="/api/v1/asllhr/crReport/getCrReportDetails",
     *     tags={"CR Report"},
     *     summary="Get CR Report Details",
     *     description="Get CR Report Option Data",
     *      @OA\Parameter( name="intCrReportId", description="intCrReportId, eg; HY1UEpmc3c9PSIsInZhbHVlIjoiU1", required=true, example="HY1UEpmc3c9PSIsInZhbHVlIjoiU1", in="query", @OA\Schema(type="string")),
     *      security={{"bearer": {}}},
     *      operationId="getCrReportDetails",
     *      @OA\Response(response=200,description="Get CR Report Details"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCrReportDetails(Request $request)
    {
        $decryptedId = Crypt::decrypt($request->intCrReportId);
        try {
            $data = $this->asllCrReportRepository->getCrReportDetails($decryptedId);
            return $this->responseRepository->ResponseSuccess($data, 'Cr Report Details');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
