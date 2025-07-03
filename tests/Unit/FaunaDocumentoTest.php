<?php

namespace Tests\Unit;

use App\Models\Fauna;
use App\Models\FaunaDocumento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FaunaDocumentoTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_puede_crear_un_documento_para_una_fauna()
    {
        $storage = Storage::fake('public');

        $fauna = Fauna::factory()->create();

        $response = $this->post(route('fauna-documentos.store', $fauna->id), [
            'archivo' => UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf'),
            'tipo_documento' => 'Informe Médico',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('fauna_documentos', [
            'fauna_id' => $fauna->id,
            'tipo_documento' => 'Informe Médico',
        ]);
    }

    public function test_se_muestra_la_vista_index_con_los_documentos()
    {
        $fauna = Fauna::factory()->create();
        $documento = FaunaDocumento::factory()->create([
            'fauna_id' => $fauna->id,
        ]);

        $response = $this->get(route('fauna-documentos.index', $fauna->id));
        $response->assertStatus(200);
        $response->assertSee($documento->nombre_archivo);
    }

   public function test_se_puede_eliminar_un_documento()
{
    Storage::fake('public');

    $fauna = Fauna::factory()->create();

    $archivoPath = "faunas/{$fauna->id}/prueba.pdf";

    $documento = FaunaDocumento::factory()->create([
        'fauna_id' => $fauna->id,
        'ruta_archivo' => $archivoPath,
    ]);

    Storage::disk('public')->put($archivoPath, 'contenido');

    $response = $this->delete(route('fauna-documentos.destroy', [$fauna->id, $documento->id]));

    $response->assertRedirect();

    $this->assertDatabaseMissing('fauna_documentos', [
        'id' => $documento->id,
    ]);

    // Si assertMissing no funciona, usa assertFalse con exists()
    $this->assertFalse(Storage::disk('public')->exists($archivoPath));
}

}
