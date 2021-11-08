<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Entities\Customer;

class SalesOrder extends Model
{
    protected $fillable = [
        'intId',
        'strCode',
        'dteDate',
        'dteReqDelivaryDate',
        'intUnitId',
        'intCustomerId',
        'intSalesOffId',
        'numConversionRate',
        'intShipPointId',
        'intCustomerType',
        'strAddress',
        'strOtherInfo',
        'ysnEnable',
        'ysnCompleted',
        'dteInsertionTime',
        'intInsertedBy',
        'monTotalAmount',
        'numPieces',
        'numApprPieces',
        'numRestPieces',
        'intPriceVarId',
        'intVehicleVarId',
        'monExtraAmount',
        'strExtraCause',
        'strNarration',
        'ysnLogistic',
        'intChargeId',
        'numCharge',
        'intCurrencyId',
        'intSalesTypeId',
        'intIncentiveId',
        'numIncentive',
        'strContactAt',
        'strPhone',
        'monForceCredit',
        'monFCBy',
        'dteFCTime',
        'ysnSiteDelivery',
        'ysnActiveForRestQnt',
        'monPricewithoutDiscount',
        'ysnSubmitByCustomer'
    ];
    protected $table = "tblSalesOrder";
    protected $connection = 'ERP_SAD';
    protected $primaryKey = 'intId';

    public function details()
    {
        return $this->hasMany(SalesOrderDetails::class, 'intSOId', 'intId');
    }
    public function customers()
    {
        return $this->hasMany(Customer::class, 'intCusID', 'intId');
    }
    public function distributors()
    {
        return $this->hasMany(Customer::class, 'intCusID', 'intId');
    }
}
