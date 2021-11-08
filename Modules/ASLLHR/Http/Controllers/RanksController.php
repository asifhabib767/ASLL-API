<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\RankRepository;

class RanksController extends Controller
{
    public $rankRepository;
    public $responseRepository;


    public function __construct(RankRepository $rankRepository, ResponseRepository $rp)
    {
        $this->rankRepository = $rankRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getRanks",
     *     tags={"ASLLHR"},
     *     summary="Get Rank List",
     *     description="Get Rank List",
     *     security={{"bearer": {}}},
     *      operationId="getRanks",
     *      @OA\Response(response=200,description="Get Rank List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getRanks()
    {
        try {
            $data = $this->rankRepository->getRanks();
            return $this->responseRepository->ResponseSuccess($data, 'Rank List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getRanksPrint",
     *     tags={"ASLLHR"},
     *     summary="Get Rank List For Printing",
     *     description="Get Rank List For Printing",
     *      operationId="getRanksPrint",
     *      @OA\Response(response=200,description="Get Rank List For Printing"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getRanksPrint()
    {
        try {
            $data = $this->rankRepository->getRanksPrint();
            return $this->responseRepository->ResponseSuccess($data, 'Rank List For Print');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
