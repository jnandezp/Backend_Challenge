<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Crimsoncircle\Simplex\StringResponseListener;
use Symfony\Component\DependencyInjection\Reference;

$request = Request::createFromGlobals();
$routes = include __DIR__.'/src/app.php';

$container = include __DIR__.'/src/container.php';
$container->register('listener.string_response', StringResponseListener::class);
$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')])
;
$response = $container->get('framework')->handle($request);
$response->send();