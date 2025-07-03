<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
 public function dashboard()
{
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'];
    $registros = [12, 19, 7, 5, 10, 8]; // Aquí tus datos reales

    return view('dashboard', compact('meses', 'registros'));

}

}
