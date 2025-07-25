<div class="form-group mb-3">
    <label for="<?php echo e($name); ?>" class="form-label"><?php echo e($label); ?></label>
    <textarea
        name="<?php echo e($name); ?>"
        id="<?php echo e($name); ?>"
        rows="4"
        <?php echo e($attributes->merge(['class' => 'form-control'])); ?>

    ><?php echo e(old($name, $value)); ?></textarea>
</div>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/components/textarea-field.blade.php ENDPATH**/ ?>