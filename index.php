<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$extsIMG = ["png", "jpg"];
$extsMP3 = ["mp3"];
$dir = "./";
$cover = [];
$music = [];
$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) != false) {
            if ($file != "." and $file != "..") {

                $fileNameParts = explode(".", $file);
                $title = $fileNameParts[0];
                $ext = end($fileNameParts);
                $file = $url.$file;

                if (in_array($ext, $extsMP3)) {                    
                    array_push($music, array('url' => $file, 'title' => $title));
                } elseif (in_array($ext, $extsIMG)) {                    
                    array_push($cover, array('url' => $file));
                }
            }
        }   
    }

    $cover = array("cover"=>$cover);
    $music = array("music"=>$music);
    $all = array($cover, $music);

    echo json_encode($all);
    //$tracklist = json_encode($list);
    file_put_contents("tracklist.json", json_encode($all));
}