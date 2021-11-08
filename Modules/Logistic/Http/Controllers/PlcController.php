<?php

namespace Modules\Logistic\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use stdClass;

class PlcController extends Controller
{
    /**
     * @OA\GET(
     *     path="/api/v1/plc/getPackerInformation",
     *     tags={"PLC"},
     *     summary="Get Packer Information",
     *     description="Get Packer Information",
     *      operationId="getPackerInformation",
     *      @OA\Response(response=200,description="Get Packer Information"),
     *      @OA\Parameter(name="intPackerNo", description="intPackerNo, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPackerInformation(Request $request)
    {
        try {
            $request->validate([
                'intPackerNo' => 'required|integer'
            ]);

            $data = [
                [
                    'RemoteActive' => 0,
                    'ResetCounter' => 0,
                    'Conveyorstatus' => 0,
                    'PresetedBag' => 0,
                    'PresetbyQR' => 0,
                    'BagsCount' => 0,
                ]
            ];



            if($request->intPackerNo == 1){
                $str = Http::get("http://172.16.19.150/awp/UserDefine.html");
                $data = [
                    [
                        'RemoteActive' => (int) $this->get_string_between($str, '<td>Remote Active</td><td id="i201">', "</td>"),
                        'ResetCounter' => (int)  $this->get_string_between($str, '<td>Reset Counter</td><td id="i202">', "</td>"),
                        'Conveyorstatus' => (int)  $this->get_string_between($str, '<td>Conveyor status</td><td id="i203">', "</td>"),
                        'PresetedBag' => (int)  $this->get_string_between($str, '<td>Preseted Bag</td><td id="i204">', "</td>"),
                        'PresetbyQR' => (int)  $this->get_string_between($str, '<td>Preset by QR</td><td id="i205">', "</td>"),
                        'BagsCount' => (int)  $this->get_string_between($str, '<td>Bags Count</td><td id="i206">', "</td>"),
                    ]
                ];
            }else if($request->intPackerNo == 2){
                $str = Http::get("http://172.16.19.150/awp/UserDefine.html");
                $data = [
                    [
                        'RemoteActive' => (int) $this->get_string_between($str, '<td>Remote Active</td><td id="i208">', "</td>"),
                        'ResetCounter' => (int)  $this->get_string_between($str, '<td>Reset Counter</td><td id="i209">', "</td>"),
                        'Conveyorstatus' => (int)  $this->get_string_between($str, '<td>Conveyor status</td><td id="i210">', "</td>"),
                        'PresetedBag' => (int)  $this->get_string_between($str, '<td>Preseted Bag</td><td id="i211">', "</td>"),
                        'PresetbyQR' => (int)  $this->get_string_between($str, '<td>Preset by QR</td><td id="i212">', "</td>"),
                        'BagsCount' => (int)  $this->get_string_between($str, '<td>Bags Count</td><td id="i213">', "</td>"),
                    ]
                ];
            }else if($request->intPackerNo == 3){
                $str = Http::get("http://172.16.19.150/awp/UserDefine.html");
                $data = [
                    [
                        'RemoteActive' => (int) $this->get_string_between($str, '<td>Remote Active</td><td id="i215">', "</td>"),
                        'ResetCounter' => (int)  $this->get_string_between($str, '<td>Reset Counter</td><td id="i216">', "</td>"),
                        'Conveyorstatus' => (int)  $this->get_string_between($str, '<td>Conveyor status</td><td id="i217">', "</td>"),
                        'PresetedBag' => (int)  $this->get_string_between($str, '<td>Preseted Bag</td><td id="i218">', "</td>"),
                        'PresetbyQR' => (int)  $this->get_string_between($str, '<td>Preset by QR</td><td id="i219">', "</td>"),
                        'BagsCount' => (int)  $this->get_string_between($str, '<td>Bags Count</td><td id="i220">', "</td>"),
                    ]
                ];
            }else if($request->intPackerNo == 4){
                $str = Http::get("http://172.16.19.154/awp/UserDefine.html");
                $data = [
                    [
                        'RemoteActive' => (int) $this->get_string_between($str, '<td>Remote Active</td><td id="i101">', "</td>"),
                        'ResetCounter' => (int)  $this->get_string_between($str, '<td>Reset Counter</td><td id="i102">', "</td>"),
                        'Conveyorstatus' => (int)  $this->get_string_between($str, '<td>Conveyor status</td><td id="i103">', "</td>"),
                        'PresetedBag' => (int)  $this->get_string_between($str, '<td>Preseted Bag</td><td id="i104">', "</td>"),
                        'PresetbyQR' => (int)  $this->get_string_between($str, '<td>Preset by QR</td><td id="i105">', "</td>"),
                        'BagsCount' => (int)  $this->get_string_between($str, '<td>Bags Count</td><td id="i106">', "</td>"),
                    ]
                ];
            }else if($request->intPackerNo == 5){
                $str = Http::get("http://172.16.19.154/awp/UserDefine.html");
                $data = [
                    [
                        'RemoteActive' => (int)  $this->get_string_between($str, '<td>Remote Active</td><td id="i108">', "</td>"),
                        'ResetCounter' => (int)  $this->get_string_between($str, '<td>Reset Counter</td><td id="i109">', "</td>"),
                        'Conveyorstatus' => (int)  $this->get_string_between($str, '<td>Conveyor status</td><td id="i110">', "</td>"),
                        'PresetedBag' => (int)  $this->get_string_between($str, '<td>Preseted Bag</td><td id="i111">', "</td>"),
                        'PresetbyQR' => (int)  $this->get_string_between($str, '<td>Preset by QR</td><td id="i112">', "</td>"),
                        'BagsCount' => (int)  $this->get_string_between($str, '<td>Bags Count</td><td id="i113">', "</td>"),
                    ]
                ];
            }

            return $data[0];

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/plc/storePackerInformation",
     *     tags={"PLC"},
     *     summary="Store Packer Information",
     *     description="Store Packer Information",
     *      operationId="storePackerInformation",
     *      @OA\Response(response=200,description="Store Packer Information"),
     *      @OA\Parameter(name="intPackerNo", description="intPackerNo, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="intBagQty", description="intBagQty, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storePackerInformation(Request $request)
    {
        try {
            $request->validate([
                'intPackerNo' => 'required|integer',
                'intBagQty' => 'required|integer',
            ]);

            $ch = curl_init();

            $bagsQty = $request->intBagQty;
            if($request->intPackerNo == 1){
                $url = "http://172.16.19.150/awp/UserDefine.html?%22Bag_Reset_Remotly_P1%22=1&%22Remote_SP_p1%22=".$bagsQty."&%22Bag_Reset_Remotly_P1%22=0";
            }else if($request->intPackerNo == 2){
                $url = "http://172.16.19.150/awp/UserDefine.html?%22Bag_Reset_Remotly_P2%22=1&%22remote_SP_p2%22=".$bagsQty."&%22Bag_Reset_Remotly_P2%22=0";
            }else if($request->intPackerNo == 3){
                $url = "http://172.16.19.150/awp/UserDefine.html?%22Bag_Reset_Remotly_P3%22=1&%22Remote_SP_p3%22=".$bagsQty."&%22Bag_Reset_Remotly_P3%22=0";
            }else if($request->intPackerNo == 4){
                $url = "https://172.16.19.154/awp/UserDefine.html?%22Bag_Reset_Remotely_P4%22=1&%22Remote_SP_P-4%22=".$bagsQty."&%22Bag_Reset_Remotely_P4%22=0";
            }
            else if($request->intPackerNo == 5){
                $url = "https://172.16.19.154/awp/UserDefine.html?%22Bag_Reset_Remotely_P5%22=1&%22Remote_SP_P-5%22=".$bagsQty."&%22Bag_Reset_Remotely_P5%22=0";
            }

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $getURL = curl_exec($ch);
            $getInfo = json_decode($getURL, true);
            curl_close($ch);

            $data = [
                [
                    'status' => true,
                    'message' => 'Packer Data Updated',
                    'bagsQty' => (int) $bagsQty,
                    'intPackerNo' => (int) $request->intPackerNo,
                    'details' => $getInfo
                ]
            ];
        } catch (\Exception $e) {
            $data = [
                [
                    'status' => false,
                    'message' => $e->getMessage(),
                    'bagsQty' => 0,
                    'intPackerNo' => 0,
                    'details' => null
                ]
            ];
        }

        return $data[0];
    }

    /**
     * @OA\GET(
     *     path="/api/v1/plc/getPackerList",
     *     tags={"PLC"},
     *     summary="Get Packer Information",
     *     description="Get Packer Information",
     *      operationId="getPackerList",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Packer Information"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPackerList()
    {
        $data = [
            [
                'status' => false,
                'message' => 'Get Packer List',
                'data' => [
                    [
                        'packerName' => 'Packer 1',
                        'packerNo' => 1,
                        'bagsResetName' => 'Bag_Reset_Remotly_P1',
                        'bagsResetId' => 'i250',
                        'remoteSpName' => 'Remote_SP_p1',
                        'remoteSpId' => 'i251',
                        'urlGetData' => 'https://172.16.19.150/awp/UserDefine.html',
                    ],
                    [
                        'packerName' => 'Packer 2',
                        'packerNo' => 2,
                        'bagsResetName' => 'Bag_Reset_Remotly_P2',
                        'bagsResetId' => 'i254',
                        'remoteSpName' => 'Remote_SP_p2',
                        'remoteSpId' => 'i255',
                        'urlGetData' => 'https://172.16.19.150/awp/UserDefine.html',
                    ],
                    [
                        'packerName' => 'Packer 3',
                        'packerNo' => 3,
                        'bagsResetName' => 'Bag_Reset_Remotly_P3',
                        'bagsResetId' => 'i258',
                        'remoteSpName' => 'Remote_SP_p3',
                        'remoteSpId' => 'i259',
                        'urlGetData' => 'https://172.16.19.150/awp/UserDefine.html',
                    ],
                    [
                        'packerName' => 'Packer 4',
                        'packerNo' => 4,
                        'bagsResetName' => 'Bag_Reset_Remotly_P4',
                        'bagsResetId' => 'i120',
                        'remoteSpName' => 'Remote_SP_p4',
                        'remoteSpId' => 'i121',
                        'urlGetData' => 'https://172.16.19.154/awp/UserDefine.html',
                    ],
                    [
                        'packerName' => 'Packer 5',
                        'packerNo' => 5,
                        'bagsResetName' => 'Bag_Reset_Remotly_P5',
                        'bagsResetId' => 'i120',
                        'remoteSpName' => 'Remote_SP_p5',
                        'remoteSpId' => 'i121',
                        'urlGetData' => 'https://172.16.19.154/awp/UserDefine.html',
                    ],
                ]
            ]
        ];

        return $data[0];
    }

    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function getGithubInfo()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->get('https://api.github.com/user', ['auth' =>  ['manirujjamanakash@gmail.com', '91221198Aj$']]);
        echo $res->getStatusCode(); // 200
        echo $res->getBody();
    }
}
