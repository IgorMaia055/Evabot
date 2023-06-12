<?php

include 'vendor/autoload.php';

use sistem\Nucleo\Connection;
use sistem\Nucleo\Helpers;

$conn = (new Connection)->getInstancia();

use Pecee\SimpleRouter\SimpleRouter;

try {
    SimpleRouter::setDefaultNamespace('sistem\Controlador');

    SimpleRouter::get(ROUTER_BASE. 'cadastrar/{aviso}', 'SiteControl@cadastro');
    SimpleRouter::get(ROUTER_BASE. 'goCadastro/', 'SiteControl@goCadastro');
    
    SimpleRouter::get(ROUTER_BASE. 'validation/{mensagem}', 'SiteControl@validation');
    SimpleRouter::post(ROUTER_BASE. 'go/', 'SiteControl@goValid');

    SimpleRouter::get(ROUTER_BASE. 'home/{key}', 'SiteControl@index');

    SimpleRouter::post(ROUTER_BASE. 'chatGpt/', 'SiteControl@chatGpt');

    SimpleRouter::get(ROUTER_BASE.'404/', 'SiteControl@erro');

    SimpleRouter::start();

} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $e) {
    Helpers::redirecionar('validation/enter');
}