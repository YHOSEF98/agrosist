@props([
    'tipo' => 'success',
    'mensaje' => session('success'),
])

@if ($mensaje)
    @php
        $estilos = match ($tipo) {
            'error' => [
                'icono' => '✕',
                'color' => 'text-red-600',
                'fondo' => 'bg-red-50',
                'barra' => 'bg-red-500',
            ],
            'warning' => [
                'icono' => '!',
                'color' => 'text-amber-600',
                'fondo' => 'bg-amber-50',
                'barra' => 'bg-amber-500',
            ],
            default => [
                'icono' => '✓',
                'color' => 'text-green-600',
                'fondo' => 'bg-green-50',
                'barra' => 'bg-green-500',
            ],
        };
    @endphp

    <div
        x-data="{ visible: true }"
        x-show="visible"
        x-init="setTimeout(() => visible = false, 4000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="relative mb-4 w-full overflow-hidden
               rounded-xl border border-gray-200 bg-white
               shadow-lg dark:border-gray-700 dark:bg-gray-800"
        role="status"
        aria-live="polite"
    >
        <div class="flex items-center gap-3 p-4">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center
                        rounded-full {{ $estilos['fondo'] }}
                        text-lg font-bold {{ $estilos['color'] }}">
                {{ $estilos['icono'] }}
            </div>

            <p class="flex-1 text-sm font-medium text-gray-700
                      dark:text-gray-200">
                {{ $mensaje }}
            </p>

            <button
                type="button"
                @click="visible = false"
                class="rounded-lg p-1 text-gray-400 transition
                       hover:bg-gray-100 hover:text-gray-600
                       dark:hover:bg-gray-700"
                aria-label="Cerrar alerta"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor"
                     stroke-width="2">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="h-1 w-full bg-gray-100 dark:bg-gray-700">
            <div
                class="h-full {{ $estilos['barra'] }}"
                style="animation: alerta-progreso 4s linear forwards"
            ></div>
        </div>
    </div>

    <style>
        @keyframes alerta-progreso {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>
@endif