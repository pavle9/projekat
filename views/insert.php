<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/17/18
 * Time: 1:00 AM
 */
require_once '../config.php';
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$allRequests = new requestsModel();
//checking for fields in insert modal
if($_POST['id2']!=''  && $_POST['date']!='' && $_POST['date1']!=''  && $_POST['year']!='' && $_POST['first']!='')
{
    print json_encode(array('status'=>true, 'message'=> 'Good'));
}
else
{
    print json_encode(array('status'=>false, 'message'=> 'False'));
}

?>


