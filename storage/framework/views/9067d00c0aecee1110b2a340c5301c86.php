

<?php $__env->startSection('title', 'Editar Perfil'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto mt-10 bg-white p-10 rounded-2xl shadow-xl border border-blue-100">
    <h2 class="text-3xl font-bold text-blue-800 mb-8 uppercase tracking-wide">
        ✏️ Editar Perfil
    </h2>

    <!-- Mensaje de éxito -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded shadow-sm">
            ✅ <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded shadow-sm">
            <ul class="list-disc pl-6 space-y-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('perfil.update')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Nombre -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
            <input type="text" name="name" id="name"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   value="<?php echo e(old('name', $user->name)); ?>" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo Electrónico</label>
            <input type="email" name="email" id="email"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   value="<?php echo e(old('email', $user->email)); ?>" required>
        </div>

        <!-- Teléfono -->
        <div>
            <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
            <input type="text" name="telefono" id="telefono"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   value="<?php echo e(old('telefono', $user->telefono)); ?>">
        </div>

        <!-- Dirección -->
        <div>
            <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
            <input type="text" name="direccion" id="direccion"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   value="<?php echo e(old('direccion', $user->direccion)); ?>">
        </div>

        <!-- Institución -->
        <div>
            <label for="institucion_id" class="block text-sm font-semibold text-gray-700 mb-1">Institución</label>
            <select name="institucion_id" id="institucion_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">-- Seleccionar Institución --</option>
                <?php $__currentLoopData = $instituciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($inst->id); ?>" <?php echo e(old('institucion_id', $user->institucion_id) == $inst->id ? 'selected' : ''); ?>>
                        <?php echo e($inst->nombre); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Nueva Contraseña -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Nueva Contraseña</label>
            <input type="password" name="password" id="password"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <!-- Botón -->
        <div class="pt-4 text-right">
            <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-bold px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                💾 Guardar Cambios
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/perfil/editar.blade.php ENDPATH**/ ?>