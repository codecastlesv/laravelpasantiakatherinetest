<?php

namespace App\Models;

use App\Enums\EstadoTarea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Tarea extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $table = 'tarea';

    protected $dates = ['deleted_at'];

    protected $fillable = ['nombre', 'descripcion', 'estado', 'proyecto_id'];

    protected $casts = [
        'estado' => EstadoTarea::class,
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
            'estado' => $this->estado,
        ];
    }
}
