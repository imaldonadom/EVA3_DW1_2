<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    //
    Schema::create('proyectos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->date('fecha_inicio');
        $table->string('estado');
        $table->string('responsable');
        $table->decimal('monto', 10, 2);
        $table->unsignedBigInteger('created_by');
        $table->foreign('created_by')->references('id')->on('usuarios');
        $table->timestamps();
    });
}