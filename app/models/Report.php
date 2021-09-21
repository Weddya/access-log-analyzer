<?php

namespace App\Models;

use App\Core\Model;
use App\Services;

class Report extends Model
{
    private int $_views = 0;
    private array $_urls = [];
    private int $_traffic = 0;
    private array $_crawlers = [
        'Google' => 0,
        'Bing' => 0,
        'Baidu' => 0,
        'Yandex' => 0,
    ];
    private array $_statusCodes = [];
    private array $_potentialBots = [
        'Google' => [
            'Googlebot', 'APIs-Google', 'Mediapartners-Google', 'AdsBot-Google-Mobile', 'AdsBot-Google', 
            'Googlebot-Image', 'Googlebot-News', 'Googlebot-Video', 'FeedFetcher-Google', 'Google-Read-Aloud',
            'DuplexWeb-Google', 'Google Favicon', 'googleweblight', 'Storebot-Google', 'AdsBot-Google-Mobile-Apps',
        ],
        'Bing' => ['bingbot'],
        'Baidu' => ['Baiduspider'],
        'Yandex' => [
            'YandexBot', 'YandexDirect', 'YandexImages', 'YandexMetrika', 'YandexWebmaster', 'YaDirectFetcher', 
            'YandexAccessibilityBot', 'YandexDirectDyn', 'YandexVideo', 'YandexVideoParser', 'YandexMedia',
            'YandexBlogs', 'YandexFavicons', 'YandexPagechecker', 'YandexImageResizer', 'YandexAdNet',
            'YandexCalendar', 'YandexSitelinks', 'YandexNews', 'YandexCatalog', 'YandexVertis', 
            'YandexForDomain', 'YandexSpravBot', 'YandexSearchShop', 'YandexOntoDB', 
            'YandexOntoDBAPI', 'YandexVerticals',
        ],
    ];
    
    /**
     * @var \App\Services\ArrayService
     */
    private Services\ArrayService $_arrayService;
    /**
     * @var \App\Services\StringService
     */
    private Services\StringService $_stringService;
    
    public function __construct()
    {
         $this->_arrayService = new Services\ArrayService();
         $this->_stringService = new Services\StringService();
    }
    
    /**
     * Увеличивает количество просмотров на единицу
     */
    public function increaseViews(): Report
    {
        $this->_views++;
        return $this;
    }
    
    /**
     * Добавляет новый URL в список
     * @param string $url
     * @return Report
     */
    public function addUrl(string $url): Report
    {
        $this->_urls[] = $url;
        return $this;
    }
    
    /**
     * Добавляет количество трафика к общей сумме
     * @param int $traffic
     * @return Report
     */
    public function addTraffic(int $traffic): Report
    {
        $this->_traffic += $traffic;
        return $this;
    }
    
    /**
     * Добавляет поисковых ботов в соответствующий список
     * @param string $userAgent
     * @return Report
     */
    public function addCrawler(string $userAgent): Report
    {
        $botAgentName = $this->identifyBot($userAgent);
        if ($botAgentName !== null) {
            $this->_crawlers[$botAgentName] = $this->increaseArrayProperty($this->_crawlers, $botAgentName);
        }
        return $this;
    }
    
    /**
     * Добавляет код ответа в соответствующий список
     * @param string $statusCode
     * @return Report
     */
    public function addStatusCode(string $statusCode): Report
    {
        $this->_statusCodes[$statusCode] = $this->increaseArrayProperty($this->_statusCodes, $statusCode);
        return $this;
    }
    
    /**
     * Формирует массив с данными отчета
     * @return array
     */
    public function getReport(): array
    {
        $result = [
            'views' => $this->_views,
            'urls' => count($this->filterUniqueUrls()),
            'traffic' => $this->_traffic,
            'crawlers' => $this->_crawlers,
            'statusCodes' => $this->_statusCodes,
        ];
        return $result;
    }
    
    /**
     * Фильтрует URLs и возвращает только уникальные из них
     * @return array
     */
    private function filterUniqueUrls(): array
    {
        return $this->_arrayService->arrayUnique($this->_urls);
    }
    
    /**
     * Идентифицирует бота поисковой системы по токену
     * @param string $agent
     * @return string|null
     */
    private function identifyBot(string $agent): ?string
    {
        foreach ($this->_potentialBots as $companyName => $companyBots) {
            foreach ($companyBots as $bot) {
                if ($this->_stringService->strpos($agent, $bot)) {
                    return $companyName;
                }
            }
        }
        return null;
    }
    
    /**
     * Увеличение количественных параметров в свойстве типа массив
     * @param array $property
     * @param string $key
     * @return int
     */
    private function increaseArrayProperty(array $property, string $key): int
    {
        return $this->_arrayService->arrayKeyExists($key, $property) ? $property[$key] + 1 : 1;
    }
}
