<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeBankDetailsRepository;

class ASLLHREmployeeBankDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('asllhr::index');
    }

    public $asllhrEmployeeBankDetailsRepository;
    public $responseRepository;


    public function __construct(ASLLHREmployeeBankDetailsRepository $asllhrEmployeeBankDetailsRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeBankDetailsRepository = $asllhrEmployeeBankDetailsRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/createEmployeeBankDetails",
     *     tags={"ASLLHR"},
     *     summary="Create Employee BankDetails",
     *     description="Create Employee BankDetails",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="bankDetails",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="strAccountHolderName", type="string", example="Abir"),
     *                              @OA\Property(property="strAccountNumber", type="string", example="335234234242"),
     *                              @OA\Property(property="strBankName", type="string", example="DBBL"),
     *                              @OA\Property(property="strBankAddress", type="string", example="Uttara"),
     *                              @OA\Property(property="strSwiftCode", type="string", example="43423"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=6),
     *                              @OA\Property(property="strRoutingNumber", type="string", example="234565"),
     *                              @OA\Property(property="intUnitId", type="integer", example=17),
     *                              @OA\Property(property="images", type="string", example="/images"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="createEmployeeBankDetails",
     *      @OA\Response(response=200,description="Create Employee BankDetails"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createEmployeeBankDetails(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeBankDetailsRepository->createEmployeeBankDetails($request->all());

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Bank Details Created');
            } else {
                return $this->responseRepository->ResponseError(null, 'Employee Bank Details Create Not Successfull');
            }
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/updateEmployeeBankDetails",
     *     tags={"ASLLHR"},
     *     summary="Update Employee Document",
     *     description="Update Employee Document",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *                              @OA\Property(property="intID", type="integer", example=3),
     *                              @OA\Property(property="strCertification", type="string", example="SSC"),
     *                              @OA\Property(property="strInstitution", type="string", example="MCC"),
     *                              @OA\Property(property="strYear", type="string", example="2016"),
     *                              @OA\Property(property="strResult", type="string", example="4.66"),
     *                              @OA\Property(property="image", type="string", example=null),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=2),
     *                              @OA\Property(property="intUnitId", type="integer", example=17),
     *           )
     *      ),
     *      operationId="updateEmployeeBankDetails",
     *      @OA\Response(response=200,description="Update Employee Document"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateEmployeeBankDetails(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeBankDetailsRepository->updateEmployeeBankDetails($request);

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Certificate Updated');
            }
            return $this->responseRepository->ResponseError(null, 'Employee Certificate Update Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
