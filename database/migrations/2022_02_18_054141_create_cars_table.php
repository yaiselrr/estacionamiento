<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('enrollment',10)->unique();
            
            $table->bigInteger('type_car_id')->unsigned(); 
            $table->foreign('type_car_id')->references('id')->on('type_cars');
            
            $table->bigInteger('client_id')->unsigned(); 
            $table->foreign('client_id')->references('id')->on('clients');

            $table->string('state',13);

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
