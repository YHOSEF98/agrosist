<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'inline-flex items-center rounded-lg bg-violet-600
                    px-4 py-2.5 text-sm font-semibold text-white
                    transition hover:bg-violet-700
                    focus:outline-none focus:ring-2 focus:ring-violet-500/30'
    ]) }}>
    <i class="bi bi-plus"></i>
    {{ $text }}
</a>