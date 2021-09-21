<?php

namespace App\Services;

class ArrayService
{
    /**
     * Проверяет, присутствует ли в массиве указанный ключ или индекс
     * @param string|int $key
     * @param array $array
     * @return bool
     */
    public function arrayKeyExists(mixed $key, array $array): bool
    {
        return array_key_exists($key, $array);
    }
    
    /**
     * Убирает повторяющиеся значения из массива
     * @param array $array
     * @return array
     */
    public function arrayUnique(array $array): array
    {
        return array_unique($array);
    }
}
