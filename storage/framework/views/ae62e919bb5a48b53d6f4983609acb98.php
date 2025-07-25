

<?php $__env->startSection('title', 'Recepciones de Fauna Silvestre'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    
    <div class="card shadow mb-4 border-0 animate__animated animate__fadeInDown">
        <div class="card-body">
            <form method="GET" action="<?php echo e(url('/recepciones')); ?>">
                <div class="input-group">
                    <input type="text" name="codigo" placeholder="🔍 Buscar por código de fauna" value="<?php echo e(request('codigo')); ?>" class="form-control form-control-lg shadow-sm rounded-start">
                    <button type="submit" class="btn btn-primary btn-lg rounded-end">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card shadow mb-4 border-0 animate__animated animate__fadeInLeft">
    <div class="card-header bg-white border-bottom shadow-sm">
        <h5 class="mb-0 fw-bold text-uppercase" style="font-size: 1.25rem; letter-spacing: 0.5px; color: #0d6efd;">
            📦 Transferencias Aceptadas en tu Institución
        </h5>
    </div>
        <div class="card-body">
            <?php if($transferencias->isEmpty()): ?>
                <p class="text-muted fst-italic">No hay transferencias aceptadas.</p>
            <?php else: ?>
                <?php $__currentLoopData = $transferencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transferencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border rounded-3 p-4 mb-4 shadow-sm transition hover-shadow bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <p class="mb-1"><strong>Fauna:</strong> <?php echo e($transferencia->fauna->codigo ?? 'Sin código'); ?></p>
                                <p class="mb-1"><strong>Motivo:</strong> <?php echo e($transferencia->motivo ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Estado:</strong>
                                    <span class="badge bg-warning text-dark"><?php echo e($transferencia->estado); ?></span>
                                </p>
                                <p class="mb-1"><strong>Registrado por:</strong> <?php echo e($transferencia->fauna->user->name ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Institución origen:</strong> <?php echo e($transferencia->fauna->user->institucion->nombre ?? 'N/A'); ?></p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <a href="<?php echo e(route('recepciones.pdf', $transferencia->fauna->id)); ?>" class="btn btn-outline-success btn-sm">
                                    📥 Descargar PDF
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card-header bg-white border-bottom shadow-sm">
    <h5 class="mb-0 fw-bold text-uppercase" style="font-size: 1.25rem; letter-spacing: 0.5px; color: #0d6efd;">
        🦜 Fauna Registrada en tu Institución
    </h5>
</div>



        <div class="card-body">
            <?php if($faunas->isEmpty()): ?>
                <p class="text-muted fst-italic">No hay faunas registradas en tu institución.</p>
            <?php else: ?>
                <?php $__currentLoopData = $faunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fauna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border rounded-3 p-4 mb-4 shadow-sm bg-light transition hover-shadow">
                        <p class="mb-1"><strong>Código:</strong> <?php echo e($fauna->codigo); ?></p>
                        <p class="mb-1"><strong>Especie:</strong> <?php echo e($fauna->especie); ?></p>
                        <p class="mb-1"><strong>Ingreso:</strong> <?php echo e($fauna->fecha_ingreso); ?></p>
                        <p class="mb-1"><strong>Registrado por:</strong> <?php echo e($fauna->user->name ?? 'N/A'); ?></p>
                        <p class="mb-1"><strong>Institución:</strong> <?php echo e($fauna->user->institucion->nombre ?? 'N/A'); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/recepciones/index.blade.php ENDPATH**/ ?>