<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'created_by'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }
}
