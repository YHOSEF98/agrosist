<?php

namespace App\Enums;

enum TipoTrabajador
{
    case DIRECTO = 'DIRECTO';
    case CONTRATISTA = 'CONTRATISTA';

    /**
     * Nombre legible para mostrar en la interfaz.
     */
    public function label(): string
    {
        return match ($this) {
            self::DIRECTO => 'Trabajador Directo',
            self::CONTRATISTA => 'Trabajador Contratista',
        };
    }

    /**
     * Opciones para un select.
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ])
            ->toArray();
    }
}
