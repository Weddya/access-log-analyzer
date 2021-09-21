<?php

namespace App\Services;

class HttpService 
{
    /**
     * Получает или устанавливает код ответа HTTP
     * @param int $responseCode
     * @return int|bool
     */
    public function httpResponseCode(int $responseCode = 0): mixed
    {
        return http_response_code($responseCode);
    }
}
