<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/10/18
 * Time: 4:00 AM
 */
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$workPlace = new workplacesModel();

//checking for insert work place
if(isset($_POST['potvrdi']))
{
    $workPlace->insertPlace($_POST);
    header('Location:index.php?view=workplaceslist');
}

$and_clause = '';
$default_url = 'index.php?view=workplaceslist';
$pagination_url = 'index.php?view=workplaceslist&p=[p]';
$search_term = '';

$pageSize = 10;
//checking for pagination
if(isset($_GET['p']))
    $pageNumber = $_GET['p'];
else
    $pageNumber = 1;

$limitPage = ((int)$pageNumber - 1) * $pageSize;
$limit_clause = " LIMIT ".$limitPage.",".$pageSize;
$allPlaces= $workPlace->workPlaces($limit_clause);
$totalRecords = $workPlace->countPlaces();

//checking for pagination and search
if(isset($_GET['p']) && isset($_GET['search']))
{
    $allPlaces = $workPlace -> searchPlaces($_GET['search'],$limit_clause);
    $totalRecords = $workPlace->searchPlacesCount($_GET['search']);
    $default_url = 'index.php?view=workplaceslist&search='.$_GET['search'];
    $pagination_url = 'index.php?view=workplaceslist&p=[p]&search='.$_GET['search'];
}
//checking for search
if(isset($_GET['search']))
{
    $allPlaces = $workPlace -> searchPlaces($_GET['search'],$limit_clause);
    $totalRecords = $workPlace->searchPlacesCount($_GET['search']);
    $default_url = 'index.php?view=workplaceslist&search='.$_GET['search'];
    $pagination_url = 'index.php?view=workplaceslist&p=[p]&search='.$_GET['search'];
}

$pg = new bootPagination();
$pg=HelperModel::paginationParameters($pg, $pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url);
?>

<br>
<div style="text-align: center" id="gif"><img src="<?= FULL_URL_PATH;?>/assets/icons/loading.gif" hidden="true"></div>
<div class='container'>
    <div  class='row-fluid'>
        <div  class='col-lg'>
            <button type="button"  data-toggle="modal"  data-target="#add_data_Modal" class="btn btn-secondary float-lg-left">Dodaj novo radno mjesto</button>
            <?php if(isset($_GET['search'])): ?>
            <input  type="text" name="search_place" id="search_place" placeholder="Pretrazi.." class="float-lg-right" value=<?=$_GET['search']; ?>>
            <?php  else: ?>
                <input  type="text" name="search_place" id="search_place" placeholder="Pretrazi.." class="float-lg-right">
            <?php endif; ?>
            <br>
            <div id="result_place">
                <?php require_once FULL_FILE_PATH.'/tables/tablePlaces.php';?>
            </div>
        </div>
    </div>
</div>
<?php require_once FULL_FILE_PATH.'/modals/insertPlace.php';?>


