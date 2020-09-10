<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/16/18
 * Time: 9:25 PM
 */
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
require_once(FULL_FILE_PATH.'/tcpdf/tcpdf.php');
$allRequests = new requestsModel();
$users = new usersModel();
$years = $users -> getUser($_SESSION['id_korisnika']);
$number_of_days = $allRequests -> numberOfDays($years['GODINE_RADNOG_STAZA']);
$status = $allRequests->getStatus();


//checking for insert request
if(isset($_POST['id2']))
{
    $insert = $allRequests -> insertRequest($_POST);
    header('Location:index.php?view=requestslist');
}
//checking for edit request
if(isset($_POST['potvrdi']))
{
    if($_POST['status']=='4-Odobren')
    {
        //$diff = strtotime($_POST['date1'])-strtotime($_POST['date']);
        //$days=floor($diff/(60*60*24));
        $count = $allRequests -> calculateDays($_POST['date'], $_POST['date1']);
        $put = $allRequests->updateRequestData($_POST,$count);
        $msg = "Vas zahtjev je odobren!";
        $send = $users->sendMail($msg, $_POST['id1']);
        //header('Location:index.php?view=requestslist');
    }
    if($_POST['status']=='2-Odbijen' || $_POST['status']=='3-Iskoriscen')
    {
        $put = $allRequests->updateRequestData($_POST,$days=0);
        $msg = "Vas zahtjev je odbijen!";
        $send = $users->sendMail($msg,$_POST['id1']);
        //header('Location:index.php?view=requestslist');
    }
    header('Location:index.php?view=requestslist');
}

if(isset($_POST['create_pdf']))
{
    //print_r($_POST);
    //echo $_POST['id'];

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("Rjesenja godisnjih odmora");
    $obj_pdf->SetHeaderData('','', PDF_HEADER_TITLE, PDF_HEADER_STRING, PDF_HEADER_LOGO);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetDisplayMode(90);
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(true, 0);
    //$obj_pdf->SetXY(261,200);
    $obj_pdf->SetFont('dejavusans', '', 9.5);
    $content = '';
    $obj_pdf->AddPage();
    if($_POST['id']!='')
        $requests = $allRequests -> fetch_data_for_user($number_of_days,$_POST['id']);
    else
        $requests = $allRequests -> fetch_data($number_of_days);

    $content .= $requests;
    //echo $content;
    //$content .='</p>';
    //ob_start();
    //include(FULL_FILE_PATH.'/tables/tableforPDF.php');
    //$content1 = ob_get_clean();
    $obj_pdf->Image(FULL_URL_PATH.'/assets/icons/logo2.jpg', 20, 20, 30);
    $obj_pdf->Image(FULL_URL_PATH.'/assets/icons/logo1.png',140, 20, 50);
    $obj_pdf->writeHTML($content);
    ob_end_clean();
    $obj_pdf->Output('Rjesenja.pdf', 'I');
}

$and_clause = '';
$default_url = 'index.php?view=requestslist';
$pagination_url = 'index.php?view=requestslist&p=[p]';
$search_term = '';

$pageSize = 10;
//checking for pagination
if(isset($_GET['p']))
$pageNumber = $_GET['p'];
else
$pageNumber = 1;

$limitPage = ((int)$pageNumber - 1) * $pageSize;
$limit_clause = " LIMIT ".$limitPage.",".$pageSize;
$requests = $allRequests->Requests($limit_clause);
$totalRecords = $allRequests->countRequests();


//checking for pagination and filter
if(isset($_GET['p'], $_GET['d1'], $_GET['d2']))
{
    $requests = $allRequests -> filterDate($_GET['d1'],$_GET['d2'],$limit_clause);
    $totalRecords = $allRequests->CountDate($_GET['d1'],$_GET['d2']);
    $default_url = 'index.php?view=requestslist&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
    $pagination_url = 'index.php?view=requestslist&p=[p]&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
}
//checking for filter
if(isset($_GET['d1'], $_GET['d2']))
{
    $requests = $allRequests -> filterDate($_GET['d1'],$_GET['d2'],$limit_clause);
    $totalRecords = $allRequests->CountDate($_GET['d1'],$_GET['d2']);
    $default_url = 'index.php?view=requestslist&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
    $pagination_url = 'index.php?view=requestslist&p=[p]&d1='.$_GET['d1'].'&d2='.$_GET['d2'];
}

$pg = new bootPagination();
$pg=HelperModel::paginationParameters($pg, $pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url);
?>

<br />
<div style="text-align: center" id="gif"><img src="<?= FULL_URL_PATH;?>/assets/icons/loading.gif" hidden="true"></div>
<div class='container'>
    <div  class='row-fluid'>
        <div  class='col-lg'>
            <form method="post">
                <input type="submit" name="create_pdf" class="btn btn-danger float-lg-left" value="Generisi PDF rjesenja" />
            </form>
            <input  type="button" name="filter" id="filter" value="Filter" class="btn btn-info float-lg-right align-self-center" style="margin-left: 10px">
            <?php if(isset($_GET['d1'], $_GET['d2'])): ?>
            <input  type="text" name="to_date" id="to_date" placeholder="Do" class="float-lg-right" style="margin-left: 5px"  value=<?=$_GET['d2']; ?>>
            <input  type="text" name="from_date" id="from_date" placeholder="Od" class="float-lg-right" value=<?=$_GET['d1']; ?>>
            <?php  else: ?>
                <input  type="text" name="to_date" id="to_date" placeholder="Do" class="float-lg-right" style="margin-left: 5px" autocomplete="off">
                <input  type="text" name="from_date" id="from_date" placeholder="Od" class="float-lg-right" autocomplete="off">
            <?php endif; ?>
            <br />
            <div id="date_filter">
                <br />
                <?php require_once FULL_FILE_PATH.'/tables/tableRequests.php';?>
            </div>
        </div>
    </div>
</div>

<?php require_once FULL_FILE_PATH.'/modals/editRequest.php';?>
<?php require_once FULL_FILE_PATH.'/modals/insertRequest.php';?>
