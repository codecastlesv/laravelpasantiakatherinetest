<?php

namespace App\Enums;

enum EstadoTarea: string
{
    case PENDIENTE = 'pendiente';
    case EN_PROGRESO = 'en progreso';
    case COMPLETADA = 'completada';
}
