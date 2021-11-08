<?php

namespace Modules\PSD\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\PSD\Entities\PromotionProgramDetails;
use Modules\PSD\Entities\PromotionProgramMain;

class PromotionProgramRepository
{
    public function getPromotionProgram()
    {
        try {
            // $promotionProgramDetails = PromotionProgramDetails::where('ysnActive', 1)
            //     ->orderBy('intID', 'desc')
            //     ->get();

            $promotionProgramDetails = PromotionProgramDetails::select('tblPSDProgramDetails.*', 'tblPSDProgramMain.*')
                ->where('tblPSDProgramDetails.ysnActive', 1)
                ->join('tblPSDProgramMain', 'tblPSDProgramMain.intID', 'tblPSDProgramDetails.intProgramMainId')
                ->orderBy('tblPSDProgramDetails.intID', 'desc')
                ->get();
            return $promotionProgramDetails;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getPromotionProgramDetails()
    {
        try {
            $programDetails = PromotionProgramMain::orderBy('intID', 'desc')
                ->with('promotionDetails')
                ->get();
            return $programDetails;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function storepromotionProgram(Request $request)
    {
        try {
            $i = 1;

            $programMain = PromotionProgramMain::create([
                'intUnitId' => $request->intUnitId,
                'strProgramTypeName' => $request->strProgramTypeName,
                'intProgramTypeId' => $request->intProgramTypeId,
                'intParticipantId' => 1,
                'strParticipantName' => $request->strParticipantName,
                'strVenueName' => $request->strVenueName,
                'intCreatedBy' => $request->intCreatedBy,
                'dteCreatedAt' => $request->dteCreatedAt,
            ]);

            foreach ($request->programlists as $programlists) {
                // Check if already an entry in PromotionProgramMain table by this date
                // $programMain = PromotionProgramMain::where('dteCreatedAt', date('Y-m-d'))->first();
                $promotionProgramDetails = PromotionProgramDetails::create([
                    'intProgramMainId' => (int) $programMain->intID,
                    'intParticipantId' => 1,
                    'strParticipantName' => $programlists['strParticipantName'],
                    'strAddress' => $programlists['strAddress'],
                    'strMobileNumber' => $programlists['strMobileNumber'],
                ]);
                $i++;
            }
            return $programMain;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    /**
     * update Program Main by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated Program Main object
     */
    public function updatePromotionProgram(Request $request, $id)
    {
        try {
            PromotionProgramMain::where('intID', $id)
                ->update([
                    'intUnitId' => $request->intUnitId,
                    'strProgramTypeName' => $request->strProgramTypeName,
                    'strVenueName' => $request->strVenueName,
                    'intCreatedBy' => $request->intCreatedBy,
                    'dteCreatedAt' => $request->dteCreatedAt,
                ]);
            // return $id;
            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show voyege activity boiler by id
     *
     * @param integer $id
     * @return object voyage activity boiler object
     */
    public function show($id)
    {
        $id = (int) $id;

        try {
            $promotionProgramMain = PromotionProgramMain::findOrFail($id);
            return $promotionProgramMain;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Promotion ProgramMain Not Found !');
        }
    }

    /**
     * delete eng Or Consultant by id
     *
     * @param integer $id
     * @return object Deleted eng Or Consultant Object
     */
    public function promotionProgramDelete($id)
    {
        try {
            $promotionProgramMain = $this->show($id);
            $promotionProgramMain->delete();
            return $promotionProgramMain;
        } catch (\Exception $e) {
            return false;
        }
    }
}
