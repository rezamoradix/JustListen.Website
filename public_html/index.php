<?php
session_start(['cookie_lifetime' => 7200]);
require "../core/rb-sqlite.php";
require "../core/db.php";
$segments = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
if (isset($segments[0]) && isset($segments[1])) {
    if ($segments[0] == "s" && $segments[1] == 'i') {
        header('Content-type: application/json');
        echo json_encode(rand_image());
        return;
    }

    if ($segments[0] == "s" && $segments[1] == 'a') {
        header('Content-type: application/json');
        echo json_encode(rand_audio());
        return;
    }

    if ($segments[0] == "s" && $segments[1] == 'admin') {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) {
            require "../core/admin.php";
        }
        else
            require "../core/login.php";

        return;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/normalize.css">
    <link rel="stylesheet" href="/style.css?t=78">
    <meta http-equiv="Cache-control" content="public">
    <meta name="theme-color" content="#1d004d" />
    <META NAME="description" CONTENT="JustListen. Listen to the magical world of musics, جاست لیسن، خود را در دنیای شگفت انگیز موسیقی رها کنید.">
    <META NAME="keywords" CONTENT="JustListen, musics, online music, جاست لیسن, JustListen 🎵, جاست لیسن پخش موسیقی, موسیقی, پخش موسیقی آنلاین">
    <link rel="shortcut icon" href="https://justlisten.ir/favicon.ico">

    <link rel="apple-touch-icon image_src" href="https://justlisten.ir/logos/128.png">

    <meta property="og:type" content= "website" />
    <meta property="og:url" content="https://justlisten.ir/"/>
    <meta property="og:site_name" content="JustListen 🎵 - Listen to the world of musics" />
    <meta property="og:image" itemprop="image primaryImageOfPage" content="https://justlisten.ir/logos/384.png" />

    <meta name="google-site-verification" content="6Cw-dyBoC8RMt_vem9PBJ7Jxu_A8MgVAz7iS19xPwv4" />
    
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:domain" content="justlisten.ir"/>
    <meta name="twitter:title" property="og:title" itemprop="name" content="JustListen 🎵 - Listen to the world of musics" />
    <meta name="twitter:description" property="og:description" itemprop="description" content="JustListen. Listen to the magical world of musics, جاست لیسن، خود را در دنیای شگفت انگیز موسیقی رها کنید." />

    

    <link href="/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700&display=swap" rel="stylesheet"> 
    <title>JustListen 🎵 - Listen to the world of musics</title>

    

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145769272-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-145769272-1');
    </script>

</head>
<body>
    <div class="container">
        <div class="center">
            <div class="np"><div class="iloader"></div><span class="status">Loading</span></div>
            <div class="audio-info" style="display:none">
                <div class="a-title"></div>
                <div class="divider"></div>
                <div class="a-artist"></div>
                <div class="a-desc"></div>
            </div>
            <div class="control" style="display:none">
                <i class="clickable pp fa fa-pause"></i>
                <i class="clickable fa fa-step-forward"></i>
            </div>
        </div>

        <div class="img-info">
            <div class="img-title"></div>
            <div class="img-desc"></div>
        </div>

        <a href="https://www.dropbox.com/s/jy2cf5fpj3v4wsy/ir.justlisten.apk?dl=1" class="android-link" target="_blank" rel="noopener noreferrer"><i class="fa fa-android"></i><span>ANDROID APP</span></a>
        <a href="https://ppng.ir/d/Kc3d" class="donate" target="_blank" rel="noopener noreferrer">Donate ❤</a>
        <div class="allowd" style="display:none">
            <div class="msg">Autoplay permission</div>
            <div class="allowbtn">Allow</div>
        </div>
    </div>
    
    
    <script src="/jquery.js"></script>
    <script src="/script.js?t=7c0af0"></script>
    <script src="/prefixfree.min.js"></script>
</body>
</html>