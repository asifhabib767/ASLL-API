<?php

namespace Modules\Role\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Role\Repositories\RolesRepository;

class RoleController extends Controller
{
    public $rolesRepository;
    public $responseRepository;


    public function __construct(RolesRepository $rolesRepository, ResponseRepository $rp)
    {
        $this->rolesRepository = $rolesRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/roles/getModulePermissionByUserTypeID",
     *     tags={"Module Permission"},
     *     summary="Get Module Permissions By User Type",
     *     description="Get Module Permissions By User Type",
     *     operationId="getModulePermissionByUserTypeID",
     *      @OA\Parameter( name="intUserTypeID", description="intUserTypeID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="Get Module Permissions By User Type"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getModulePermissionByUserTypeID(Request $request)
    {
        $intUserTypeID = $request->intUserTypeID;

        try {
            $data = $this->rolesRepository->getModulePermissionByUserTypeID($intUserTypeID);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Module List Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Module List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/roles/getModulePermissionByUser",
     *     tags={"Module Permission"},
     *     summary="Get Module Permissions By User ID and User Type",
     *     description="Get Module Permissions By User ID and User Type",
     *     operationId="getModulePermissionByUser",
     *      @OA\Parameter( name="intUserTypeID", description="intUserTypeID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="intUserID", description="intUserID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="Get Module Permissions By User ID and User Type"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getModulePermissionByUser(Request $request)
    {
        $intUserTypeID = $request->intUserTypeID;
        $intUserID = $request->intUserID;

        try {
            $data = $this->rolesRepository->getModulePermissionByUser($intUserID, $intUserTypeID);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Module List Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Module List By '.$intUserID);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/roles/getModuleList",
     *     tags={"Module Permission"},
     *     summary="Get Module Permissions By User ID and User Type",
     *     description="Get Module Permissions By User ID and User Type",
     *     operationId="getModuleList",
     *     @OA\Response(response=200,description="Get Module Permissions By User ID and User Type"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getModuleList(Request $request)
    {
        $intUserTypeID = $request->intUserTypeID;
        $intUserID = $request->intUserID;

        try {
            $data = $this->rolesRepository->getModuleList($intUserID, $intUserTypeID);
            return $this->responseRepository->ResponseSuccess($data, 'Module List By '.$intUserID);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/roles/getUserTypeList",
     *     tags={"Module Permission"},
     *     summary="Get Module Permissions By User ID and User Type",
     *     description="Get Module Permissions By User ID and User Type",
     *     operationId="getUserTypeList",
     *     @OA\Response(response=200,description="Get Module Permissions By User ID and User Type"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getUserTypeList(Request $request)
    {
        $intUserTypeID = $request->intUserTypeID;
        $intUserID = $request->intUserID;

        try {
            $data = $this->rolesRepository->getUserTypeList($intUserID, $intUserTypeID);
            return $this->responseRepository->ResponseSuccess($data, 'Module List By '.$intUserID);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\POST(
     *     path="/api/v1/roles/appPermissionStore",
     *     tags={"Module Permission"},
     *     summary="Post Module Permissions",
     *     description="Post Module Permissions By User ID and User Type",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intAppsModuleID", type="integer", example=2),
     *              @OA\Property(property="intUserTypeID", type="integer", example=1),
     *              @OA\Property(property="intUserID", type="integer", example=2),
     *              @OA\Property(property="intInsertedBy", type="integer", example=2),
     *           )
     *      ),
     *      operationId="appPermissionStore",
     *      @OA\Response(response=200,description="App Permission Created successfully !"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function appPermissionStore(Request $request)
    {
        try {
            $data = $this->rolesRepository->appPermissionStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'App Permission Created successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


     /**
     * @OA\POST(
     *     path="/api/v1/roles/multipleAppPermissionStore",
     *     tags={"Module Permission"},
     *     summary="Create Multiple Permissions",
     *     description="Create Multiple Permissions",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="permissions",
     *                      type="array",
     *                      @OA\Items(
     *                                 @OA\Property(property="intAppsModuleID", type="integer", example=2),
                *                      @OA\Property(property="intUserTypeID", type="integer", example=1),
                *                      @OA\Property(property="intUserID", type="integer", example=2),
                *                      @OA\Property(property="intInsertedBy", type="integer", example=2),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="multipleAppPermissionStore",
     *      @OA\Response(response=200,description="Create Role Permissions"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function multipleAppPermissionStore(Request $request)
    {
        try {
            $data = $this->rolesRepository->multipleAppPermissionStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Multiple Permission Given successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
