

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-6 text-center">📋 Crear Historial Clínico</h1>

    <?php if($errors->any()): ?>
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('historial.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>

        
       <div>
    <label for="fauna_id" class="block font-semibold mb-1">Animal</label>
    <select name="fauna_id" id="fauna_id" class="w-full border px-4 py-2 rounded select-buscable" required>
        <option value="">-- Selecciona un animal --</option>
        <?php $__currentLoopData = $faunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fauna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($fauna->id); ?>" <?php echo e(old('fauna_id', $faunaIdSeleccionado ?? '') == $fauna->id ? 'selected' : ''); ?>>
                <?php echo e($fauna->codigo); ?> - <?php echo e($fauna->nombre_comun ?? 'Sin nombre'); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

        
        <div>
            <label for="fecha" class="block font-semibold mb-1">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo e(old('fecha')); ?>" class="w-full border px-4 py-2 rounded" required>
        </div>

        
        <div class="bg-gray-50 p-4 rounded">
            <h2 class="text-xl font-bold mb-4">Examen General</h2>

            <?php
                $campos = [
                    'condicion_corporal' => 'Condición Corporal',
                    'boca' => 'Boca',
                    'piel' => 'Piel y Anexos',
                    'musculo_esqueletico' => 'Músculo Esquelético',
                    'abdomen' => 'Abdomen',
                    'frecuencia_cardiaca' => 'Frecuencia Cardíaca',
                    'frecuencia_respiratoria' => 'Frecuencia Respiratoria',
                    'temperatura' => 'Temperatura',
                    'mucosas' => 'Examen de Mucosas',
                    'plumas_pico_garras' => 'En caso de aves: Plumas, Pico, Garras',
                    'caparazon_plastrom' => 'En caso de reptiles: Caparazón, Plastrom, Cabeza, Miembros anteriores y posteriores',
                ];
            ?>

            <?php $__currentLoopData = $campos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-4">
                    <label for="<?php echo e($name); ?>" class="block font-semibold mb-1"><?php echo e($label); ?></label>
                    <textarea name="examen_general[<?php echo e($name); ?>]" id="<?php echo e($name); ?>" rows="2" class="w-full border px-4 py-2 rounded"><?php echo e(old("examen_general.$name")); ?></textarea>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <label for="foto" class="block text-lg font-bold text-gray-900 mt-6">Fotografía del Animal</label>
        <div id="dropzone" class="dropzone">
            <p id="dropzone-text">Haz clic o arrastra una imagen aquí</p>
            <input type="file" name="foto_animal" id="foto" accept="image/*" class="hidden">
        </div>

        <img id="foto-preview" src="#" alt="Vista previa de la foto" />
        <button type="button" id="remove-btn">Eliminar Imagen</button>
        <input type="hidden" name="foto_base64" id="foto-base64" />

        
        <div>
            <label for="etologia" class="block font-semibold mb-1">Comportamiento (Etología)</label>
            <textarea name="etologia" id="etologia" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('etologia')); ?></textarea>
        </div>

        <div>
            <label for="diagnostico" class="block font-semibold mb-1">Diagnóstico</label>
            <textarea name="diagnostico" id="diagnostico" rows="3" class="w-full border px-4 py-2 rounded" required><?php echo e(old('diagnostico')); ?></textarea>
        </div>

        <div>
            <label for="tratamiento" class="block font-semibold mb-1">Tratamiento</label>
            <textarea name="tratamiento" id="tratamiento" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('tratamiento')); ?></textarea>
        </div>

        <div>
            <label for="observaciones" class="block font-semibold mb-1">Evolución / Observaciones</label>
            <textarea name="observaciones" id="observaciones" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('observaciones')); ?></textarea>
        </div>

        <div>
            <label for="nutricion" class="block font-semibold mb-1">Nutrición</label>
            <textarea name="nutricion" id="nutricion" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('nutricion')); ?></textarea>
        </div>

        <div>
            <label for="pruebas_laboratorio" class="block font-semibold mb-1">Pruebas de Laboratorio</label>
            <textarea name="pruebas_laboratorio" id="pruebas_laboratorio" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('pruebas_laboratorio')); ?></textarea>
        </div>

        
        <div>
            <label for="archivo_laboratorio" class="block font-semibold mb-1">Archivo de Resultados de Laboratorio (PDF o Imagen)</label>
            <input type="file" name="archivo_laboratorio" id="archivo_laboratorio" accept=".pdf,image/*" class="w-full border px-4 py-2 rounded">
            <small class="text-gray-500">Opcional. Formatos permitidos: PDF, JPG, PNG.</small>
        </div>

        <div>
            <label for="recomendaciones" class="block font-semibold mb-1">Recomendaciones</label>
            <textarea name="recomendaciones" id="recomendaciones" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('recomendaciones')); ?></textarea>
        </div>

        
        <div class="flex justify-between items-center mt-6 max-w-md mx-auto p-4 bg-white rounded shadow">
            <a href="<?php echo e(route('historial.index')); ?>" class="text-blue-600 font-semibold hover:text-blue-800 hover:underline transition-colors duration-300">← Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none">Guardar</button>
        </div>
    </form>
</div>


<script>
const dropzone = document.getElementById('dropzone');
const input = document.getElementById('foto');
const preview = document.getElementById('foto-preview');
const removeBtn = document.getElementById('remove-btn');
const base64Input = document.getElementById('foto-base64');

const toBase64 = (file) => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = reject;
});

async function handleFile(file) {
    if (!file || !file.type.startsWith('image/')) return;
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
    removeBtn.style.display = 'inline-block';
    const base64 = await toBase64(file);
    base64Input.value = base64;
}

input.addEventListener('change', (e) => handleFile(e.target.files[0]));
dropzone.addEventListener('click', () => input.click());
dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('dragover');
});
dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
});
dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
        input.files = e.dataTransfer.files;
        handleFile(file);
    }
});
removeBtn.addEventListener('click', () => {
    preview.src = '#';
    preview.style.display = 'none';
    input.value = '';
    base64Input.value = '';
    removeBtn.style.display = 'none';
});
</script>

<style>
.dropzone {
    border: 2px dashed #ccc;
    border-radius: 0.5rem;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s ease;
}
.dropzone:hover { border-color: #2563eb; }
.dropzone.dragover {
    border-color: #1d4ed8;
    background-color: #f0f9ff;
}
#foto-preview {
    max-width: 300px;
    margin-top: 10px;
    border-radius: 8px;
    display: none;
}
#remove-btn {
    display: none;
    margin-top: 10px;
    background-color: #ef4444;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}
#remove-btn:hover { background-color: #dc2626; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/historial/create.blade.php ENDPATH**/ ?>