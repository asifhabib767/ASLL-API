<?php

namespace Modules\Item\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    protected $table = "tblItemList";
    protected $connection = 'ERP_Inventory';
    protected $primaryKey = 'intItemID';
    protected $fillable = [
        'strItemName',
        'strDescription',
        'strUoM',
        'intCategoryID',
        'strCategory',
        'strSubCategory',
        'strItemFullName'
    ];

    protected $appends = ["Quantity", "strShortDescription"];
    
    public function getQuantityAttribute() {
        return 1;
    }
    
    public function getStrShortDescriptionAttribute() {
        return substr($this->strDescription, 0, 10);
    }
}
