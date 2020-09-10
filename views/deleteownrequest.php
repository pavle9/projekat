<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/31/18
 * Time: 8:30 PM
 */
$requestClass = new requestsModel();
//checking for deleting request
if(isset($_GET['id']))
{
    $requestClass->deleteRequest($_GET['id']);
    header('Location:index.php?view=ownlist');
}
else
{
    header('Location:index.php?view=message');
}