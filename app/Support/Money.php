<?php

namespace App\Support;

class Money
{
    public static function idr(int|float|null $amount): string
    {
        return 'Rp ' . number_format((float) ($amount ?? 0), 0, ',', '.');
    }
}
