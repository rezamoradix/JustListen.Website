<?php

    $ftp_serv = "<FTP_HOST>";
    $ftp_us = "<FTP_USERNAME>";
    $ftp_pass = "<FTP_PASSWORD>";

    include 'curl.inc.php';
    function compress($source, $destination, $quality) {

        $info = getimagesize($source);
    
        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
    
        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
    
        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
    
        imagejpeg($image, $destination, $quality);
    
        return $destination;
    }

    

    $image_path = '/';
    $auth_path = '/';

    // Ex.: JustListen Cloud Server
    // $image_path = 'https://cloud.justlisten.ir/i/';
    // $auth_path = 'https://cloud.justlisten.ir/a/';

    //URL BASED
    if ( isset( $_POST['ititle'] ) && isset( $_POST['iurl'] ) && $_POST['iurl'] != "") {
        $ext = "";

        if (!in_array($ext, ['exe', 'php', 'com', 'bat', 'sh'])) {
            $name = sha1( $_POST['ititle'] . time() . "l2" ) . '.jpg';
            file_put_contents('src/i/' . $name, @custom_curl(strtok($_POST['iurl'], "?")));
            
            if (@is_array(getimagesize('src/i/' . $name))) {
                compress('src/i/' . $name, 'src/i/' . $name, 75);
                if (@is_array(getimagesize('src/i/' . $name))) {
                    $connie = @ftp_connect($ftp_serv);

                    @ftp_login($connie, $ftp_us, $ftp_pass);

                    if (@ftp_put($connie, "/i/".$name, "src/i/".$name, FTP_BINARY)) {
                        @unlink('src/i/' . $name);

                        add_image($_POST['ititle'], $image_path.$name, $_POST['idesc']);
                        echo '<h2>UrlImage added</h2>';
                    } else {
                        echo '<h2>UrlImage ERROR</h2>';
                        @unlink('src/i/' . $name);
                }
                    
                    @ftp_close($connie);
                }
            } else {
                @unlink('src/i/' . $name);
            }
            
        }
        
    } else {
        if ( isset( $_POST['ititle'] ) && isset( $_FILES['imgsrc'] ) ) {
            $ext = pathinfo($_FILES['imgsrc']['name'], PATHINFO_EXTENSION);
    
            if (!in_array($ext, ['exe', 'php', 'com', 'bat', 'sh'])) {
                $name = sha1( $_POST['ititle'] . time() . "l2" ) . '.' . $ext;
                move_uploaded_file($_FILES['imgsrc']['tmp_name'], 'src/i/' . $name);

                $connie = @ftp_connect($ftp_serv);
                @ftp_login($connie, $ftp_us, $ftp_pass);

                if (@ftp_put($connie, "/i/".$name, "src/i/".$name, FTP_BINARY)) {
                    @unlink('src/i/' . $name);

                    add_image($_POST['ititle'], $image_path.$name, $_POST['idesc']);
                    echo '<h2>Image added</h2>';

                } else {
                    echo '<h2>Image ERROR</h2>';
                    @unlink('src/i/' . $name);
                }
                
                @ftp_close($connie);
            }
        }
    }

    if ( isset( $_POST['atitle'] ) && isset( $_POST['aurl'] ) && $_POST['aurl'] != "" ) {
        $ext = pathinfo($_POST['aurl'], PATHINFO_EXTENSION);

        if (!in_array($ext, ['exe', 'php', 'com', 'bat', 'sh'])) {
            $name = sha1( $_POST['atitle'] . time() . "l2" ) . '.' . $ext;
            file_put_contents('src/a/' . $name, @custom_curl($_POST['aurl']));
            $fi = @finfo_open(FILEINFO_MIME_TYPE);
            $mt = @finfo_file($fi, 'src/a/' . $name);
            @finfo_close($fi);
            if (in_array($mt, ["audio/mpeg3", "audio/mp3", "audio/x-mpeg-3", "video/mpeg", "video/x-mpeg", "audio/mpeg"])) {

                $connie = @ftp_connect($ftp_serv);
                @ftp_login($connie, $ftp_us, $ftp_pass);

                if (@ftp_put($connie, "/a/".$name, "src/a/".$name, FTP_BINARY)) {
                    @unlink('src/a/' . $name);

                    add_audio($_POST['atitle'], $audio_path.$name, $_POST['aartist'], $_POST['adesc']);
                    echo '<h2>UrlAudio added</h2>';

                } else {
                    echo '<h2>UrlAudio ERROR</h2>';
                    @unlink('src/a/' . $name);
                }
                
                @ftp_close($connie);

                
            } else {
                    echo '<h2>UrlAudio Download ERROR</h2>';
                    @unlink('src/a/' . $name);
            }
        }
    } else {
        if ( isset( $_POST['atitle'] ) && isset( $_FILES['audsrc'] ) ) {
            $ext = pathinfo($_FILES['audsrc']['name'], PATHINFO_EXTENSION);
    
            if (!in_array($ext, ['exe', 'php', 'com', 'bat', 'sh'])) {
                $name = sha1( $_POST['atitle'] . time() . "l2" ) . '.' . $ext;
                move_uploaded_file($_FILES['audsrc']['tmp_name'], 'src/a/' . $name);


                $connie = @ftp_connect($ftp_serv);
                @ftp_login($connie, $ftp_us, $ftp_pass);

                if (@ftp_put($connie, "/a/".$name, "src/a/".$name, FTP_BINARY)) {
                    @unlink('src/a/' . $name);

                    add_audio($_POST['atitle'], $audio_path.$name, $_POST['aartist'], $_POST['adesc']);
                    echo '<h2>Audio added</h2>';

                } else {
                    echo '<h2>Audio ERROR</h2>';
                    @unlink('src/a/' . $name);
                }
                
                @ftp_close($connie);

            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/skeleton.css">
    <title>Admin</title>
</head>
<body>
    <div class="container">
    
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Image</h3>
            <div><input class="u-full-width" type="text" name="ititle" placeholder="Title"></div>
            <div><input class="u-full-width" type="text" name="idesc" placeholder="Description"></div>
            <div><input class="u-full-width" type="text" name="iurl" placeholder="Url"></div>
            <div><input type="file" name="imgsrc" id=""><span><?php echo ini_get("upload_max_filesize"); ?></span></div>
            <input type="submit" value="Submit">
        </form>

        <form action="" method="post" enctype="multipart/form-data">
            <h3>Audio</h3>
            <div><input class="u-full-width" type="text" name="atitle" placeholder="Title"></div>
            <div><input class="u-full-width" type="text" name="aartist" placeholder="Artist"></div>
            <div><input class="u-full-width" type="text" name="adesc" placeholder="Description"></div>
            <div><input class="u-full-width" type="text" name="aurl" placeholder="Url"></div>
            <div><input type="file" name="audsrc" id=""><span><?php echo ini_get("upload_max_filesize"); ?></span></div>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>