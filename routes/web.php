<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Fauna;
use App\Models\Institucion;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ParteController;
use App\Http\Controllers\FaunaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LiberacionController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\FaunaDocumentoController;
use Lab404\Impersonate\Controllers\ImpersonateController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Rutas Públicas (sin autenticación)
|--------------------------------------------------------------------------
*/


Route::impersonate(); // Esto agrega las rutas necesarias automáticamente

Route::middleware(['auth'])->group(function () {
    // Dashboard administración
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Eliminar usuario desde panel admin
    Route::delete('/admin/usuarios/{id}', [AdminController::class, 'destroy'])->name('admin.usuarios.destroy');

    // Ver perfil usuario
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');

    // Editar usuario
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');

    // Eliminar usuario
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    // **Crear usuario - ruta que falta**
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');

    Route::get('/usuarios/{usuario}/fauna', [App\Http\Controllers\UserController::class, 'getFauna']);
Route::get('/usuarios/{usuario}/historiales', [App\Http\Controllers\UserController::class, 'getHistoriales']);

});

Route::middleware(['auth'])->group(function () {
    Route::get('/publicaciones/{publication}', [PublicationController::class, 'show'])->name('publication.show');
});
Route::get('/', function () {
    $publications = \App\Models\Publication::latest()->get();
    return view('welcome', compact('publications'));
});

Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('publication', PublicationController::class);
Route::resource('videos', VideoController::class);

Route::get('/fauna/plantilla-descarga', function () {
    $filePath = storage_path('app/public/plantilla-fauna.pdf');

    if (!file_exists($filePath)) {
        abort(404, 'El archivo no existe.');
    }

    return response()->download($filePath, 'plantilla-fauna.pdf', [
        'Content-Type' => 'application/pdf',
    ]);
})->name('fauna.plantillaDescarga');

