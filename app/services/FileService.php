<?php

namespace App\Services;

class FileService
{
    /**
     * Проверяет наличие файла или каталога
     * @param string $filename
     * @return bool
     */
    public function isFileExists(string $filename): bool
    {
        return file_exists($filename);
    }
    
    /**
     * Открывает файл
     * @param string $filename
     * @param string $mode
     * @return resource|null
     */
    public static function openFile(string $filename, string $mode)
    {
        $filePointer = fopen($filename, $mode);
        return $filePointer === false ? null : $filePointer;
    }
    
    /**
     * Закрывает файл, на который указывает дескриптор
     * @param resourse $stream
     */
    public static function closeFile($stream): void
    {
        fclose($stream);
    }
    
    /**
     * Читает строку из файла
     * @param resourse $stream
     * @return string|null
     */
    public static function getNextLine($stream): ?string
    {
        $data = fgets($stream);
        if ($data !== false) {
            return $data;
        }
        return null;
    }
    
    /**
     * Проверяет, достигнут ли конец файла
     * @param resourse $stream
     * @return bool
     */
    public static function isFileEnd($stream): bool
    {
        return feof($stream);
    }
}
