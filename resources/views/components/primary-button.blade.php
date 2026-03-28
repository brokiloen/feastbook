<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-burgundy border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-burgundy-dark focus:bg-burgundy-dark active:bg-burgundy-dark focus:outline-none focus:ring-2 focus:ring-burgundy focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
