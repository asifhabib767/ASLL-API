<?php

namespace Modules\PurchaseRequisition\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PurchaseRequisition\Repositories\DepartmentRepository;

class DepartmentsController extends Controller
{
    public $departmentRepository;
    public $responseRepository;

    public function __construct(DepartmentRepository $departmentRepository, ResponseRepository $rp)
    {
        $this->departmentRepository = $departmentRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getDepartmentList",
     *     tags={"Departments"},
     *     summary="getDepartmentList",
     *     description="Item Types List",
     *     operationId="getDepartmentList",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDepartmentList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDepartmentList(Request $request)
    {
        try {
            $data = $this->departmentRepository->getDepartmentAll();
            return $this->responseRepository->ResponseSuccess($data, 'Department List All');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
