<?php

namespace Modules\Sms\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Sms\Repositories\SmsRepository;

class SmsController extends Controller
{

    public $smsRepository;
    public $responseRepository;

    public function __construct(SmsRepository $smsRepository, ResponseRepository  $rp)
    {
        $this->smsRepository = $smsRepository;
        $this->responseRepository = $rp;
    }



    /**
     * @OA\POST(
     *     path="/api/v1/sms/SmsSend",
     *     tags={"SMS"},
     *     summary="Insertion AFML Sms",
     *     description="Insertion Employee SMS",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="phoneNo", type="string", example="01732328504"),
     *                 @OA\Property(property="message", type="string", example="Test"),
     *                 @OA\Property(property="masking", type="string", example="SUNSHINE"),
     *              )
     *           ),
     *      operationId="SmsSend",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Insertion Employee SMS" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function SmsSend(Request $request)
    {
        try {
            $request->validate([
                "phoneNo" =>  "required|string",
                "message" =>  "required|string",
                "masking" =>  "required|string"
            ]);

            $data = $this->smsRepository->SmsSend($request);
            // return  $data;

            // return $this->responseRepository->ResponseSuccess($data, 'SMS Send Successfully !');
        } catch (\Exception $e) {
            // return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\GET(
     *    path="/api/v1/sms/GetFGItemListForAFML",
     *     tags={"SMS"},
     *     summary="GetFGItemListForAFML",
     *     description="getProfileByenrollandUnitId",
     *     operationId="GetFGItemListForAFML",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetFGItemListForAFML"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetFGItemListForAFML()
    {

        try {
            $data = $this->smsRepository->GetFGItemListForAFML();
            return $this->responseRepository->ResponseSuccess($data, 'FG Item List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *    path="/api/v1/sms/GetCustomerForAFML",
     *     tags={"SMS"},
     *     summary="GetCustomerForAFML",
     *     description="getProfileByenrollandUnitId",
     *     operationId="GetCustomerForAFML",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetCustomerForAFML"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetCustomerForAFML()
    {

        try {
            $data = $this->smsRepository->GetCustomerForAFML();
            return $this->responseRepository->ResponseSuccess($data, 'FG Item List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *    path="/api/v1/sms/GetPendingItemByCustomerForAFML",
     *     tags={"SMS"},
     *     summary="GetPendingItemByCustomerForAFML",
     *     description="getProfileByenrollandUnitId",
     *     operationId="GetPendingItemByCustomerForAFML",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetPendingItemByCustomerForAFML"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetPendingItemByCustomerForAFML()
    {

        try {
            $data = $this->smsRepository->GetPendingItemByCustomerForAFML();
            return $this->responseRepository->ResponseSuccess($data, 'FG Item List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


       /**
     * @OA\POST(
     *     path="/api/v1/sms/SmsSendByITDept",
     *     tags={"SMS"},
     *     summary="Insertion IT Dept Sms",
     *     description="Insertion IT DEPT. SMS",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="phoneNo", type="string", example="01732328504"),
     *                 @OA\Property(property="message", type="string", example="Test"),
     *                 @OA\Property(property="masking", type="string", example="SUNSHINE"),
     *              )
     *           ),
     *      operationId="SmsSendByITDept",
     *      operationId="SmsSend",
     *      @OA\Response( response=200, description="Insertion IT DEPT. SMS" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function SmsSendByITDept(Request $request)
    {
        try {
            $request->validate([
                "phoneNo" =>  "required|string",
                "message" =>  "required|string",
                "masking" =>  "required|string"
            ]);

            $data = $this->smsRepository->SmsSendByITDept($request);
            // return  $data;

            // return $this->responseRepository->ResponseSuccess($data, 'SMS Send Successfully !');
        } catch (\Exception $e) {
            // return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



}
