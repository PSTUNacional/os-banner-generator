<?php

$api = "https://www.opiniaosocialista.com.br/wp-json/wp/v2/posts?include=".$_GET['id'];
$json = file_get_contents($api);
$json = json_decode($json, true);
$content = $json[0];

$contentType = $_GET['type'];
$format = $_GET['format'];
?>
<html>

<head>
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="../../assets/js/banner-functions.js"></script>
</head>
<body>
    <?php
        if($format == 'banner' && $contentType == 'regular'){
            include('../BannerModels/bannerPost.php');
        }
        if($format == 'story' && $contentType == 'regular'){
            include('../BannerModels/storyPost.php');
        }
        if($format == 'banner' && $contentType == 'column'){
            include('../BannerModels/bannerColumn.php');
        }
        if($format == 'story' && $contentType == 'column'){
            include('../BannerModels/storyColumn.php');
        }
    ?>
</body>

</html>