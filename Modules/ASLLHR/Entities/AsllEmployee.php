<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\Vessel;

class AsllEmployee extends Model
{
    protected $table = "tblasllemployee";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';


    public function bankdetails()
    {
        return $this->hasMany(AsllEmployeeBankDetails::class, 'intEmployeeId');
    }

    public function certificates()
    {
        return $this->hasMany(AsllEmployeeCertificate::class, 'intEmployeeId');
    }

    public function documents()
    {
        return $this->hasMany(AsllEmployeeDocument::class, 'intEmployeeId');
    }

    public function educations()
    {
        return $this->hasMany(AsllHrEmployeeEducation::class, 'intEmployeeId');
    }

    public function records()
    {
        return $this->hasMany(AsllEmployeeRecord::class, 'intEmployeeId');
    }

    public function references()
    {
        return $this->hasMany(AsllEmployeeReference::class, 'intEmployeeId');
    }

    public function vessel()
    {
        return $this->hasOne(Vessel::class, 'intID', 'intVesselID');
    }

    public function status()
    {
        return $this->hasOne(EmployeeSignInOut::class, 'intEmployeeId', 'intID')->orderBy('tblEmployeeSignInOut.intID','desc');
    }

    public static function getEmployeeIdByPassport($passport)
    {
        $intEmployeeId = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployee")
            ->where('strType', 'Passport')
            ->where('strNumber', $passport)
            ->value('intEmployeeId');

        return $intEmployeeId;
    }

    public static function getEmployeeByCDC($strCDCNo)
    {
        $employee = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployee")
            ->where('strCDCNo', $strCDCNo)
            ->first();

        return $employee;
    }
}
