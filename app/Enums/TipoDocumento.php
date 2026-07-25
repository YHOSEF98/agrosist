<?php

namespace App\Enums;

enum TipoDocumento: string
{
    case CC = 'CC';
    case TI = 'TI';
    case CE = 'CE';
    case NIT = 'NIT';
    case PAS = 'PAS';
    case PPT = 'PPT';

    /**
     * Nombre legible para mostrar en la interfaz.
     */
    public function label(): string
    {
        return match ($this) {
            self::CC => 'Cédula de Ciudadanía',
            self::TI => 'Tarjeta de Identidad',
            self::CE => 'Cédula de Extranjería',
            self::NIT => 'NIT',
            self::PAS => 'Pasaporte',
            self::PPT => 'Permiso por Protección Temporal',
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
