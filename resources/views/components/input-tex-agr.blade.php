<div>
    <label
        for="{{ $name }}"
        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
        {{ $label }}
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        {{ $attributes->merge([
            'class' => 'mt-1.5 block w-full rounded-lg border border-neutral-300
            bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
            outline-none transition
            placeholder:text-neutral-400
            focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
            dark:border-neutral-700 dark:bg-neutral-800
            dark:text-neutral-100 dark:placeholder-neutral-500
            dark:focus:border-violet-500'
        ]) }}>

    @error($name)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
            {{ $message }}
        </p>
    @enderror
</div>