

<?php $__env->startSection('title', 'Registrar Liberación'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-6 text-center">🕊️ Registrar Liberación</h1>

    <?php if($errors->any()): ?>
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('liberaciones.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>

        
        <div>
    <label for="fauna_id" class="block font-semibold mb-1">Código (elige un registro)</label>
    <select name="fauna_id" id="fauna_id" class="w-full border px-4 py-2 rounded select-buscable" required>
        <option value="">-- Selecciona un animal --</option>
        <?php $__currentLoopData = $faunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fauna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($fauna->id); ?>" <?php echo e(old('fauna_id', $faunaIdSeleccionado ?? '') == $fauna->id ? 'selected' : ''); ?>>
                <?php echo e($fauna->codigo); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>


        
        <div>
            <label for="fecha" class="block font-semibold mb-1">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo e(old('fecha')); ?>" required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="lugar_liberacion" class="block font-semibold mb-1">Lugar de liberación</label>
            <input type="text" name="lugar_liberacion" id="lugar_liberacion" value="<?php echo e(old('lugar_liberacion')); ?>" required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="departamento" class="block font-semibold mb-1">Departamento</label>
            <input type="text" name="departamento" id="departamento" value="<?php echo e(old('departamento')); ?>" required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="municipio" class="block font-semibold mb-1">Municipio</label>
            <input type="text" name="municipio" id="municipio" value="<?php echo e(old('municipio')); ?>" required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
    <label for="coordenadas" class="block font-semibold mb-1">Coordenadas</label>
    <input type="text" name="coordenadas" id="coordenadas" value="<?php echo e(old('coordenadas')); ?>"
           class="w-full border px-4 py-2 rounded mb-2">

    <!-- Mapa -->
    <div id="map" style="height: 300px;" class="rounded border"></div>
</div>


        
        <div>
            <label for="responsable" class="block font-semibold mb-1">Responsable</label>
            <input type="text" name="responsable" id="responsable" value="<?php echo e(old('responsable')); ?>"
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="institucion" class="block font-semibold mb-1">Institución</label>
            <input type="text" id="institucion" name="institucion" readonly
                   value="<?php echo e(Auth::user()->institucion->nombre ?? 'Sin institución asignada'); ?>"
                   class="w-full border px-4 py-2 rounded bg-gray-100">
        </div>

        
        <div>
            <label for="observaciones" class="block font-semibold mb-1">Observaciones</label>
            <textarea name="observaciones" id="observaciones" rows="3"
                      class="w-full border px-4 py-2 rounded"><?php echo e(old('observaciones')); ?></textarea>
        </div>

        
        <div>
            <label for="foto" class="block font-semibold mb-1">Fotografía</label>
            <input type="file" name="foto" id="foto"
                   class="w-full border px-4 py-2 rounded bg-white 
                          file:mr-4 file:py-2 file:px-4 file:border-0 
                          file:text-sm file:bg-blue-100 file:text-blue-700 
                          hover:file:bg-blue-200">
        </div>

        
        <div class="flex justify-between items-center mt-6 max-w-md mx-auto p-4 bg-white rounded shadow">
            <a href="#"
               onclick="event.preventDefault(); history.back();"
               class="text-blue-600 font-semibold hover:text-blue-800 hover:underline transition-colors duration-300">
                ← Cancelar
            </a>

            <button type="submit"
                class="bg-green-600 text-white font-semibold px-6 py-2 rounded shadow-md 
                       hover:bg-green-700 hover:scale-105 transform transition duration-300 ease-in-out
                       focus:outline-none focus:ring-4 focus:ring-green-300">
                Guardar
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // URL base para la llamada AJAX
    const baseUrl = "<?php echo e(url('liberaciones/buscar-codigo')); ?>";

    document.addEventListener("DOMContentLoaded", function () {
        const codigoSelect = document.getElementById('codigo');
        if (!codigoSelect) {
            console.error("No se encontró el <select id='codigo'>");
            return;
        }

        codigoSelect.addEventListener('change', function () {
            const codigo = this.value.trim();
            console.log("Se seleccionó código:", codigo);

            if (codigo.length === 0) {
                // Si deseleccionan o eligen la opción vacía, limpiar campos
                document.getElementById('especie').value      = '';
                document.getElementById('nombre_comun').value = '';
                document.getElementById('tipo_animal').value  = '';
                return;
            }

            const fetchUrl = `${baseUrl}/${encodeURIComponent(codigo)}`;
            console.log("Fetch a:", fetchUrl);

            fetch(fetchUrl)
                .then(response => {
                    console.log("Respuesta HTTP:", response.status);
                    if (!response.ok) {
                        throw new Error("Código no encontrado en servidor");
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("JSON recibido:", data);
                    if (data.success) {
                        document.getElementById('especie').value      = data.data.especie      || '';
                        document.getElementById('nombre_comun').value = data.data.nombre_comun || '';
                        document.getElementById('tipo_animal').value  = data.data.tipo_animal  || '';
                    } else {
                        alert(data.message || "No se encontraron datos.");
                        document.getElementById('especie').value = '';
                        document.getElementById('nombre_comun').value = '';
                        document.getElementById('tipo_animal').value = '';
                    }
                })
                .catch(error => {
                    console.error("Error en fetch:", error);
                    alert("Error al buscar datos para ese código.");
                    document.getElementById('especie').value = '';
                    document.getElementById('nombre_comun').value = '';
                    document.getElementById('tipo_animal').value = '';
                });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/liberaciones/create.blade.php ENDPATH**/ ?>