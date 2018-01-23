<?php

namespace Framework;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'role_id', 'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function findForPassport( $username ) {
        return $this->where( 'username', $username )->first();
    }

    public function role() {
        return $this->belongsTo( 'Framework\Role', 'role_id' );
    }

    public function company() {
        return $this->belongsTo( 'Framework\Company', 'company_id' );
    }
}
