<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'intUnitId',
        'strTaskTitle',
        'strTaskDetails',
        'strTaskUpdateDetails',
        'intAssignedTo',
        'intAssignedBy',
        'intUpdatedBy',
        'ysnSeenByAssignedTo',
        'ysnUpdateSeenByAssignedBy',
        'dteCreatedAt',
        'ysnOwnAssigned',
        'dteTaskStartDateTime',
        'dteTaskEndDateTime',
        'status',
    ];
    protected $table = "tblTasks";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intTaskId';
}
