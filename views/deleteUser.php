<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/8/18
 * Time: 11:00 PM
 */
$userClass = new usersModel();
//checking for deleting user
if(isset($_GET['id']))
{
    $userClass->deleteUser($_GET['id']);
    header('Location:index.php?view=userslist');
}
else
{
    header('Location:index.php?view=message');
}

