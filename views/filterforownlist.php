<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/31/18
 * Time: 9:30 AM
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/pavle_projekat/config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$allRequests = new requestsModel();
$and_clause = '';

$default_url = 'index.php?view=ownlist&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
$pagination_url = 'index.php?view=ownlist&p=[p]&d1='.$_GET['d1'].'&d2='.$_GET['d2'];

$search_term = '';

$pageSize = 10;
//checking for pagination
if(isset($_GET['p']))
    $pageNumber = $_GET['p'];
else
    $pageNumber = 1;

$limitPage = ((int)$pageNumber - 1) * $pageSize;
$limit_clause = " LIMIT ".$limitPage.",".$pageSize;
$requests = $allRequests -> filterDateforOwnlist($_GET['d1'],$_GET['d2'],$limit_clause, $_SESSION['id_korisnika']);
$totalRecords = $allRequests->CountDateforOwnlist($_GET['d1'],$_GET['d2'], $_SESSION['id_korisnika']);

$pg = new bootPagination();
$pg=HelperModel::paginationParameters($pg, $pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url);

if(!$requests): ?>
    <br /><p class="alert-danger" style="text-align: center;">Nema trazenih rezultata!</p>
<?php else: ?>
    <br/><?php require_once FULL_FILE_PATH.'/tables/tableOwnRequests.php';
endif;
?>