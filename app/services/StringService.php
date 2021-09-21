<?php

namespace App\Services;

class StringService
{
    /**
     * Возвращает позицию первого вхождения подстроки
     * @param string $haystack
     * @param string $needle
     * @param int $offset 
     * @return int|null
     */
    public function strpos(string $haystack, string $needle, int $offset = 0): ?int
    {
        $result = strpos($haystack, $needle, $offset);
        return $result !== false ? $result : null;
    }
}
