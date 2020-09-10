<?php
/**
* Created by Pavle Poljcic.
* User: pavle
* Date: 8/22/18
* Time: 9:00 AM
*/
require_once '../config.php';
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$allRequests = new requestsModel();
$and_clause = '';

$default_url = 'index.php?view=requestslist&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
$pagination_url = 'index.php?view=requestslist&p=[p]&d1='.$_GET['d1'].'&d2='.$_GET['d2'];

$search_term = '';

$pageSize = 10;
//checking for pagination
if(isset($_GET['p']))
    $pageNumber = $_GET['p'];
else
    $pageNumber = 1;

$limitPage = ((int)$pageNumber - 1) * $pageSize;
$limit_clause = " LIMIT ".$limitPage.",".$pageSize;
$requests = $allRequests -> filterDate($_GET['d1'],$_GET['d2'],$limit_clause);
$totalRecords = $allRequests->CountDate($_GET['d1'],$_GET['d2']);

$pg = new bootPagination();
$pg=HelperModel::paginationParameters($pg, $pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url);

if(!$requests): ?>
    <br /><p class="alert-danger" style="text-align: center;">Nema trazenih rezultata!</p>
<?php else: ?>
   <br/><?php require_once FULL_FILE_PATH.'/tables/tableRequests.php';
endif;
?>
