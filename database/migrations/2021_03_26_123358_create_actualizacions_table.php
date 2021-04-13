<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualizacionsTable extends Migration
{
    
    public $timestamps = false;
    
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('actualizacions', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');            
            $table->integer('documento_deudor');
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
        Schema::connection('mysql')->dropIfExists('actualizacions');
    }
}
