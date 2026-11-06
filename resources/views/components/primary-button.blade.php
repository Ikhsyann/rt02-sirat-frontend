<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-lime border border-transparent rounded-full font-bold text-xs text-dark uppercase tracking-widest hover:bg-lime/90 focus:outline-none focus:ring-2 focus:ring-lime focus:ring-offset-2 active:scale-[0.98] transition']) }}>
    {{ $slot }}
</button>
