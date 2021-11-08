<?php

namespace Modules\HR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\HR\Repositories\CheckpointRepository;

class CheckpointsController extends Controller
{
    public $checkpointRepository;
    public $responseRepository;

    public function __construct(CheckpointRepository $checkpointRepository, ResponseRepository $rp)
    {
        $this->checkpointRepository = $checkpointRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/hr/createCheckpoint",
     *     tags={"Checkpoints"},
     *     summary="Create Checkpoint",
     *     description="Create Checkpoint",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strCheckPointName", type="string"),
     *              @OA\Property(property="intFloorID", type="integer"),
     *              @OA\Property(property="intJobStationID", type="integer"),
     *              @OA\Property(property="intUnitID", type="integer"),
     *              @OA\Property(property="ysnActive", type="boolean"),
     *              @OA\Property(property="intInsertedBy", type="integer"),
     *              @OA\Property(property="intUpdatedBy", type="integer"),
     *              @OA\Property(property="decLatitude", type="integer"),
     *              @OA\Property(property="decLongitude", type="integer"),
     *              @OA\Property(property="intZAxis", type="integer"),
     *              @OA\Property(property="strSideName", type="string"),
     *          )
     *      ),
     *      operationId="createCheckpoint",
      *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="createCheckpoint" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function createCheckpoint(Request $request)
    {
        $checkpoint = $this->checkpointRepository->createCheckpoint($request);

        try {
            if (is_null($checkpoint)) {
                return $this->responseRepository->ResponseError(null, "Unsuccessful. Please try again!", Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($checkpoint, "Checkpoint Created Successfully!");
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/checkpoints",
     *     tags={"Checkpoints"},
     *     summary="Get Checkpoint List By UnitId, JobStationId and FloorId",
     *     description="Get Checkpoint List By UnitId, JobStationId and FloorId",
     *     operationId="checkpoints",
     *      @OA\Parameter( name="intUnitID", description="Unit Id, eg; 4", required=true, in="query", @OA\Schema(type="integer" )),
     *      @OA\Parameter( name="intJobStationID", description="Job Station Id, eg; 2", required=true, in="query", @OA\Schema(type="integer" )),
     *      @OA\Parameter( name="intFloorID", description="Floor Id, eg; 5", required=true, in="query", @OA\Schema(type="integer" )),
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="checkpoints" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function checkpoints(Request $request)
    {
        $unitId = $request->intUnitID;
        $jobStationId = $request->intJobStationID;
        $floorId = $request->intFloorID;

        $checkpoints = $this->checkpointRepository->checkpoints($unitId, $jobStationId, $floorId);

        try {
            if (is_null($checkpoints)) {
                return $this->responseRepository->ResponseError(null, "Checkpoint List Not found", Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($checkpoints, "Checkpoint List");
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/hr/updateQrCode",
     *     tags={"Checkpoints"},
     *     summary="Update Checkpoint QR Code",
     *     description="Update Checkpoint QR Code",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strQRCode", type="string"),
     *          )
     *      ),
     *     operationId="updateQrCode",
     *      @OA\Parameter( name="intID", description="Id, eg; 1", required=true, in="query", @OA\Schema(type="integer" )),
      *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="updateQrCode" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateQrCode(Request $request)
    {
        $checkpoint = $this->checkpointRepository->updateQrCode($request);

        try {
            if (is_null($checkpoint)) {
                return $this->responseRepository->ResponseError(null, "Unsuccessful. Please try again!", Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($checkpoint, "Checkpoint QR Code Updated Successfully");
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/qrcodes",
     *     tags={"Checkpoints"},
     *     summary="Get QR Code List By UnitId and JobStationId",
     *     description="Get QR Code List By UnitId and JobStationId",
     *     operationId="qrcodes",
     *      @OA\Parameter( name="intUnitID", description="Unit Id, eg; 4", required=true, in="query", @OA\Schema(type="integer" )),
     *      @OA\Parameter( name="intJobStationID", description="Job Station Id, eg; 2", required=true, in="query", @OA\Schema(type="integer" )),
      *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="qrcodes" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function qrcodes(Request $request)
    {
        $unitId = $request->intUnitID;
        $jobStationId = $request->intJobStationID;

        $qrcodes = $this->checkpointRepository->qrcodes($unitId, $jobStationId);

        try {
            if (is_null($qrcodes)) {
                return $this->responseRepository->ResponseError(null, "QR Code List Not found", Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($qrcodes, "QR Code List");
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
