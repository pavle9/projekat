<?php
 /**
  * Created by Pavle Poljcic.
  * User: pavle
  * Date: 8/7/18
  * Time: 1:00 PM
  */
require_once 'config.php';
require_once 'config/loader.php';
//require_once FULL_FILE_PATH.'/loaderModels.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$user = new usersModel();

require_once 'views/default/head.php';

//checking for login
if(isset($_SESSION['is_logged']))
{
require_once FULL_FILE_PATH.'/views/default/header_section.php';
//checking for view
if(isset($_GET['view']))
{
    //full file path
    $viewPath = FULL_FILE_PATH.'/views/'.$_GET['view'].'.php';

    //verification if file exist
    if(file_exists($viewPath))
    {
        include $viewPath;
    }
    else
    {
        //if file not exist
        include FULL_FILE_PATH.'/views/message.php';
    }
}

//checking for logout
if(isset($_GET['logout']))
    {
      $user->Logout();
      header('Location:index.php');
    }
}
else
{
 include FULL_FILE_PATH.'/views/login.php';
//echo  password_hash('1111', PASSWORD_DEFAULT);
}



