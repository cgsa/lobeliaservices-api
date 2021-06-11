<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaDeudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlcomopago')->create('consulta_deudas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('email', 100);
            $table->string('email_nuevo', 100);
            $table->boolean('notificacion')->default(false);
            $table->string('telefono',15)->nullable(true);
            $table->integer('id_entidad');
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
        Schema::connection('mysqlcomopago')->dropIfExists('consulta_deudas');
    }
}
