<?php

namespace Modules\Auth\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;
    use SoftDeletes;

    protected $table = "tblLoginUser";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'id';
    protected $fillable = [
        'intEnroll',
        'business_id',
        'first_name',
        'surname',
        'last_name',
        'username',
        'email',
        'phone_no',
        'password',
        'language',
        'intUserTypeID'
    ];
    protected $guard_name = 'api';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
