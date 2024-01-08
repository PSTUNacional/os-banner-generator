<?php

spl_autoload_register(function($class){

$path = str_replace('\\','/',$class);
$path = str_replace('Banners', '', $path);
require_once($_SERVER['DOCUMENT_ROOT'] . '/automation/banners/src/' . $path.'.php');
});