<?php $__env->startSection('title', 'Editar Registro de Fauna'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('fauna.update', $fauna->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <!-- Fecha de Ingreso -->
    <div class="form-group">
        <label for="fecha_ingreso">Fecha de Ingreso</label>
        <input type="date" name="fecha_ingreso" value="<?php echo e(old('fecha_ingreso', $fauna->fecha_ingreso)); ?>" class="w-full border-gray-300 rounded-md shadow-sm" required>
    </div>

    <label for="fecha_recepcion">Fecha de Recepción</label>
    <input type="date" id="fecha_recepcion" name="fecha_recepcion" value="<?php echo e(old('fecha_recepcion', $fauna->fecha_recepcion)); ?>" required class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Ciudad -->
    <label for="ciudad">Ciudad</label>
    <input type="text" id="ciudad" name="ciudad" value="<?php echo e(old('ciudad', $fauna->ciudad)); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Departamento -->
    <label for="departamento">Departamento</label>
    <input type="text" id="departamento" name="departamento" value="<?php echo e(old('departamento', $fauna->departamento)); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Coordenadas -->
     <label for="coordenadas" class="block text-sm font-medium text-gray-700">Coordenadas</label>
<input type="text" id="coordenadas" name="coordenadas" value="<?php echo e(old('coordenadas', $registroDuplicado->coordenadas ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

<div id="map" class="mt-4" style="height: 400px;"></div>

    <!-- Tipo de Elemento -->
    <label for="tipo_elemento">Tipo de Elemento</label>
    <select name="tipo_elemento" id="tipo_elemento" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Animal Vivo', 'Parte', 'Derivado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($tipo); ?>" <?php echo e(old('tipo_elemento', $fauna->tipo_elemento) == $tipo ? 'selected' : ''); ?>><?php echo e($tipo); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Motivo de Ingreso -->
    <label for="motivo_ingreso">Motivo de Ingreso</label>
    <select name="motivo_ingreso" id="motivo_ingreso" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Decomiso', 'Rescate', 'Captura', 'Otro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($motivo); ?>" <?php echo e(old('motivo_ingreso', $fauna->motivo_ingreso) == $motivo ? 'selected' : ''); ?>><?php echo e($motivo); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Lugar -->
    <label for="lugar">Lugar</label>
    <input type="text" name="lugar" id="lugar" value="<?php echo e(old('lugar', $fauna->lugar)); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Institución -->
    <label for="institucion_remitente">Institución Responsable</label>
    <input type="text" name="institucion_remitente" id="institucion_remitente" value="<?php echo e(old('institucion_remitente', $fauna->institucion_remitente)); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Persona que recibe -->
    <label for="nombre_persona_recibe">Persona que Recibe</label>
    <input type="text" name="nombre_persona_recibe" id="nombre_persona_recibe" value="<?php echo e(old('nombre_persona_recibe', $fauna->nombre_persona_recibe)); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Especie -->
    <label for="especie" class="italic">Especie</label>
    <input type="text" name="especie" id="especie" value="<?php echo e(old('especie', $fauna->especie)); ?>" class="w-full border-gray-300 rounded-md shadow-sm italic">

    <!-- Nombre común -->
    <label for="nombre_comun">Nombre Común</label>
    <input type="text" name="nombre_comun" id="nombre_comun" value="<?php echo e(old('nombre_comun', $fauna->nombre_comun)); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Tipo de animal -->
    <label for="tipo_animal">Tipo de Animal</label>
    <select name="tipo_animal" id="tipo_animal" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Mamífero', 'Ave', 'Reptil', 'Anfibio', 'Otro - Detallar']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($tipo); ?>" <?php echo e(old('tipo_animal', $fauna->tipo_animal) == $tipo ? 'selected' : ''); ?>><?php echo e($tipo); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Edad Aparente -->
    <label for="edad_aparente">Edad Aparente</label>
    <select name="edad_aparente" id="edad_aparente" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Neonato', 'Juvenil', 'Adulto', 'Geriátrico']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($edad); ?>" <?php echo e(old('edad_aparente', $fauna->edad_aparente) == $edad ? 'selected' : ''); ?>><?php echo e($edad); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Estado General -->
    <label for="estado_general">Estado General</label>
    <input type="text" name="estado_general" id="estado_general" value="<?php echo e(old('estado_general', $fauna->estado_general)); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Sexo -->
    <label for="sexo">Sexo</label>
    <select name="sexo" id="sexo" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Macho', 'Hembra', 'Indeterminado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sexo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($sexo); ?>" <?php echo e(old('sexo', $fauna->sexo) == $sexo ? 'selected' : ''); ?>><?php echo e($sexo); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Comportamiento -->
    <label for="comportamiento">Comportamiento</label>
    <select name="comportamiento" id="comportamiento" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <?php $__currentLoopData = ['Aparentemente Normal', 'Tímido', 'Agresivo', 'Otro - Detallar']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comportamiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($comportamiento); ?>" <?php echo e(old('comportamiento', $fauna->comportamiento) == $comportamiento ? 'selected' : ''); ?>><?php echo e($comportamiento); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Sospecha enfermedad -->
    <label for="sospecha_enfermedad">¿Sospecha de enfermedad?</label>
    <select name="sospecha_enfermedad" id="sospecha_enfermedad" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="SI" <?php echo e(old('sospecha_enfermedad', $fauna->sospecha_enfermedad ? 'SI' : 'NO') == 'SI' ? 'selected' : ''); ?>>SI</option>
        <option value="NO" <?php echo e(old('sospecha_enfermedad', $fauna->sospecha_enfermedad ? 'SI' : 'NO') == 'NO' ? 'selected' : ''); ?>>NO</option>
    </select>
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'descripcion_enfermedad','label' => 'Descripción de Enfermedad','value' => old('descripcion_enfermedad', $fauna->descripcion_enfermedad)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'alteraciones_evidentes','label' => 'Alteraciones Evidentes','value' => old('alteraciones_evidentes', $fauna->alteraciones_evidentes)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'otras_observaciones','label' => 'Otras Observaciones','value' => old('otras_observaciones', $fauna->otras_observaciones)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
    <?php if (isset($component)) { $__componentOriginal13afeff3c398c925ed332806e702df71 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal13afeff3c398c925ed332806e702df71 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-field','data' => ['name' => 'tiempo_cautiverio','label' => 'Tiempo Cautiverio','value' => old('tiempo_cautiverio', $fauna->tiempo_cautiverio)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'tiempo_cautiverio','label' => 'Tiempo Cautiverio','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('tiempo_cautiverio', $fauna->tiempo_cautiverio))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal13afeff3c398c925ed332806e702df71)): ?>
