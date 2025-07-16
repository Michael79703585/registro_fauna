<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EventosExport implements FromView
{
    protected $eventos;

    public function __construct($eventos)
    {
        $this->eventos = $eventos;
    }

    public function view(): View
    {
        return view('eventos.exportar_excel', [
            'eventos' => $this->eventos
        ]);
    }
}
