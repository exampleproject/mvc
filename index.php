<?php

session_start();

$request = $_SERVER['REQUEST_URI'];

require('vendor/autoload.php');

spl_autoload_register( function($classname) {
    $classname = str_replace('\\', '/', $classname);
    require_once( __DIR__ . "/$classname.php");
});


if ($request == '' || $_GET) 
{
    @$sortname = key($_GET);
    @$sortdirection = $_GET[$sortname];
    new App\Controllers\SiteController(intval(str_replace('/page/', "", $request)), $sortname, $sortdirection);
} 
else if ($request == '/' || $_GET) 
{
    @$sortname = key($_GET);
    @$sortdirection = $_GET[$sortname];
    new App\Controllers\SiteController(intval(str_replace('/page/', "", $request)), $sortname, $sortdirection);
} 
else if (preg_match('#\/page\/[0-9]*#', $request)) 
{
    @$sortname = key($_GET);
    @$sortdirection = $_GET[$sortname];
    new App\Controllers\SiteController(intval(str_replace('/page/', "", $request)), $sortname, $sortdirection);
}
else if ($request == '/add/new/task' && $_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $addtask = new App\Controllers\SiteController();
    $addtask->addNewTask($_REQUEST['task']);
}
else 
{
     http_response_code(404);
     require $_SERVER["DOCUMENT_ROOT"] . '/views/404.php';
}
