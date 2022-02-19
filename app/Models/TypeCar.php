<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeCar extends Model
{
    protected $fillable = ['type'];
    protected $hidden = ['created_at','updated_at'];

    public function cars(){

        return $this->hasMany('App\Models\Car');
    }
}
