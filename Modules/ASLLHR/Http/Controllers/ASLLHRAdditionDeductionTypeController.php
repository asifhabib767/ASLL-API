<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\ASLLHR\Repositories\ASLLHRAdditionDeductionTypeRepository;

class ASLLHRAdditionDeductionTypeController extends Controller
{


    public $asllhrAdditionDeductionRepository;
    public $responseRepository;


    public function __construct(ASLLHRAdditionDeductionTypeRepository $asllhrAdditionDeductionRepository, ResponseRepository $rp)
    {
        $this->asllhrAdditionDeductionRepository = $asllhrAdditionDeductionRepository;
        $this->responseRepository = $rp;
    }
    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getAdditionDeductionTypeList",
     *     tags={"ASLLHR"},
     *     summary="Get Addition Deduction List",
     *     description="Get Addition Deduction List",
     *      operationId="getAdditionDeductionTypeList",
     *      @OA\Response(response=200,description="Get Addition Deduction List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getAdditionDeductionTypeList()
    {
        try {
            $data = $this->asllhrAdditionDeductionRepository->getAdditionDeductionTypeList();
            return $this->responseRepository->ResponseSuccess($data, 'Addition Deduction List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('asllhr::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('asllhr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('asllhr::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
