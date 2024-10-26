<?php

namespace App\Service;

class FibonacciService 
{
    public function isFibonacci(int $number): bool
    {
        if ($number < 0) {
            return false;
        }

        // Проверяем, является ли число Фибоначчи по формуле
        $x1 = 5 * ($number * $number);
        $x2 = sqrt($x1 + 4);
        $x3 = sqrt($x1 - 4);

        return (floor($x2) * floor($x2) == $x1 + 4) || (floor($x3) * floor($x3) == $x1 - 4);
    }
}
