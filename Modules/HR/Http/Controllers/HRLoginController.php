<?php

namespace Modules\HR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\HR\Repositories\HRLoginRepository;

class HRLoginController extends Controller
{
    public $hrLoginRepository;
    public $responseRepository;


    public function __construct(HRLoginRepository $hrLoginRepository, ResponseRepository $rp)
    {
        $this->hrLoginRepository = $hrLoginRepository;
        $this->responseRepository = $rp;
    }

     /**
     * @OA\GET(
     *     path="/api/v1/hr/getUserDataByUserEmail",
     *     tags={"Profile Data"},
     *     summary="getUserDataByUserEmail",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getUserDataByUserEmail",
     *     @OA\Parameter( name="strOfficeEmail", description="strOfficeEmail  , eg; akash.corp@akij.net", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200,description="getUserDataByUserEmail"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getUserDataByUserEmail(Request $request)
    {

        $strOfficeEmail = $request->strOfficeEmail;
        try {
            $data = $this->hrLoginRepository->getUserDataByUserEmail($strOfficeEmail);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Profile By Email Address');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/getEmployeeProfileDetailsWithoutAuth",
     *     tags={"Profile Data"},
     *     summary="getEmployeeProfileDetailsWithoutAuth",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getEmployeeProfileDetailsWithoutAuth",
     *     @OA\Parameter( name="strOfficeEmail", description="strOfficeEmail  , eg; asif1.corp@akij.net", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200,description="getEmployeeProfileDetailsWithoutAuth"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeProfileDetailsWithoutAuth(Request $request)
    {
        // if ($request->user()->email != $request->strOfficeEmail) {
        //     return $this->responseRepository->ResponseSuccess(null, 'Sorry! You are not authenticated to see this data.');
        // }

        $strOfficeEmail = $request->strOfficeEmail;
        try {
            $data = $this->hrLoginRepository->getEmployeeProfileDetailsWithoutAuth($strOfficeEmail);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Profile By Email Address');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create()
    {
        return view('hr::create');
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
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('hr::edit');
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
