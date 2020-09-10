<?php
//use PHPMailer\PHPMailer\PHPMailer;
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/30/18
 * Time: 16:00 AM
 */
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
//require_once FULL_FILE_PATH . '/m/src/Exception.php';
//require_once FULL_FILE_PATH . '/m/src/PHPMailer.php';
//require_once FULL_FILE_PATH . '/m/src/SMTP.php';
$allRequests = new requestsModel();
$users = new usersModel();
$years = $users -> getUser($_SESSION['id_korisnika']);
$number_days = $allRequests -> numberOfDays($years['GODINE_RADNOG_STAZA']);
$status = $allRequests->getStatus();
$days = $allRequests->countOwnRequests($_SESSION['id_korisnika']);
$minus = $allRequests -> CountDays($_SESSION['id_korisnika']);

//checking for insert request
if(isset($_POST['id2']))
{
    $insert = $allRequests -> insertRequest($_POST);
    $msg = "Novi zahtjev od korisnika ".$_SESSION['email'].".";
    $send = $users->sendMail($msg, 0);
    header('Location:index.php?view=ownlist');
}
//checking for edit request
if(isset($_POST['potvrdi']))
{
    //$diff = strtotime($_POST['date1'])-strtotime($_POST['date']);
    //$days=floor($diff/(60*60*24));
    $days = $allRequests -> calculateDays($_POST['date'], $_POST['date1']);
    if(($_POST['first']=='Da' && $days>=10) || $_POST['first']=='Ne')
    {
        $put = $allRequests->updateRequestData($_POST,$days);
        //print_r($put);
        //header('Location:index.php?view=ownlist');
    }
    else
    {
        echo '<br /><p class="alert-danger" style="text-align: center;">Prvi dio odmora je 10 dana minimalno!</p>';
    }
}



$and_clause = '';
$default_url = 'index.php?view=ownlist';
$pagination_url = 'index.php?view=ownlist&p=[p]';
$search_term = '';

$pageSize = 10;
//checking for pagination
if(isset($_GET['p']))
    $pageNumber = $_GET['p'];
else
    $pageNumber = 1;

$limitPage = ((int)$pageNumber - 1) * $pageSize;
$limit_clause = " LIMIT ".$limitPage.",".$pageSize;
$requests = $allRequests -> ownRequests($_SESSION['id_korisnika'],$limit_clause);
$totalRecords = $allRequests->countOwnRequests($_SESSION['id_korisnika']);

//checking for pagination and filter
if(isset($_GET['p'], $_GET['d1'], $_GET['d2']))
{
    $requests = $allRequests -> filterDateforOwnlist($_GET['d1'],$_GET['d2'],$limit_clause,$_SESSION['id_korisnika']);
    $totalRecords = $allRequests->CountDateforOwnlist($_GET['d1'],$_GET['d2'], $_SESSION['id_korisnika']);
    $default_url = 'index.php?view=ownlist&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
    $pagination_url = 'index.php?view=ownlist&p=[p]&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
}
//checking for filter
if(isset($_GET['d1'], $_GET['d2']))
{
    $requests = $allRequests -> filterDateforOwnlist($_GET['d1'],$_GET['d2'],$limit_clause, $_SESSION['id_korisnika']);
    $totalRecords = $allRequests->CountDateforOwnlist($_GET['d1'],$_GET['d2'], $_SESSION['id_korisnika']);
    $default_url = 'index.php?view=ownlist&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
    $pagination_url = 'index.php?view=ownlist&p=[p]&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
}

$pg = new bootPagination();
$pg=HelperModel::paginationParameters($pg, $pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url);
?>
<br />
<div style="text-align: center" id="gif"><img src="<?= FULL_URL_PATH;?>/assets/icons/loading.gif" hidden="true"></div>
<div class='container'>
    <div  class='row-fluid'>
        <div  class='col-lg'>
            <button type="button" data-toggle="modal"  data-target="#add_data_Modal"  class="btn btn-secondary float-lg-left">Dodaj novi zahtjev</button>
            <input  type="button" name="filter" id="filter_own" value="Filter" class="btn btn-info float-lg-right align-self-center" style="margin-left: 10px">
            <?php if(isset($_GET['d1'], $_GET['d2'])): ?>
                <input  type="text" name="to_date" id="to_date" placeholder="Do" class="float-lg-right" style="margin-left: 5px" value=<?=$_GET['d2']; ?>>
                <input  type="text" name="from_date" id="from_date" placeholder="Od" class="float-lg-right" value=<?=$_GET['d1']; ?>>
            <?php  else: ?>
                <input  type="text" name="to_date" id="to_date" placeholder="Do" class="float-lg-right" style="margin-left: 5px" autocomplete="off">
                <input  type="text" name="from_date" id="from_date" placeholder="Od" class="float-lg-right" autocomplete="off">
            <?php endif; ?>
            <br />
            <div id="date_filter">
                <?php if(!$requests): ?>
                <br /><p class="alert-danger" style="text-align: center;">Nema podnesenih zahtjeva!</p>
                <?php else: ?>
                <br />
                <?php require_once FULL_FILE_PATH.'/tables/tableOwnRequests.php';?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once FULL_FILE_PATH.'/modals/editRequest.php';
 require_once FULL_FILE_PATH.'/modals/insertRequest.php'; ?>