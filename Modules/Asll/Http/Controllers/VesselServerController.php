<?php

namespace Modules\Asll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Asll\Entities\VesselServer;

class VesselServerController extends Controller
{
    /**
     * @OA\GET(
     *     path="/api/v1/asll/vessel-servers",
     *     tags={"Vessel"},
     *     summary="Get Vessel Server List",
     *     description="Get Vessel Server List",
     *      operationId="getVesselServers",
     *      @OA\Response(response=200,description="Get Vessel Server List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVesselServers()
    {
        return VesselServer::all();
    }

}
