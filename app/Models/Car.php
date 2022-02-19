<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['enrollment','type_car_id','client_id','state'];
    protected $hidden = ['created_at','updated_at'];

    public function client(){

        return $this->belongsTo('App\Models\Client');
    }

    public function typeCar(){

        return $this->belongsTo('App\Models\TypeCar');
    }

}
