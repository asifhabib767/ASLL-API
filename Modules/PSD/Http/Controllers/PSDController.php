<?php

namespace Modules\PSD\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PSD\Repositories\MasterRepository;

class PSDController extends Controller
{
    public $masterRepository;
    public $responseRepository;


    public function __construct(MasterRepository $masterRepository, ResponseRepository $rp)
    {
        $this->masterRepository = $masterRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/getConstruction",
     *     tags={"Master Data"},
     *     summary="Get Construction List",
     *     description="Get Construction List",
     *      operationId="getConstruction",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Construction List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getConstruction()
    {
        try {
            $data = $this->masterRepository->getConstruction();
            return $this->responseRepository->ResponseSuccess($data, 'Construction List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/getActivity",
     *     tags={"Master Data"},
     *     summary="Get Activity Type List",
     *     description="Get Activity Type List",
     *      operationId="getActivity",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Activity Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getActivity()
    {
        try {
            $data = $this->masterRepository->getActivity();
            return $this->responseRepository->ResponseSuccess($data, 'Activity Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/getFeedBack",
     *     tags={"Master Data"},
     *     summary="Get FeedBack Type List",
     *     description="Get FeedBack Type List",
     *      operationId="getFeedBack",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get FeedBack Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getFeedBack()
    {
        try {
            $data = $this->masterRepository->getFeedBack();
            return $this->responseRepository->ResponseSuccess($data, 'FeedBack Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/getComplaintProblemType",
     *     tags={"Master Data"},
     *     summary="Get Complaint Problem Type List",
     *     description="Get Complaint Problem Type List",
     *      operationId="getComplaintProblemType",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Complaint Problem Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getComplaintProblemType()
    {
        try {
            $data = $this->masterRepository->getComplaintProblemType();
            return $this->responseRepository->ResponseSuccess($data, 'Complaint Problem Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/getComplaintSolvedType",
     *     tags={"Master Data"},
     *     summary="Get Complaint Solved Type List",
     *     description="Get Complaint Solved Type List",
     *      operationId="getComplaintSolvedType",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Complaint Solved Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    // public function getComplaintSolvedType()
    // {
    //     try {
    //         $data = $this->masterRepository->getComplaintSolvedType();
    //         return $this->responseRepository->ResponseSuccess($data, 'Complaint Solved Type List');
    //     } catch (\Exception $e) {
    //         return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }


    /**
     * @OA\GET(
     *     path="/api/v1/psd/getComplaintForwardedType",
     *     tags={"Master Data"},
     *     summary="Get Complaint Forwarded Type List",
     *     description="Get Complaint Forwarded Type List",
     *      operationId="getComplaintForwardedType",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Complaint Forwarded Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    // public function getComplaintForwardedType()
    // {
    //     try {
    //         $data = $this->masterRepository->getComplaintForwardedType();
    //         return $this->responseRepository->ResponseSuccess($data, 'Complaint Forwarded Type List');
    //     } catch (\Exception $e) {
    //         return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    /**
     * @OA\GET(
     *     path="/api/v1/psd/getProgramType",
     *     tags={"Master Data"},
     *     summary="Get Program Type List",
     *     description="Get Program Type List",
     *      operationId="getProgramType",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Program Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getProgramType()
    {
        try {
            $data = $this->masterRepository->getProgramType();
            return $this->responseRepository->ResponseSuccess($data, 'Program Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/psd/programTypeStore",
     *     tags={"Master Data"},
     *     summary="Create Program Type",
     *     description="Create Program Type",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strProgramTypeName", type="string", example="Test Program"),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18"),
     *              @OA\Property(property="ysnActive", type="boolean", example=1),
     *           )
     *      ),
     *      operationId="programTypeStore",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Program Type"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function programTypeStore(Request $request)
    {
        try {
            $data = $request->all();
            $masterRepository = $this->masterRepository->programTypeStore($data);
            return $this->responseRepository->ResponseSuccess($masterRepository, 'Program Type created successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

         /**
     * @OA\PUT(
     *     path="/api/v1/psd/programTypeUpdate",
     *     tags={"Master Data"},
     *     summary="Update program Type",
     *     description="Update program Type",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strProgramTypeName", type="string", example="Test Program"),
     *              @OA\Property(property="intProgramTypeId", type="integer", example=1),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-18"),
     *              @OA\Property(property="ysnActive", type="boolean", example=1),
     *              )
     *      ),
     *      operationId="programTypeUpdate",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update program Type"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function programTypeUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $masterRepository = $this->masterRepository->programTypeUpdate($data, $request->intProgramTypeId);
            return $this->responseRepository->ResponseSuccess($masterRepository, 'program Type Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *      path="/api/v1/psd/programTypeDelete/{intProgramTypeId}",
     *      tags={"Master Data"},
     *      summary="Delete program Type Visit",
     *      description="Delete program Type Visit",
     *      operationId="programTypeDelete",
     *      @OA\Parameter( name="intProgramTypeId", description="intProgramTypeId, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Delete program Type Visit"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function programTypeDelete($intProgramTypeId)
    {
        try {
            $data = $this->masterRepository->programTypeDelete($intProgramTypeId);
            return $this->responseRepository->ResponseSuccess($data, 'Program Type Visit Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
