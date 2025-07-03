<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transferencia;
use App\Models\Fauna;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RecepcionController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $codigo = $request->input('codigo');

    $transferencias = Transferencia::with(['fauna.user.institucion'])
        ->where('institucion_destino', $user->institucion_id)
        ->where('estado', 'aceptado')
        ->when($codigo, function ($query, $codigo) {
            $query->whereHas('fauna', fn($q) => $q->where('codigo', 'like', "%$codigo%"));
        })
        ->get();

    // Agregar faunas registradas en la institución del usuario
    $faunas = Fauna::with(['user.institucion'])
        ->whereHas('user', function ($q) use ($user) {
            $q->where('institucion_id', $user->institucion_id);
        })
        ->get();

    return view('recepciones.index', compact('transferencias', 'faunas'));
}

    public function exportarPDF($faunaId)
{
    $fauna = Fauna::with(['user.institucion', 'historialesClinicos'])
        ->findOrFail($faunaId);

    $fotoPath = null;
    if ($fauna->foto && file_exists(public_path('storage/' . $fauna->foto))) {
        $fotoPath = public_path('storage/' . $fauna->foto);
    }

    $pdf = Pdf::loadView('recepciones.pdf', compact('fauna', 'fotoPath'));
    return $pdf->download('fauna_' . $fauna->codigo . '.pdf');
}


}
