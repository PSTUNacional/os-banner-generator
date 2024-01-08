<?php

set_time_limit(0);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

use HeadlessChromium\BrowserFactory;
use Banners\Repository\ContentRepository;

require 'vendor/autoload.php';
require 'autoload.php';

$api = "https://www.opiniaosocialista.com.br/wp-json/wp/v2/posts?per_page=30";
$modelBase = 'https://www.opiniaosocialista.com.br/automation/banners/src/BannerModels/';
logMessage('Início do ciclo.');

// Read last ID
$repository = new ContentRepository;
$lastId = $repository->getLastReferID();
$lastId = $lastId[0]['referid'];
logMessage('O último ID é: ' . $lastId . '.');

// Fecth th API
$json = file_get_contents($api);
if ($json == false) {
    logMessage('Não foi possível acessar a API.');
    die();
} else {
    logMessage('API acessada com sucesso.');
    $json = json_decode($json, true);
}

// Check, starting from the last, if is newer than last rendered
foreach (array_reverse($json) as $mat) {

    if ($mat['id'] > $lastId) {

        logMessage('Há uma matéria nova a ser processada: ' . $mat['id'] . '.');

        // Check if is Column
        $bannerType = 'regular';
        foreach ($mat['categories_names'] as $cat) {
            if (str_contains($cat, 'Colunas')) {
                $bannerType = 'column';
            }
        }

        createBanner($mat['id'], $bannerType);
    }
}

/*==============================

    Functions

==============================*/

function createBanner($id, $contentType)
{
    // Starts new browser
    $browserFactory = new BrowserFactory('chromium-browser');
    $browser = $browserFactory->createBrowser();

    // Render Banner
    $url = 'https://www.opiniaosocialista.com.br/automations/banners/src/Service/Render.php?id=' . $id . '&format=banner&content=' . $contentType;
    try {
        $page = $browser->createPage();
        $page->navigate($url)->waitForNavigation('networkIdle', 30000);
        logMessage('Processando o ID ' . $id . ' como banner.');
    } finally {
        logMessage('Banner ' . $id . ' gerado com sucesso.');
    }

    // Render Story
    $url = 'https://www.opiniaosocialista.com.br/automations/banners/src/Service/Render.php?id=' . $id . '&format=story&content=' . $contentType;
    try {
        $page = $browser->createPage();
        $page->navigate($url)->waitForNavigation('networkIdle', 30000);
        logMessage('Processando o ID ' . $id . ' como story.');
    } finally {
        logMessage('Story ' . $id . ' gerado com sucesso.');
    }
}

function logMessage($message)
{
    $now = date("Y-m-d H:i:s");
    $str = '[' . $now . '] - ' . $message . PHP_EOL;
    file_put_contents('./logs/log.txt', $str, FILE_APPEND);
    echo $str.'<br/>';
}
