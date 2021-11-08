<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class FeedBackType extends Model
{
    protected $fillable = [
        'strFeedbackTypeName',
        'intFeedbackTypeId',
        'dteCreatedAt',
        'ysnActive',
    ];
    protected $casts = [
        'intFeedbackTypeId' => 'integer',
    ];
    protected $table = "tblFeedBackType";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';

}