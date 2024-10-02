<?php

use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;

Route::get('/proyectos/tareas', [ProyectoController::class, 'proyectosTareas']);
