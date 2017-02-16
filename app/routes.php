<?php

use Utilities\Router;

$router = new Router();

$router->get('/', 'HomepageController#index');
$router->get('/delete', 'HomepageController#delete');
$router->get('/export', 'HomepageController#export');

$router->post('/insert', 'HomepageController#insert');
$router->post('/update', 'HomepageController#update');