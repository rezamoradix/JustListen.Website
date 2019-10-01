<?php 

if (! function_exists('add_image')) {
    function add_image($title, $url, $desc = "")
    {
        R::setup('sqlite:'.__DIR__.'/thedb.db');
        $ent = R::dispense('image');
        $ent->title = $title;
        $ent->desc = $desc;
        $ent->url = $url;
        $id = R::store($ent);
        file_put_contents('_index_image', "$id");
        R::close();
        
    }
}

if (! function_exists('add_audio')) {
    function add_audio($title, $url, $artist = "", $desc = "")
    {
        R::setup('sqlite:'.__DIR__.'/thedb.db');
        $ent = R::dispense('audio');
        $ent->title = $title;
        $ent->desc = $desc;
        $ent->artist = $artist;
        $ent->url = $url;
        $id = R::store($ent);
        file_put_contents('_index_audio', "$id");
        R::close();
        
    }
}


if (! function_exists('rand_image')) {
    function rand_image()
    {
        R::setup('sqlite:'.__DIR__.'/thedb.db');
        $max = file_get_contents('_index_image');
        $rand = rand(1, $max);
        $data = R::load('image', $rand);
        R::close();
        return $data;
    }
}

if (! function_exists('rand_audio')) {
    function rand_audio()
    {
        R::setup('sqlite:'.__DIR__.'/thedb.db');
        $max = file_get_contents('_index_audio');
        $rand = rand(1, $max);
        $data = R::load('audio', $rand);
        R::close();
        return $data;
    }
}