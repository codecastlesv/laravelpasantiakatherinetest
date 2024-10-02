<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Proyecto extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $table = 'proyecto';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio'
    ];

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
        ];
    }
}
