

<?php $__env->startSection('title', 'Nuevo Registro de Fauna'); ?>

<?php $__env->startSection('content'); ?>

<?php if($errors->any()): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded">
        <ul class="list-disc pl-5">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>


<?php
    $registro = isset($registroDuplicado) ? $registroDuplicado : null;
?>

<form action="<?php echo e(route('fauna.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
    <?php echo csrf_field(); ?>

    <!-- Fecha de Ingreso -->
    <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
    <input type="date" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo e(old('fecha_ingreso', $registroDuplicado->fecha_ingreso ?? '')); ?>" required class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Fecha de Recepción -->
    <label for="fecha_recepcion" class="block text-sm font-medium text-gray-700">Fecha de Recepción</label>
    <input type="date" id="fecha_recepcion" name="fecha_recepcion" value="<?php echo e(old('fecha_recepcion', $registroDuplicado->fecha_recepcion ?? '')); ?>" required class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Ciudad -->
    <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
    <input type="text" id="ciudad" name="ciudad" value="<?php echo e(old('ciudad', $registroDuplicado->ciudad ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Departamento -->
    <label for="departamento" class="block text-sm font-medium text-gray-700">Departamento</label>
    <input type="text" id="departamento" name="departamento" value="<?php echo e(old('departamento', $registroDuplicado->departamento ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Coordenadas -->
    <label for="coordenadas" class="block text-sm font-medium text-gray-700">Coordenadas</label>
<input type="text" id="coordenadas" name="coordenadas" value="<?php echo e(old('coordenadas', $registroDuplicado->coordenadas ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

<div id="map" class="mt-4" style="height: 400px;"></div>

    <!-- Tipo de Elemento -->
    <label for="tipo_elemento" class="block text-sm font-medium text-gray-700">Tipo de Elemento</label>
    <select name="tipo_elemento" id="tipo_elemento" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="Animal Vivo" <?php echo e(old('tipo_elemento', $registroDuplicado->tipo_elemento ?? '') == 'Animal Vivo' ? 'selected' : ''); ?>>Animal Vivo</option>
    </select>

    <!-- Motivo de Ingreso -->
    <label for="motivo_ingreso" class="block text-sm font-medium text-gray-700">Motivo de Ingreso</label>
    <select name="motivo_ingreso" id="motivo_ingreso" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Decomiso', 'Rescate', 'Captura', 'Otro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($opcion); ?>" <?php echo e(old('motivo_ingreso', $registroDuplicado->motivo_ingreso ?? '') == $opcion ? 'selected' : ''); ?>><?php echo e($opcion); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Lugar -->
    <label for="lugar" class="block text-sm font-medium text-gray-700">Lugar</label>
    <input type="text" name="lugar" id="lugar" value="<?php echo e(old('lugar', $registroDuplicado->lugar ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Institución Responsable -->
    <?php
    $usuario = Auth::user();
    $nombreInstitucion = $usuario->institucion->nombre ?? 'No asignado';
?>

<label for="institucion_remitente" class="block text-sm font-medium text-gray-700">
    Institución Responsable del Rescate
