<?php

date_default_timezone_set('PRC');
ini_set('default_charset', 'UTF-8');
header('Content-type: text/html; charset=UTF-8');

// 杀虫模式
define('DEBUG', false);
if(DEBUG){
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}else{
    ini_set('display_errors', 'Off');
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);
}

// Composer支持
require './vendor/autoload.php';

// 自动加载类
spl_autoload_register(function($class){
    if(strtolower(substr($class, 0, 6)) === 'funch\\'){
        $file = __DIR__ . '/class/' . str_replace('\\', '/', substr($class, 6)) . '.php';
        if(file_exists($file)){
            require_once $file;
        }
    }else if(strtolower(substr($class, 0, 11)) === 'controller\\'){
        $file = __DIR__ . '/controller/' . str_replace('\\', '/', substr($class, 11)) . '.controller.php';
        if(file_exists($file)){
            require_once $file;
        }
    }else{
        // 做点啥呢
    }
});


// 视图
function view($view, $params = []){
    $blade = new duncan3dc\Laravel\BladeInstance('./views', './cache/views');
    return $blade->render($view, $params);
}
function ajax($data, $jsonp = false){
    $json = json_encode($data);
    if($jsonp && isset($_GET['callback'])){
        return $_GET['callback'].'('.$json.');';
    }else{
        return $json;
    }
}

// 一个小小的控制器入口
$request_method = $_SERVER['REQUEST_METHOD'] === 'GET' ? 'get' : 'post';
$controller = (isset($_GET['c']) && $_GET['c'] != '') ? $_GET['c'] : 'home';
$method = (isset($_GET['m']) && $_GET['m'] != '') ? $_GET['m'] : 'index';
if(preg_match('!^[-_a-zA-Z0-9]+$!', $controller.$method) !== 1) exit;
$controller_path = './controller/'.$controller.'.controller.php';
if(!file_exists($controller_path)) $controller = 'home';
$controller_full = 'Controller\\'.$controller;
$obj = new $controller_full();
$method_full = $request_method.$method;
if(!method_exists($obj, $method_full)){
    $method_full = 'any'.$method;
    if(!method_exists($obj, $method_full)){
        if($request_method === 'get'){
            $method_full = $method;
            if(!method_exists($obj, $method_full)){
                exit;
            }
        }else{
            exit;
        }
    }
}
$r = $obj->{$method_full}();
echo $r;
