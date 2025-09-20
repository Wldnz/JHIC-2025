<?php

namespace App\Http\Controllers;

use App\DataFormatter\EloquentObjectFormatter;

abstract class Controller
{
    public function __construct() {
        /** @var \DebugBar\DataCollector\DataCollector $viewCollector */
        $viewCollector = debugbar()->getCollector('views');
        $viewCollector->setDataFormatter(new EloquentObjectFormatter());
    }
}
