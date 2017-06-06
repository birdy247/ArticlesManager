<?php
use Cake\Routing\Router;

Router::plugin('ArticlesManager', function ($routes) {
    $routes->fallbacks('DashedRoute');
});