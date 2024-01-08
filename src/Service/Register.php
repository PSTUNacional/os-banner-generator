<?php

// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../autoload.php';
use Banners\Repository\ContentRepository;

$img = $_POST['data'];
$id = $_POST['id'];
$mat_title = $_POST['mat_title'];
$mat_link = $_POST['mat_link'];
$author = $_POST['author'];
$format = $_POST['format'];

// Proccess image
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);

// Define filename
if( $format == 'story' )
{
    $filename = 'S'.$id.'.png';
}

if( $format == 'banner' )
{
    $filename = 'B'.$id.'.png';
}

// Save file in folder
$destination = $_SERVER['DOCUMENT_ROOT'] . '/automation/banners/rendered/png/'.$filename;
file_put_contents($destination, $fileData);

$path = "https://www.opiniaosocialista.com.br/automation/banners/rendered/png/".$filename;

// Convert to WEBP
$newname = str_replace('png', 'webp', $filename);
$webp = imagecreatefrompng($destination);
imagepalettetotruecolor($webp);
imagealphablending($webp, true);
imagesavealpha($webp, false);
imagewebp($webp, $_SERVER['DOCUMENT_ROOT'] . '/automation/banners/rendered/webp/' . $newname, 75);
imagedestroy($webp);

$repo = new ContentRepository;
$repo->registerContent(
    $filename,
    $format,
    $path,
    $id,
    $mat_link,
    $author
);
