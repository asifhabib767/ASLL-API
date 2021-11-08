<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class SalesOrderDetails extends Model
{
    protected $fillable = [
        'intId',
        'intSOId',
        'intProductId',
        'numQuantity',
        'numApprQuantity',
        'monPrice',
        'intCOAAccId',
        'strCOAAccName',
        'monConversionRate',
        'intCurrencyID',
        'intExtraId',
        'monExtraPrice',
        'intUom',
        'strNarration',
        'intSalesType',
        'intVehicleVarId',
        'numPromotion',
        'monCommission',
        'intIncentiveId',
        'numIncentive',
        'monSuppTax',
        'monVAT',
        'monVatPrice',
        'intPromItemId',
        'strPromItemName',
        'intPromUOM',
        'monPromPrice',
        'intPromItemCOAId',
        'ysnEnable',
        'dteInsertionTime',
        'intInsertedBy',
        'numWeight',
        'numVolume',
        'numPromWeight',
        'numPromVolume',
        'decDiscountAmount',
        'decDiscountRate'
    ];
    protected $table = "tblSalesOrderDetails";
    protected $connection = 'ERP_SAD';
    protected $primaryKey = 'intId';
}
