@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-border-line focus:border-mid focus:ring-lime/60 rounded-md shadow-sm']) }}>
