<?php
function debug($data, $is_exit = false)
{
    echo "<pre style='background: #FFFFFF;'>";
    print_r($data);
    echo "</pre>";
    if ($is_exit) {
        exit;
    }
}

function setSession($key, $msg)
{
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION[$key] = $msg;
}

function redirect($path, $session_key = null, $msg = null)
{
    if ($session_key !== null) {
        setSession($session_key, $msg);
    }

    header('location: ' . $path);
    exit;
}

function flash()
{
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        echo "<p class='alert alert-success'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['warning']) && !empty($_SESSION['warning'])) {
        echo "<p class='alert alert-warning'>" . $_SESSION['warning'] . "</p>";
        unset($_SESSION['warning']);
    }
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        echo "<p class='alert alert-danger'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
}

function generateRandomString($length = 100)
{
    $string = "0123456789abcdefghijklmniopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $count = strlen($string);
    $random = "";

    for ($i = 0; $i < $length; $i++) {
        $posn = rand(0, $count - 1);
        $chars = $string[$posn];
        $random .= $chars;
    }
    return $random;
}

function sanitize($str)
{
    $str = strip_tags($str);
    $str = rtrim($str);
    return $str;
    //mysql_real_escape();
}

function uploadImage($image, $dir)
{
    if ($image['error'] == 0) {
        if ($image['size'] <= 4000000) {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ALLOWED_IMAGES_EXTS)) {
                //
                $path = UPLOAD_PATH . $dir;

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                //category-2020186386728178731.ext
                $image_name = ucfirst($dir) . "-" . date('Ymdhis') . rand(0, 999) . "." . $ext;

                $success = move_uploaded_file($image['tmp_name'], $path . "/" . $image_name);
                if ($success) {
                    return $image_name;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function deleteImage($image_name, $dir)
{
    if ($image_name != null) {
        if (file_exists(UPLOAD_PATH . $dir . "/" . $image_name)) {
            return unlink(UPLOAD_PATH . $dir . "/" . $image_name);
        } else {
            return null;
        }
    }else{
        return null;
    }
}

function getYoutubeVideoIdFromurl($url){
    preg_match("#([\/|\?|&]vi?[\/|=]|youtu\.be\/|embed\/)([a-zA-Z0-9_-]+)#", $url, $matches);
    
    if(isset($matches[2])){
        return $matches[2];
    }else{
        return false;
    }
    debug($matches, true);
}

function getCurrentUrl(){
    $url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    return $url;
}

function getCurrentPage(){
    $page_name = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_FILENAME);
    return $page_name;
}
