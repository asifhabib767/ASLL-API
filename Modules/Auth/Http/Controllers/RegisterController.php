<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ResponseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Repositories\AuthRepository;

class RegisterController extends Controller
{
    public $authRepository;
    public $responseRepository;

    public function __construct(AuthRepository $authRepository, ResponseRepository $responseRepository)
    {
        $this->authRepository = $authRepository;
        $this->responseRepository = $responseRepository;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/auth/register",
     *     tags={"Authentication"},
     *     summary="Register a user to the system",
     *     description="Register a user to the system",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="first_name", type="string", example="Test User"),
     *              @OA\Property(property="surname", type="string" , example="test"),
     *              @OA\Property(property="last_name", type="string", example="last"),
     *              @OA\Property(property="email", type="string", format="email", example="akash@mail.com"),
     *              @OA\Property(property="phone_no", type="string", example="01951233084"),
     *              @OA\Property(property="password", type="string", format="password", example="123456"),
     *              @OA\Property(property="password_confirmation", type="string", format="password", example="123456"),
     *              @OA\Property(property="language", type="string", example="en"),
     *          )
     *      ),
     *     operationId="register",
     *      @OA\Response( response=200, description="Create New User Account" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authRepository->registerUser($request);
            $accessToken = $user->createToken('authToken')->accessToken;
            $data = [
                'user' => $user,
                'access_token' => $accessToken,
            ];
            return $this->responseRepository->ResponseSuccess($data, 'User Registered Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
