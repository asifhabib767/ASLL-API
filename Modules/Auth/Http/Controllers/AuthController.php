<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\Repositories\AuthRepository;

class AuthController extends Controller
{
    public $authRepository;
    public $responseRepository;

    public function __construct(AuthRepository $authRepository, ResponseRepository $responseRepository)
    {
        $this->authRepository = $authRepository;
        $this->responseRepository = $responseRepository;
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/auth/updateUserProfile",
     *     tags={"Authentication"},
     *     summary="Update User Account",
     *     description="Update User Account",
     *     security={{"bearer": {}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="first_name", type="string"),
     *              @OA\Property(property="surname", type="string"),
     *              @OA\Property(property="last_name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="username", type="string"),
     *              @OA\Property(property="phone_no", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="language", type="string"),
     *          )
     *      ),
     *     operationId="updateUserProfile",
     *      @OA\Response( response=200, description="Create New User Account" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateUserProfile(Request $request)
    {
        try {
            $user = $request->user();
            $user = $this->authRepository->updateUserProfile($request, $user->id);
            return $this->responseRepository->ResponseSuccess($user, 'User Account has been updated successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, trans('common.something_wrong'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\DELETE(
     *     path="/api/v1/auth/deleteUserAccount",
     *     tags={"Authentication"},
     *     summary="Delete Account",
     *     description="Delete Account",
     *     security={{"bearer": {}}},
     *     operationId="deleteUserAccount",
     *      @OA\Response( response=200, description="Deleted User Account" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteUserAccount(Request $request)
    {
        try {
            $user = $request->user();
            $this->authRepository->deleteUserAccount($user->id);
            return $this->responseRepository->ResponseSuccess($user, 'User Account has been deleted successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, trans('common.something_wrong'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/auth/getUserProfile",
     *     tags={"Authentication"},
     *     summary="Get User Account",
     *     description="Get User Account",
     *     security={{"bearer": {}}},
     *     operationId="getUserProfile",
     *      @OA\Response( response=200, description="Get User Account" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getUserProfile(Request $request)
    {
        try {
            $user = $request->user();
            return $this->responseRepository->ResponseSuccess($user, 'User Account Details');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, trans('common.something_wrong'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
    }

    /**
     * @OA\GET(
     *     path="/api/v1/checkInADAuthorized",
     *     tags={"Authentication"},
     *     summary="Get User Account",
     *     description="Get User Account",
     *     operationId="checkInADAuthorized",
     *     @OA\Parameter( name="username", description="username, eg; asif1.corp", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="password", description="password, eg; Akij12345", required=true, in="query", @OA\Schema(type="string")),
     *      @OA\Response( response=200, description="Get User Account" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function checkInADAuthorized(Request $request)
    {
        try {
            $username = $request->username;
            $password = $request->password;
            $data = $this->authRepository->checkInADAuthorized($username, $password);
            return $this->responseRepository->ResponseSuccess($data, 'Check Auth Fetched Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, trans('common.something_wrong'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Logout user
     * security={{"bearer": {}}},
     * @return response message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->responseRepository->ResponseSuccess(null, 'User Logged Out');
    }
}
