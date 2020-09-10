<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/20/18
 * Time: 9:00 PM
 */

require_once(dirname(dirname(__FILE__)).'/config.php');
$rootUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $app;
$rootFolder = $_SERVER['DOCUMENT_ROOT'].$app;

$rootUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/pavle_projekat';
//$rootFolder = dirname(__FILE__);
$rootFolder = $_SERVER['DOCUMENT_ROOT'].'/pavle_projekat';
define('FULL_FILE_PATH', $rootFolder);
define("FULL_URL_PATH", $rootUrl);
session_start();