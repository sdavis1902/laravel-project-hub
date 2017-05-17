<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser {

    use SoftDeletes;

    protected $dates = ['deleted_at', 'last_login'];
    protected $fillable = ['first_name', 'last_name', 'company', 'address1', 'address2', 'city', 'state', 'country', 'zip', 'phone', 'fax', '2fa', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
}
