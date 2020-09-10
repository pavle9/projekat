<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/21/18
 * Time: 9:00 PM
 */
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
require_once FULL_FILE_PATH.'/models/usersModel.php';
require_once FULL_FILE_PATH.'/models/workplacesModel.php';
require_once FULL_FILE_PATH.'/models/requestsModel.php';
require_once FULL_FILE_PATH.'/models/HelperModel.php';
require_once FULL_FILE_PATH.'/bootstrap_pagination/pagination.php';