</label>
<input type="text" name="institucion_remitente" id="institucion_remitente"
       value="<?php echo e($nombreInstitucion); ?>"
       readonly
       class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed text-gray-700">


    <!-- Persona que recibe -->
    <label for="nombre_persona_recibe" class="block text-sm font-medium text-gray-700">Nombre de la Persona que Recibe</label>
    <input type="text" name="nombre_persona_recibe" id="nombre_persona_recibe" value="<?php echo e(old('nombre_persona_recibe', $registroDuplicado->nombre_persona_recibe ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Código asignado -->
    <label class="block text-sm font-medium text-gray-700">Código Asignado</label>
    <input type="text" value="Automático al guardar" disabled class="w-full border-gray-300 bg-gray-100 rounded-md shadow-sm">

    <!-- Especie -->
    <label for="especie" class="block text-sm font-medium text-gray-700 italic">Especie</label>
    <input type="text" id="especie" name="especie" value="<?php echo e(old('especie', $registroDuplicado->especie ?? '')); ?>" required class="w-full border-gray-300 rounded-md shadow-sm italic">

    <!-- Nombre Común -->
    <label for="nombre_comun" class="block text-sm font-medium text-gray-700">Nombre Común</label>
    <input type="text" id="nombre_comun" name="nombre_comun" value="<?php echo e(old('nombre_comun', $registroDuplicado->nombre_comun ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Tipo de animal -->
    <label for="tipo_animal" class="block text-sm font-medium text-gray-700">Tipo de Animal</label>
    <select name="tipo_animal" id="tipo_animal" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Mamífero', 'Ave', 'Reptil', 'Anfibio', 'Otro - Detallar']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($tipo); ?>" <?php echo e(old('tipo_animal', $registroDuplicado->tipo_animal ?? '') == $tipo ? 'selected' : ''); ?>><?php echo e($tipo); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Edad Aparente -->
    <label for="edad_aparente" class="block text-sm font-medium text-gray-700">Edad aparente</label>
    <select name="edad_aparente" id="edad_aparente" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Neonato', 'Juvenil', 'Adulto', 'Geriátrico']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($edad); ?>" <?php echo e(old('edad_aparente', $registroDuplicado->edad_aparente ?? '') == $edad ? 'selected' : ''); ?>><?php echo e($edad); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Estado General -->
    <label for="estado_general" class="block text-sm font-medium text-gray-700">Estado General</label>
    <input type="text" name="estado_general" id="estado_general" value="<?php echo e(old('estado_general', $registroDuplicado->estado_general ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Sexo -->
    <label for="sexo" class="block font-semibold mb-1">Sexo</label>
    <select name="sexo" id="sexo" required class="form-select w-full border px-4 py-2 rounded">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Macho', 'Hembra', 'Indeterminado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sexo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($sexo); ?>" <?php echo e(old('sexo', $registroDuplicado->sexo ?? '') == $sexo ? 'selected' : ''); ?>><?php echo e($sexo); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Comportamiento -->
    <label for="comportamiento" class="block text-sm font-medium text-gray-700">Comportamiento</label>
    <select name="comportamiento" id="comportamiento" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Aparentemente Normal', 'Tímido', 'Agresivo', 'Otro - Detallar']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comportamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($comportamiento); ?>" <?php echo e(old('comportamiento', $registroDuplicado->comportamiento ?? '') == $comportamiento ? 'selected' : ''); ?>><?php echo e($comportamiento); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Sospecha de enfermedad -->
    <label for="sospecha_enfermedad" class="block text-sm font-medium text-gray-700">¿Sospecha de enfermedad al momento del rescate?</label>
    <select name="sospecha_enfermedad" id="sospecha_enfermedad" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['SI', 'NO']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respuesta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($respuesta); ?>" <?php echo e(old('sospecha_enfermedad', $registroDuplicado->sospecha_enfermedad ?? '') == $respuesta ? 'selected' : ''); ?>><?php echo e($respuesta); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'descripcion_enfermedad','label' => 'Describa si la respuesta fue \'SI\'','value' => old('descripcion_enfermedad', $registroDuplicado->descripcion_enfermedad ?? '')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\TextareaField::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $attributes = $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $component = $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>

    <!-- Alteraciones evidentes -->
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'alteraciones_evidentes','label' => 'Alteraciones evidentes (heridas, fracturas, etc)','value' => old('alteraciones_evidentes', $registroDuplicado->alteraciones_evidentes ?? '')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\TextareaField::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $attributes = $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $component = $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>

    <!-- Otras observaciones -->
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'otras_observaciones','label' => 'Otras observaciones, describa si el animal fue vacunado, recibió algún tratamiento y otros antecedentes clínicos','value' => old('otras_observaciones', $registroDuplicado->otras_observaciones ?? '')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\TextareaField::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $attributes = $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $component = $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>

    <!-- Tiempo aproximado de cautiverio -->
    <label for="tiempo_cautiverio" class="block text-sm font-medium text-gray-700">Tiempo Aproximado de Cautiverio</label>
    <input type="text" name="tiempo_cautiverio" id="tiempo_cautiverio" value="<?php echo e(old('tiempo_cautiverio', $registroDuplicado->tiempo_cautiverio ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Tipo de alojamiento -->
    <label for="tipo_alojamiento" class="block text-sm font-medium text-gray-700">Tipo de Alojamiento</label>
    <input type="text" name="tipo_alojamiento" id="tipo_alojamiento" value="<?php echo e(old('tipo_alojamiento', $registroDuplicado->tipo_alojamiento ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Contacto con otros animales -->
    <label for="contacto_con_animales" class="block text-sm font-medium text-gray-700">¿Tuvo contacto con otros animales?</label>
    <select name="contacto_con_animales" id="contacto_con_animales" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['SI', 'NO']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($op); ?>" <?php echo e(old('contacto_con_animales', $registroDuplicado->contacto_con_animales ?? '') == $op ? 'selected' : ''); ?>><?php echo e($op); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'descripcion_contacto','label' => 'Describa si la respuesta fue \'SI\'','value' => old('descripcion_contacto', $registroDuplicado->descripcion_contacto ?? '')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\TextareaField::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $attributes = $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $component = $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>

    <!-- Enfermedades anteriores -->
    <label for="padecio_enfermedad" class="block text-sm font-medium text-gray-700">¿Padeció alguna enfermedad?</label>
    <select name="padecio_enfermedad" id="padecio_enfermedad" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['SI', 'NO']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($val); ?>" <?php echo e(old('padecio_enfermedad', $registroDuplicado->padecio_enfermedad ?? '') == $val ? 'selected' : ''); ?>><?php echo e($val); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'descripcion_padecimiento','label' => 'Describa si la respuesta fue \'SI\'','value' => old('descripcion_padecimiento', $registroDuplicado->descripcion_padecimiento ?? '')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\TextareaField::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $attributes = $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $component = $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>

    <!-- Alimentación -->
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'tipo_alimentacion','label' => 'Describa el tipo de alimentación','value' => old('tipo_alimentacion', $registroDuplicado->tipo_alimentacion ?? '')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\TextareaField::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $attributes = $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $component = $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>

    <!-- Derivación a CCFS -->
    <label for="derivacion_ccfs" class="block text-sm font-medium text-gray-700">¿Fue derivado a un CCFS?</label>
    <select name="derivacion_ccfs" id="derivacion_ccfs" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['SI', 'NO']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($val); ?>" <?php echo e(old('derivacion_ccfs', $registroDuplicado->derivacion_ccfs ?? '') == $val ? 'selected' : ''); ?>><?php echo e($val); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'descripcion_derivacion','label' => 'Describa si la respuesta fue \'SI\'','value' => old('descripcion_derivacion', $registroDuplicado->descripcion_derivacion ?? '')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\TextareaField::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $attributes = $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d)): ?>