<?php $attributes = $__attributesOriginal13afeff3c398c925ed332806e702df71; ?>
<?php unset($__attributesOriginal13afeff3c398c925ed332806e702df71); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13afeff3c398c925ed332806e702df71)): ?>
<?php $component = $__componentOriginal13afeff3c398c925ed332806e702df71; ?>
<?php unset($__componentOriginal13afeff3c398c925ed332806e702df71); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal13afeff3c398c925ed332806e702df71 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal13afeff3c398c925ed332806e702df71 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-field','data' => ['name' => 'tipo_alojamiento','label' => 'Tipo Alojamiento','value' => old('tipo_alojamiento', $fauna->tipo_alojamiento)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'tipo_alojamiento','label' => 'Tipo Alojamiento','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('tipo_alojamiento', $fauna->tipo_alojamiento))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal13afeff3c398c925ed332806e702df71)): ?>
<?php $attributes = $__attributesOriginal13afeff3c398c925ed332806e702df71; ?>
<?php unset($__attributesOriginal13afeff3c398c925ed332806e702df71); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13afeff3c398c925ed332806e702df71)): ?>
<?php $component = $__componentOriginal13afeff3c398c925ed332806e702df71; ?>
<?php unset($__componentOriginal13afeff3c398c925ed332806e702df71); ?>
<?php endif; ?>

    <!-- Contacto con animales -->
    <label for="contacto_con_animales">¿Tuvo contacto con animales?</label>
    <select name="contacto_con_animales" id="contacto_con_animales" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="SI" <?php echo e(old('contacto_con_animales', $fauna->contacto_con_animales ? 'SI' : 'NO') == 'SI' ? 'selected' : ''); ?>>SI</option>
        <option value="NO" <?php echo e(old('contacto_con_animales', $fauna->contacto_con_animales ? 'SI' : 'NO') == 'NO' ? 'selected' : ''); ?>>NO</option>
    </select>
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'descripcion_contacto','label' => 'Descripción del Contacto con Animales','value' => old('descripcion_contacto', $fauna->descripcion_contacto)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

    <!-- Padeció enfermedad -->
    <label for="padecio_enfermedad">¿Padeció enfermedad?</label>
    <select name="padecio_enfermedad" id="padecio_enfermedad" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="SI" <?php echo e(old('padecio_enfermedad', $fauna->padecio_enfermedad ? 'SI' : 'NO') == 'SI' ? 'selected' : ''); ?>>SI</option>
        <option value="NO" <?php echo e(old('padecio_enfermedad', $fauna->padecio_enfermedad ? 'SI' : 'NO') == 'NO' ? 'selected' : ''); ?>>NO</option>
    </select>
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'descripcion_padecimiento','label' => 'Descripción de Padecimiento','value' => old('descripcion_padecimiento', $fauna->descripcion_padecimiento)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'tipo_alimentacion','label' => 'Tipo de Alimentación','value' => old('tipo_alimentacion', $fauna->tipo_alimentacion)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
    <label for="derivacion_ccfs">¿Derivado a CCFS?</label>
    <select name="derivacion_ccfs" id="derivacion_ccfs" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="SI" <?php echo e(old('derivacion_ccfs', $fauna->derivacion_ccfs ? 'SI' : 'NO') == 'SI' ? 'selected' : ''); ?>>SI</option>
        <option value="NO" <?php echo e(old('derivacion_ccfs', $fauna->derivacion_ccfs ? 'SI' : 'NO') == 'NO' ? 'selected' : ''); ?>>NO</option>
    </select>
    <?php if (isset($component)) { $__componentOriginald6f594a9b5edb891e4d76b5c13a95b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald6f594a9b5edb891e4d76b5c13a95b5d = $attributes; } ?>
<?php $component = App\View\Components\TextareaField::resolve(['name' => 'descripcion_derivacion','label' => 'Descripción de Derivación a CCFS','value' => old('descripcion_derivacion', $fauna->descripcion_derivacion)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

    <!-- Imagen actual -->
    <?php if($fauna->foto): ?>
        <p class="text-sm text-gray-600">Foto actual:</p>
        <img src="<?php echo e(asset('storage/' . $fauna->foto)); ?>" alt="Foto del animal" class="max-w-xs mb-2 rounded-md">
    <?php endif; ?>

    <label for="foto">Actualizar fotografía</label>
    <input type="file" name="foto" id="foto" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">

   <button type="submit" 
    class="mt-4 px-6 py-3 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 text-black font-bold rounded-lg shadow-lg hover:from-red-600 hover:via-pink-600 hover:to-purple-600 transition-all duration-300 transform hover:scale-105">
    Actualizar Registro
</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/fauna/edit.blade.php ENDPATH**/ ?>