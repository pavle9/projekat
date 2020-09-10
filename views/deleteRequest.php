<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/16/18
 * Time: 10:30 PM
 */
$requestClass = new requestsModel();
//checking for deleting request
if(isset($_GET['id']))
{
    $requestClass->deleteRequest($_GET['id']);
    header('Location:index.php?view=requestslist');
}
else
{
    header('Location:index.php?view=message');
}