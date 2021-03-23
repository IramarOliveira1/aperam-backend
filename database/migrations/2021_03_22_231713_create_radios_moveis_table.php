<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadiosMoveisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radios_moveis', function (Blueprint $table) {
            $table->id();
            $table->string('patrimonio');
            $table->string('radio_modelo');
            $table->string('numero_serie');
            $table->string('veiculo_modelo');
            $table->string('placa');
            $table->string('regiao');
            $table->string('responsavel');
            $table->string('departamento');
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
        Schema::dropIfExists('radios_moveis');
    }
}
