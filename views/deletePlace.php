<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/13/18
 * Time: 8:30 PM
 */
$placeClass = new workplacesModel();
//checking for deleting work place
if(isset($_GET['id']))
{
    $placeClass->deletePlace($_GET['id']);
    header('Location:index.php?view=workplaceslist');
}
else
{
    header('Location:index.php?view=message');
}
