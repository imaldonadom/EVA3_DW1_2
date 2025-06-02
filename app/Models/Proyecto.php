<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Proyecto extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'created_by',
    ];

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }
}
