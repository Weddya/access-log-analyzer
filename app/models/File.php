<?php

namespace App\Models;

use App\Core\Model;
use App\Services\FileService;

class File extends Model
{
    /**
     * @var resourse|null Указатель на файл
     */
    private $_filePointer;
    /**
     * @var \App\Services\FileService
     */
    private FileService $_fileService;
    
    public function __construct()
    {
         $this->_fileService = new FileService();
    }
    
    /**
     * Проверяет наличие файла
     * @param string $filename
     * @return bool
     */
    public function isFileExists(string $filename): bool
    {
        return $this->_fileService->isFileExists($filename);
    }
    
    /**
     * Открывает файл
     * @param string $filename
     */
    public function openFile(string $filename): void
    {
        $this->_filePointer = $this->_fileService->openFile($filename, 'r');
    }
    
    /**
     * Закрывает файл
     */
    public function closeFile(): void
    {
        $this->_fileService->closeFile($this->_filePointer);
        $this->_filePointer = null;
    }
    
    /**
     * Читает строку из файла
     * @return string|null
     */
    public function getNextLine(): ?string
    {
        return $this->_fileService->getNextLine($this->_filePointer);
    }
    
    /**
     * Проверяет, достигнут ли конец файла
     * @return bool
     */
    public function isFileEnd(): bool
    {
        return $this->_fileService->isFileEnd($this->_filePointer);
    }
    
    /**
     * Проверяет, достигнут ли конец файла
     * @param string $line
     * @return array
     */
    public function analyzeLine(string $line): array
    {
        $result = [];
        if ($line !== null) {
            $regExpPattern = '/^(\S+) (\S+) (\S+) \[(.*)\] \"(\S+) (.*) (\S+)\" (\S+) (\S+) \"(.*)\" \"(.*)\"$/';
            preg_match($regExpPattern, $line, $matches);
            if (count($matches) === 12) {
                $result['url'] = $matches[6];
                $result['traffic'] = $matches[9];
                $result['user_agent'] = $matches[11];
                $result['status_code'] = $matches[8];
            }
        }
        return $result;
    }
}
