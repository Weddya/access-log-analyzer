<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models;
use App\Services\ArrayService;

class HomeController extends Controller
{
    /**
     * @var \App\Models\File
     */
    private Models\File $_file;
    /**
     * @var \App\Models\Report
     */
    private Models\Report $_report;
    /**
     * @var \App\Services\ArrayService
     */
    private ArrayService $_arrayService;

    public function __construct()
    {
        parent::__construct();
        
        $this->_file = new Models\File();
        $this->_report = new Models\Report();
        $this->_arrayService = new ArrayService();
    }
    
    public function indexAction()
    {
        if ($this->_arrayService->arrayKeyExists('argv', $_SERVER) && count($_SERVER['argv']) > 1) {
            $filePath = $_SERVER['argv'][1];
        } else {
            return $this->_view->json(['Error' => 'Missed startup argument']);
        }
        
        if ($this->_file->isFileExists($filePath)) {
            $this->_file->openFile($filePath);
        } else {
            return $this->_view->json(['Error' => 'File not exists']);
        }
        
        while (!$this->_file->isFileEnd()){
            $line = $this->_file->getNextLine();
            $lineParts = $this->_file->analyzeLine($line);
            $this->_report
                    ->increaseViews()
                    ->addUrl($lineParts['url'])
                    ->addTraffic($lineParts['traffic'])
                    ->addStatusCode($lineParts['status_code'])
                    ->addCrawler($lineParts['user_agent']);
        }
        
        return $this->_view->json($this->_report->getReport());
    }
}