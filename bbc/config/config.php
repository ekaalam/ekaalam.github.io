<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Kathmandu');


define('SITE_URL', "http://bbc.loc");
define('SITE_NAME', 'bbc');

define('DB_HOST', 'localhost');
define('DB_NAME', 'bbc');
define('DB_USER', 'root');
define('DB_PASSWORD', '');


define('ADMIN_URL', SITE_URL . "/cms");
define('ADMIN_ASSETS_URL', ADMIN_URL . "/assets");
define('ADMIN_CSS_URL', ADMIN_ASSETS_URL . "/css");
define('ADMIN_JS_URL', ADMIN_ASSETS_URL . "/js");
define('ADMIN_IMAGES_URL', ADMIN_ASSETS_URL . "/img");


define('ERROR_LOG', $_SERVER['DOCUMENT_ROOT'] . '/error/error.log');

define('ALLOWED_IMAGES_EXTS', array('jpg', 'jpeg', 'png', 'gif', 'bmp'));
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/uploads/');
define('UPLOAD_URL', SITE_URL . '/uploads/');

$state = array(
    'all' => 'All State News',
    'state1' => 'State 1',
    'state2' => 'State 2',
    'state3' => 'Bagmati',
    'state4' => 'Gandaki',
    'state5' => 'Lumbini',
    'state6' => 'Karnali',
    'state7' => 'Sudur Paschim',
);

define('ASSETS_URL',SITE_URL.'/assets');
define('ASSETS_CSS_URL',ASSETS_URL.'/css');
define('ASSETS_JS_URL',ASSETS_URL.'/js');
define('ASSETS_IMAGES_URL',ASSETS_URL.'/img');

define('META_KEYWORDS','newsportal, news, blog');
define('META_DESCRIPTION','bbc wil provide you all sorts of news.');