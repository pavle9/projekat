<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/21/18
 * Time: 3:00 pM
 */
require_once '../config.php';
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$workPlace = new workplacesModel();
$and_clause = '';
$default_url = 'index.php?view=workplaceslist&search='.$_GET['search'];
$pagination_url = 'index.php?view=workplaceslist&p=[p]&search='.$_GET['search'];
$search_term = '';


$pageSize = 10;
//checking for pagination
if(isset($_GET['p']))
    $pageNumber = $_GET['p'];
else
    $pageNumber = 1;

$limitPage = ((int)$pageNumber - 1) * $pageSize;
$limit_clause = " LIMIT ".$limitPage.",".$pageSize;
$allPlaces = $workPlace->searchPlaces($_GET['search'],$limit_clause);

$totalRecords = $workPlace->searchPlacesCount($_GET['search']);
$pg = new bootPagination();
$pg=HelperModel::paginationParameters($pg, $pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url);

if(!$allPlaces)
{
    echo '<br /><p class="alert-danger" style="text-align: center;">Nema trazenih rezultata!</p>';
}
else
{?>
    <div  class='container'>
        <?php require_once FULL_FILE_PATH.'/tables/tablePlaces.php'; ?>
    </div>
<?php } ?>
