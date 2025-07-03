@props(['label', 'name', 'type' => 'text', 'value' => '', 'placeholder' => '', 'col' => 3])

<div class="col-md-{{ $col }}">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" class="form-control">
</div>
