<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ResponseRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Repositories\AuthRepository;
use Illuminate\Support\Str;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\LoginRequestExternal;
use Modules\Auth\Http\Requests\LoginSuperUserRequest;
use Laravel\Passport\Bridge\AccessToken;

use Hash;
use Illuminate\Events\Dispatcher;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;
use stdClass;

class LoginController extends Controller
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
     *     path="/api/v1/auth/login",
     *     tags={"Authentication"},
     *     summary="Logged in to the system by user",
     *     description="Logged in to the system by user",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string", example="akash.corp@akij.net"),
     *              @OA\Property(property="password", type="string", example="123456")
     *          )
     *      ),
     *     operationId="login",
     *      @OA\Response( response=200, description="Login User Data, with Token" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function login(LoginRequest $request)
    {
        if ($this->authRepository->checkIfAuthenticated($request)) {
            $user = $this->authRepository->findUserByEmailAddress($request->email);
            $tokenCreated = $user->createToken('authToken');
            $data = [
                'user' => $user,
                'access_token' => $tokenCreated->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenCreated->token->expires_at)->toDateTimeString()
            ];
            return $this->responseRepository->ResponseSuccess($data, 'Logged in Successfully');
        } else {
            return $this->responseRepository->ResponseError(null, 'Sorry, Invalid Email and Password');
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/auth/superuser-login",
     *     tags={"Authentication"},
     *     summary="Logged in to the system by super user",
     *     description="Logged in to the system by super user",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="username", type="string", example="abir.corp"),
     *              @OA\Property(property="password", type="string", example="Arl@4321")
     *          )
     *      ),
     *     operationId="masterLogin",
     *      @OA\Response( response=200, description="Login User Data, with Token" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function masterLogin(LoginSuperUserRequest $request)
    {
        // Extract the @akij.net's part
        $username = $request->username;
        if (strpos($username, '@akij.net') !== false) {
            $username = strtok(trim($username), '@');
        }
        $password = trim($request->password);
        return $this->authRepository->superUserLogin($username, $password);

        // if (!$this->authRepository->superUserLogin($request->username, $request->password)) {
        //     return $this->authRepository->superUserLogin($username, $password);
        // } else {
        //     return $this->responseRepository->ResponseError(null, 'Sorry, Invalid Email and Password');
        // }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/auth/external-login",
     *     tags={"Authentication"},
     *     summary="Logged in to the system by external user",
     *     description="Logged in to the system by external user",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="username", type="string", example="01712070840"),
     *              @OA\Property(property="password", type="string", example="01712070840")
     *          )
     *      ),
     *     operationId="externalLogin",
     *      @OA\Response( response=200, description="externalLogin User Data, with Token" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function externalLogin(LoginRequestExternal $request)
    {
        if (!is_null($this->authRepository->checkIfAuthenticatedByExternalUser($request->username, $request->password))) {

            $user = $this->authRepository->checkIfAuthenticatedByExternalUser($request->username, $request->password);

            $tokenCreated = Str::random(50);
            $data = [
                'user' => $user,
                'access_token' => $tokenCreated,
                'token_type' => 'Bearer',
                'expires_at' => null
            ];
            return $this->responseRepository->ResponseSuccess($data, 'Logged in Successfully');
        } else {
            return $this->responseRepository->ResponseError(null, 'Sorry, Invalid Username and Password');
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/auth/external-change-password",
     *     tags={"Authentication"},
     *     summary="Change Password",
     *     description="Change Password",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strUserName", type="string", example="01712070840"),
     *              @OA\Property(property="strPassword", type="string", example="01712070840")
     *          )
     *      ),
     *     operationId="changePassword",
     *      @OA\Response( response=200, description="externalLogin User Data, with Token" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function changePassword(Request $request)
    {
        try {
            $data = $this->authRepository->changePassword($request->strUserName, $request->strPassword);
            return $this->responseRepository->ResponseSuccess($data, 'Password has been changed successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }


     /**
     * @OA\POST(
     *     path="/api/v1/auth/generate-token",
     *     tags={"Authentication"},
     *     summary="Logged in to the system by externalUserLogin",
     *     description="Logged in to the system by externalUserLogin",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="client_id", type="string", example="sunshine_app"),
     *              @OA\Property(property="client_secret", type="string", example="om4B8Kon150slj8TwoXKfAt3vcMfIAPlWlC9LcbO")
     *          )
     *      ),
     *     operationId="externalUserLogin",
     *      @OA\Response( response=200, description="Login User Data, with Token" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function externalUserLogin(Request $request)
    {
        $username = trim($request->client_id);
        $password = trim($request->client_secret);

        $user = User::where('username', $username)->first();
        if(!is_null($user)){
            if (Hash::check($password, $user->password)) {
                // Generate token
                $token = new stdClass();
                $token->access_token = $user->createToken('AuthToken')->accessToken;
                return response()->json($token);
            }
            return $this->responseRepository->ResponseError(null, 'Credential does not match !');
        }
        return $this->responseRepository->ResponseError(null, 'Credential does not match !');
    }
}
