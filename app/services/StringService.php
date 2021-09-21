<?php

namespace App\Services;

class StringService
{
    /**
     * Возвращает позицию первого вхождения подстроки
     * @param string $haystack
     * @param string $needle
     * @param int $offset 
     * @return int|false
     */
    public function strpos(string $haystack, string $needle, int $offset = 0): mixed
    {
        $result = strpos($haystack, $needle, $offset);
        return $result !== false ? $result : null;
    }
}