<?php $component = $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d; ?>
<?php unset($__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d); ?>
<?php endif; ?>


    <!-- Fotografía del animal -->
    <style>
  .dropzone {
    border: 2px dashed #ccc;
    border-radius: 0.5rem;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s ease;
    position: relative;
  }

  .dropzone:hover {
    border-color: #2563eb;
  }

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

  #remove-btn:hover {
    background-color: #dc2626;
  }
</style>

<label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Fotografía del Animal</label>

<div id="dropzone" class="dropzone">
  <p id="dropzone-text">Haz clic o arrastra una imagen aquí</p>
  <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
</div>

<img id="foto-preview" src="#" alt="Vista previa de la foto" />
<button type="button" id="remove-btn">Eliminar Imagen</button>

<!-- Puedes capturar el base64 aquí si lo necesitas -->
<input type="hidden" name="foto_base64" id="foto-base64" />

<script>
  const dropzone = document.getElementById('dropzone');
  const input = document.getElementById('foto');
  const preview = document.getElementById('foto-preview');
  const removeBtn = document.getElementById('remove-btn');
  const base64Input = document.getElementById('foto-base64');

  // Función para convertir a base64
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

    // Convertir a base64
    const base64 = await toBase64(file);
    base64Input.value = base64;
    console.log("Imagen en base64:", base64); // Puedes eliminar esto en producción
  }

  // Input manual
  input.addEventListener('change', (e) => handleFile(e.target.files[0]));

  // Click en dropzone
  dropzone.addEventListener('click', () => input.click());

  // Drag visual
  dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('dragover');
  });

  dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
  });

  // Drop file
  dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
      input.files = e.dataTransfer.files;
      handleFile(file);
    }
  });

  // Eliminar imagen
  removeBtn.addEventListener('click', () => {
    preview.src = '#';
    preview.style.display = 'none';
    input.value = '';
    base64Input.value = '';
    removeBtn.style.display = 'none';
  });
</script>


    <style>
  .icon-rotate {
    transition: transform 0.3s ease;
  }

  button:hover .icon-rotate {
    transform: rotate(-20deg);
  }
</style>

<button type="submit" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
  <i class="bi bi-save icon-rotate"></i>
  Guardar Registro
</button>

</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/fauna/create.blade.php ENDPATH**/ ?>