<?php

namespace App\Core;

use App\Services;

class View
{
    /**
     * @var \App\Services\HttpService
     */
    private Services\HttpService $_httpService;
    
    /**
     * @var \App\Services\FileService
     */
    private Services\FileService $_fileService;

    public function __construct() {
        $this->_httpService = new Services\HttpService();
        $this->_fileService = new Services\FileService();
    }

    /**
     * Ответ в формате json
     * @param array $data
     */
    public function json(array $data = []): void
    {
        echo json_encode($data);
    }
    
    /**
     * Вывод соответствующего представления для ошибки
     * @param int $code
     */
    public static function errorCode(int $code): void
    {
        $httpService = new Services\HttpService();
        $fileService = new Services\FileService();
        
        $httpService->httpResponseCode($code);
        $path = "app/views/errors/{$code}.php";
        if ($fileService->isFileExists($path)) {
            require $path;
        }
        exit(1);
    }
}
