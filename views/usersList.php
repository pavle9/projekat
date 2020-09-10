<?php

/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/7/18
 * Time: 1:00 PM
 */
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$user = new usersModel();
$workPlace = new workplacesModel();
$allPlaces= $workPlace->workPlaces();
$employ = $user -> getUser($_SESSION['id_korisnika']);
$place = $workPlace -> getPlace($employ['ID_RADNOG_MJESTA']);
$pass=$user->random_password();
$role = $user->getRole();
$admins = $user->Admins();
$organization=$user->Organization();
//checking for insert user
if(isset($_POST['potvrdi']))
{
    $get_organization=$user->getOrganization($_POST['org_list']);
    if($get_organization==null)
    {
        $organization=$user->insertOrganization($_POST['org_list']);
        $get_organization=$user->getOrganization($_POST['org_list']);
    }
    $user->insertUser($_POST,$get_organization);
    $msg = 'Vaši podaci za prijavu su:<br> <p style="margin: 50px; word-spacing: 50px;"> Email: ' .$_POST['email'].'<br>'.'Password: ' .$_POST['pass'].'</p>';
    //$id=1;
    $send = $user->sendMail($msg,$_POST['email']);
    header('Location:index.php?view=userslist');
}

if(isset($_POST['add']))
{
    $place = $workPlace -> insertPlace($_POST);
    header('Location:index.php?view=userslist');
}

$and_clause = '';
$default_url = 'index.php?view=userslist';
$pagination_url = 'index.php?view=userslist&p=[p]';
$search_term = '';

$pageSize = 10;
//checking for pagination
if(isset($_GET['p']))
    $pageNumber = $_GET['p'];
else
    $pageNumber = 1;

$limitPage = ((int)$pageNumber - 1) * $pageSize;
$limit_clause = " LIMIT ".$limitPage.",".$pageSize;
$allUsers = $user->Users($limit_clause);
$totalRecords = $user->countUsers();

//checking for search and pagination
if(isset($_GET['p']) && isset($_GET['search']))
{
    $allUsers = $user -> search($_GET['search'],$limit_clause);
    $totalRecords = $user->searchCount($_GET['search']);
    $default_url = 'index.php?view=userslist&search='.$_GET['search'];
    $pagination_url = 'index.php?view=userslist&p=[p]&search='.$_GET['search'];
}
//checking for search
if(isset($_GET['search']))
{
    $allUsers = $user -> search($_GET['search'],$limit_clause);
    $totalRecords = $user->searchCount($_GET['search']);
    $default_url = 'index.php?view=userslist&search='.$_GET['search'];
    $pagination_url = 'index.php?view=userslist&p=[p]&search='.$_GET['search'];
}

$pg = new bootPagination();
$pg=HelperModel::paginationParameters($pg, $pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url);
 ?>
<br />

<div class='container'>
    <div  class='row-fluid'>
		<div  class='col-lg'>
            <?php if($_SESSION['id_role']==1 || $_SESSION['id_role']==3): ?>
            <button type="button"  data-toggle="modal"  data-target="#add_data_Modal" class="btn btn-secondary float-lg-left">Dodaj novog korisnika</button>
            <?php if(isset($_GET['search'])): ?>
            <input  type="text" name="search_text" id="search_text" placeholder="Pretrazi.." class="float-lg-right" value=<?=$_GET['search']; ?>>
            <?php  else: ?>
            <input  type="text" name="search_text" id="search_text" placeholder="Pretrazi.." class="float-lg-right">
            <?php endif; ?>
            <?php endif; ?>
            <br />
            <div id="result">
                <?php require_once FULL_FILE_PATH.'/tables/tableUsers.php';?>
            </div>
        </div>
	</div>
 </div>
<?php require_once FULL_FILE_PATH.'/modals/insertUser.php';?>

