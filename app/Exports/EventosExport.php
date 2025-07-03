<?php

namespace App\Exports;

use App\Models\Evento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class EventosExport implements FromView
{
    public function view(): View
    {
        return view('eventos.exportar_excel', [
            'eventos' => Evento::with('tipoEvento', 'fauna', 'institucion')
                ->where('user_id', Auth::id()) // Filtra por usuario actual, si aplica
                ->whereHas('fauna')            // Solo eventos con fauna existente
                ->latest()
                ->get()
        ]);
    }
}
