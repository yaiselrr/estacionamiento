<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = ['enrollment','time_input','time_output','state'];
    protected $hidden = ['created_at','updated_at'];
}
