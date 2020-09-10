<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/31/18
 * Time: 2:30 AM
 */
require_once '../config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$allRequests = new requestsModel();
$place = new workplacesModel();
//checking for fields in insert modal
if($_POST['name']!='')
{
    $place -> insertPlace($_POST);
    $data="<select name='place' id='place'  class='form-control'>";
    $allPlaces= $place->workPlaces();
    foreach($allPlaces as $wp)
    {
        if($_POST['name']==$wp['NAZIV_RADNOG_MJESTA'])
        {
            $data.="<option>". $wp['ID_RADNOG_MJESTA'] ."-". $wp['NAZIV_RADNOG_MJESTA']."</option>";
        }
    }
    foreach($allPlaces as $wp)
    {
        if($_POST['name']!=$wp['NAZIV_RADNOG_MJESTA'])
        {
            $data.="<option>". $wp['ID_RADNOG_MJESTA'] ."-". $wp['NAZIV_RADNOG_MJESTA']."</option>";
        }
    }
    $data.="</select>";
    print json_encode(array('status'=>true, 'content'=> $data));
}
else
{
    print json_encode(array('status'=>false, 'message'=> 'False'));
}

