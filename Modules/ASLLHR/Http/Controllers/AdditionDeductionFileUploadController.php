<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\ASLLHR\Repositories\AdditionDeductionFileUploadRepository;



class AdditionDeductionFileUploadController extends Controller
{
 

    public $additionDeductionRepository;
    public $responseRepository;

    public function __construct(AdditionDeductionFileUploadRepository $additionDeductionRepository, ResponseRepository $rp)
    {
        $this->additionDeductionRepository = $additionDeductionRepository;
        $this->responseRepository = $rp;
    }

 /**
     * @OA\POST(
     *     path="/api/v1/asllhr/fileInput",
     *     tags={"ASLLHR"},
     *     summary="Create Addition Deduction File Input",
     *     description="Create Addition Deduction File Input",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *                 @OA\Property(property="uploadFile", type="string", example="Something"),
     *              )
     *      ),
     *      operationId="fileInput",
     *      @OA\Response(response=200,description="Create Addition Deduction"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function fileInput(Request $request)
    {
       
        try {
            $data = $this->additionDeductionRepository->fileInput($request);
            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Salary Bulk Data Created');
            }
            return $this->responseRepository->ResponseError($data, 'Salary Bulk Data Create Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
   
}
