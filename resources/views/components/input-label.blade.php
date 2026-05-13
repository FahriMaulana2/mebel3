<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-dark mb-2']) }}>
    {{ $value ?? $slot }}
</label>
