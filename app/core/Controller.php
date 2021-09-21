<?php

namespace App\Core;

use App\Core\View;

class Controller
{
    /**
     * @var \App\Core\View
     */
    protected View $_view;
    
    public function __construct()
    {
        $this->_view = new View();
    }
}
