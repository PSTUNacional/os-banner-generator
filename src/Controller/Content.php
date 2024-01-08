<?php

set_time_limit(0);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

use Banners\Repository\ContentRepository;
require '../../autoload.php';

$method = $_GET['method'];
$type = $_GET['type'];
$limit = isset($_GET['limit']) ? $_GET['limit'] : 12;
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

$repository = new ContentRepository;

if( $method == 'getByType' )
{
    
    $result = $repository->getByType($type, $limit, $offset);
    header("Content-Type: application/json");
    echo json_encode($result);
}