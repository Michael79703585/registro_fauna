<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['route', 'icon', 'label']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['route', 'icon', 'label']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $isActive = request()->routeIs($route . '*');
?>

<a href="<?php echo e(route($route)); ?>"
   <?php echo e($attributes->merge(['class' => "flex items-center gap-3 px-4 py-2 rounded-lg font-semibold transition-colors " . ($isActive ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-blue-500 hover:text-white')])); ?>>
    <span class="text-lg"><?php echo e($icon); ?></span>
    <span><?php echo e($label); ?></span>
</a>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/components/sidebar-link.blade.php ENDPATH**/ ?>