<?php

namespace App\Enums;

enum TipoContribuyente: string
{
    case NATURAL = 'Natural';
    case JURIDICA = 'Jurídica';

    public function label(): string
    {
        return match ($this) {
            self::NATURAL => 'Persona Natural',
            self::JURIDICA => 'Persona Jurídica',
        };
    }
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