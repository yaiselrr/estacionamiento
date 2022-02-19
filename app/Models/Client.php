<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name'];
    protected $hidden = ['created_at','updated_at'];

    public function cars(){

        return $this->hasMany('App\Models\Car');
    }

}
