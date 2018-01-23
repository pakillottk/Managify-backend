<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [ 'permission', 'read', 'write', 'delete', 'role_id' ];

    public function role() {
        return $this->belongsTo( 'Framework\Role', 'role_id' );
    }
}
