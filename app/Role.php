<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [ 'role_name', 'company_id' ];

    public function users() {
        return $this->hasMany( 'Framework\User', 'role_id' );
    }

    public function company() {
        return $this->belongsTo( 'Framework\Company', 'company_id' );
    }

    public function permissions() {
        return $this->hasMany( 'Framework\Permission', 'role_id' );
    }
}