/*
|--------------------------------------------------------------------------
| Rutas Autenticadas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Perfil
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.show');
    Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/editar', [PerfilController::class, 'update'])->name('perfil.update');

    // Registro personalizado con instituciones
    Route::get('register', function () {
        $instituciones = Institucion::all();
        return view('auth.register', compact('instituciones'));
    })->name('register');

    // Fauna
    Route::get('fauna/reporte/pdf', [FaunaController::class, 'reportePdf'])->name('fauna.reporte.pdf');
    Route::get('fauna/reporte/excel', [FaunaController::class, 'reporteExcel'])->name('fauna.reporte.excel');
    Route::get('/fauna/{id}/pdf', [FaunaController::class, 'exportPDF'])->name('fauna.pdf');
    Route::get('/fauna/duplicar/{id}', [FaunaController::class, 'duplicar'])->name('fauna.duplicar');
    Route::resource('fauna', FaunaController::class);
    Route::post('/fauna/generar-codigo-preview', [FaunaController::class, 'generarCodigoPreview']);


    // Documentos de Fauna
    Route::prefix('fauna/{fauna}/documentos')->name('fauna.documentos.')->group(function () {
        Route::get('/', [FaunaDocumentoController::class, 'index'])->name('index');
        Route::get('/crear', [FaunaDocumentoController::class, 'create'])->name('create');
        Route::post('/', [FaunaDocumentoController::class, 'store'])->name('store');
        Route::delete('/{id}', [FaunaDocumentoController::class, 'destroy'])->name('destroy');
    });
    Route::get('documentos/{documentoId}/descargar', [FaunaDocumentoController::class, 'download'])->name('fauna.documentos.download');

    Route::prefix('liberaciones')->name('liberaciones.')->group(function () {
    // Exportar primero para evitar que se confundan con {liberacion}
    Route::get('/exportar/pdf', [LiberacionController::class, 'exportPdf'])->name('exportPdf');
    Route::get('/exportar/excel', [LiberacionController::class, 'exportExcel'])->name('exportExcel');

    Route::get('/', [LiberacionController::class, 'index'])->name('index');
    Route::get('/create', [LiberacionController::class, 'create'])->name('create');
    Route::post('/', [LiberacionController::class, 'store'])->name('store');

    Route::get('/{liberacion}/pdf', [LiberacionController::class, 'exportPdfIndividual'])->name('exportPdfIndividual');
    Route::get('/{liberacion}', [LiberacionController::class, 'show'])->name('show');
    Route::get('/{liberacion}/edit', [LiberacionController::class, 'edit'])->name('edit');
    Route::put('/{liberacion}', [LiberacionController::class, 'update'])->name('update');
    Route::patch('/{liberacion}', [LiberacionController::class, 'update']);
    Route::delete('/{liberacion}', [LiberacionController::class, 'destroy'])->name('destroy');

    Route::get('/buscar-codigo/{codigo}', [LiberacionController::class, 'buscarPorCodigo'])->name('buscarPorCodigo');
});


    // Partes y derivados
    Route::prefix('partes')->name('partes.')->group(function () {
    Route::get('/', [ParteController::class, 'index'])->name('index');
    Route::get('/create', [ParteController::class, 'create'])->name('create');
    Route::post('/', [ParteController::class, 'store'])->name('store');

    // Exportaciones: colocar antes de las rutas con {parte}
    Route::get('/export-pdf', [ParteController::class, 'exportPdf'])->name('exportPdf');
    Route::get('/export-excel', [ParteController::class, 'exportExcel'])->name('exportExcel');

    Route::get('/{id}/duplicar', [ParteController::class, 'duplicar'])->name('duplicar');
    Route::get('/{id}/pdf', [ParteController::class, 'generarPDF'])->name('pdf');
    Route::get('/{parte}', [ParteController::class, 'show'])->name('show');
    Route::get('/{parte}/edit', [ParteController::class, 'edit'])->name('edit');
    Route::patch('/{parte}', [ParteController::class, 'update'])->name('update');
    Route::delete('/{parte}', [ParteController::class, 'destroy'])->name('destroy');
});


    // Recepciones
    Route::get('/recepciones', [RecepcionController::class, 'index'])->name('recepciones.index');
    Route::get('/recepciones/{fauna}/pdf', [RecepcionController::class, 'exportarPDF'])->name('recepciones.pdf');

    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');

    // Historial Clínico
    Route::prefix('historial')->name('historial.')->group(function () {
        Route::get('reporte-pdf', [HistorialClinicoController::class, 'reportePdf'])->name('reportePdf');
        Route::get('reporte-excel', [HistorialClinicoController::class, 'reporteExcel'])->name('reporteExcel');
        Route::get('create', [HistorialClinicoController::class, 'create'])->name('create');
        Route::post('store', [HistorialClinicoController::class, 'store'])->name('store');
        Route::get('/', [HistorialClinicoController::class, 'index'])->name('index');
        Route::get('{id}/edit', [HistorialClinicoController::class, 'edit'])->name('edit')->where('id', '[0-9]+');
        Route::get('{id}/pdf', [HistorialClinicoController::class, 'exportarPDF'])->name('pdf')->where('id', '[0-9]+');
        Route::get('{id}/duplicar', [HistorialClinicoController::class, 'duplicate'])->name('duplicate')->where('id', '[0-9]+');
        Route::get('{id}/descargar-archivo', [HistorialClinicoController::class, 'descargarArchivo'])->name('descargarArchivo')->where('id', '[0-9]+');
        Route::put('{id}', [HistorialClinicoController::class, 'update'])->name('update')->where('id', '[0-9]+');
        Route::delete('{id}', [HistorialClinicoController::class, 'destroy'])->name('destroy')->where('id', '[0-9]+');
        Route::get('{id}', [HistorialClinicoController::class, 'show'])->name('show')->where('id', '[0-9]+');
    });

    // Transferencias
    Route::resource('transferencias', TransferenciaController::class)->except(['show']);
    Route::get('transferencias/{id}/pdf', [TransferenciaController::class, 'pdf'])->name('transferencias.pdf');
    Route::post('transferencias/{id}/aceptar', [TransferenciaController::class, 'aceptar'])->name('transferencias.aceptar');
    Route::post('transferencias/{id}/rechazar', [TransferenciaController::class, 'rechazar'])->name('transferencias.rechazar');
    Route::post('transferencias/{id}/change-status', [TransferenciaController::class, 'changeStatus'])->name('transferencias.changeStatus');
    Route::get('transferencias/recepciones', [TransferenciaController::class, 'recepciones'])->name('transferencias.recepciones');
    Route::get('transferencias/{id}', [TransferenciaController::class, 'show'])->name('transferencias.show');
    Route::get('reporte/pdf', [TransferenciaController::class, 'reportePdf'])->name('transferencias.reportePdf');
    Route::get('reporte/excel', [TransferenciaController::class, 'reporteExcel'])->name('transferencias.reporteExcel');

    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/create', [ReporteController::class, 'create'])->name('create');
        Route::post('/store', [ReporteController::class, 'store'])->name('store');
        Route::get('/{id}', [ReporteController::class, 'show'])->name('show');
        Route::get('/{id}/export-pdf', [ReporteController::class, 'exportPDF'])->name('exportPDF');
        Route::get('/{id}/excel', [ReporteController::class, 'exportExcel'])->name('exportExcel');
        Route::post('/historial', [ReporteController::class, 'historialClinicoReporte'])->name('historial');
        Route::post('/transferencia', [ReporteController::class, 'transferenciaReporte'])->name('transferencia');
        Route::get('/{id}/export-pdf/preview', [ReporteController::class, 'previewPDF'])->name('exportPDF.preview');

    });

    // Eventos
    Route::prefix('eventos')->name('eventos.')->group(function () {
        Route::get('/pdf', [EventoController::class, 'exportarPDF'])->name('pdf');
        Route::get('/todos', [EventoController::class, 'todos'])->name('todos');
        Route::get('/exportar-excel', [EventoController::class, 'exportarExcel'])->name('exportar_excel');
        Route::get('/', [EventoController::class, 'index'])->name('index');
        Route::get('/create/{tipo?}', [EventoController::class, 'create'])->name('create');
        Route::post('/', [EventoController::class, 'store'])->name('store');
        Route::get('/{evento}/edit', [EventoController::class, 'edit'])->name('edit');
        Route::put('/{evento}', [EventoController::class, 'update'])->name('update');
        Route::get('/{evento}/exportar-pdf', [EventoController::class, 'exportarPDFEvento'])->name('exportar_pdf_individual');
        Route::get('/fauna/{codigo}', [FaunaController::class, 'getByCodigo'])->name('fauna.codigo');
        Route::get('/{evento}', [EventoController::class, 'show'])->name('show');
        Route::delete('/{evento}', [EventoController::class, 'destroy'])->name('destroy');
    });

    // Publicaciones internas
    Route::resource('publicaciones', PublicationController::class);
});

/*
|--------------------------------------------------------------------------
| API pública
|--------------------------------------------------------------------------
*/
Route::get('/api/fauna/{codigo}', function ($codigo) {
    $codigo = Str::lower(trim($codigo));
    $animal = Fauna::whereRaw('LOWER(TRIM(codigo)) = ?', [$codigo])->first();

    if (!$animal) {
        return response()->json(['message' => 'Animal no encontrado'], 404);
    }

    return response()->json($animal);
});

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
