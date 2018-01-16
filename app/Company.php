<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [ 'nif', 'name', 'email', 'phone', 'address', 'logo_url'  ];
}
