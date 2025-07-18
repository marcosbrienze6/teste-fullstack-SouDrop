<?php

namespace App;

enum ProductType: string
{
    case ELETRONICO = 'eletronico';
    case VESTUARIO = 'vestuario';
    case ACESSORIO = 'acessorio';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
