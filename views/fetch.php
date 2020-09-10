<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/13/18
 * Time: 1:00 AM
 */
require_once '../config.php';
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$user = new usersModel();
$and_clause = '';
$default_url = 'index.php?view=userslist&search='.$_GET['search'];
$pagination_url = 'index.php?view=userslist&p=[p]&search='.$_GET['search'];
$search_term = '';

$pageSize = 10;
//checking for pagination
if(isset($_GET['p']))
    $pageNumber = $_GET['p'];
else
    $pageNumber = 1;

$limitPage = ((int)$pageNumber - 1) * $pageSize;
$limit_clause = " LIMIT ".$limitPage.",".$pageSize;
$allUsers = $user->search($_GET['search'],$limit_clause);

$totalRecords = $user->searchCount($_GET['search']);
$pg = new bootPagination();
$pg=HelperModel::paginationParameters($pg, $pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url);

if(!$allUsers)
{
    echo '<br /><p class="alert-danger" style="text-align: center;">Nema trazenih rezultata!</p>';
}
else
{?>
    <div style="text-align: center" id="gif"><img src="<?=FULL_URL_PATH;?>/assets/icons/loading.gif" hidden="true"></div>
    <div  class='container'>
        <?php require_once FULL_FILE_PATH.'/tables/tableUsers.php'; ?>
    </div>
<?php } ?>


