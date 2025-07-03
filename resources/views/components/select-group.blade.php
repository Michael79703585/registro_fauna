@props(['label', 'name', 'options' => [], 'selected' => '', 'default' => '-- Seleccionar --', 'col' => 3])

<div class="col-md-{{ $col }}">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-select">
        <option value="">{{ $default }}</option>
        @foreach($options as $key => $text)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $text }}</option>
        @endforeach
    </select>
</div>
