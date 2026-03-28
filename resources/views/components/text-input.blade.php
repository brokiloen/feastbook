@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-burgundy focus:ring-burgundy rounded-md shadow-sm']) }}>
