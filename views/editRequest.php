<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/16/18
 * Time: 9:25 PM
 */
require_once '../config.php';
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
//include  FULL_FILE_PATH.'/config/database.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$allRequests = new requestsModel();
$requests = $allRequests->Requests();
$status = $allRequests->getStatus();

if(HelperModel::isAjax()==true)
{
    //checking for id of employee
    if(isset($_POST["employee_id"]))
    {
        $put = $allRequests->getRequest($_POST["employee_id"]);
    }
}
/*if(date("Y-m-d")==$put['DATUM_POVRATKA'])
{
    $put = $allRequests->getRequest($put['ID_ZAHTJEVA']);
}*/
?>

<form action="" method="post" >
    <div <?php if($_SESSION['id_role']==2):?> hidden="true" <?php endif; ?>>
    <label>Status:</label>
    <select name="status" id="status"  class="form-control" >
        <option><?= $put['STATUS_ID']?>-<?= $put['OPIS']?></option>
        <?php foreach($status as $s):
            if($s['STATUS_ID']!=$put['STATUS_ID']): ?>
            <option ><?= $s['STATUS_ID']?>-<?= $s['OPIS']?></option>
        <?php endif; endforeach;?>
    </select>
    <br />
    </div>
    <div <?php if($_SESSION['id_role']==2) {?>hidden="true" <?php } ?>>
        <label>Komentar:</label>
        <input name="com" id="com"  class="form-control">
        <br />
    </div>
    <div hidden="true">
        <br /><label>ID zahtjeva:</label>
        <input name="id1" id="id" value=<?=$put['ID_ZAHTJEVA'];?>  class="form-control">
        <br />
        <label>ID korisnika:</label>
        <input name="id_k" id="id" value=<?=$put['ID_KORISNIKA'];?> class="form-control">
        <br />
        <label>ID Admina:</label>
        <input name="id3" id="id" value=<?=$put['ID_ADMINA'];?> class="form-control">
    </div>
    <div hidden="true">
        <label>Broj dana na raspolaganju:</label>
        <input name="number" autocomplete="off" id="number"  class="form-control" value="<?=$put['BROJ_DANA']?>">
        <br />
    </div>
    <div hidden="true">
        <label>Bonus:</label>
        <input name="bonus" autocomplete="off" id="bonus"  class="form-control" value="<?=$put['BONUS_DANI']?>">
        <br />
    </div>
    <?php if($_SESSION['id_role']==1 && $put['STATUS_ID']==4){ ?>
    <div hidden="true">
    <?php } ?>
    <label>Godina:</label>
        <select name="year" id="year"  class="form-control">
            <option><?php if($put['GODINA']==date('Y')) echo date('Y'); else echo date('Y')-1;?></option>
            <option><?php if($put['GODINA']==date('Y')) echo date('Y')-1; else echo date('Y');?></option>
        </select>
    <br />
    <label>Prvi dio odmora:</label>
    <select name="first" id="first"  class="form-control">
        <option><?php if($put['PRVI_DIO_ODMORA']==1) echo 'Da'; else echo 'Ne';?></option>
        <option><?php if($put['PRVI_DIO_ODMORA']==1) echo 'Ne'; else echo 'Da';?></option>
    </select>
    <br />
    <label>Datum pocetka godisnjeg:</label>
        <input name="date" id="date" autocomplete="off" value=<?=$put['DATUM_POCETKA_GODISNJEG'];?> class="form-control" onclick="pickeredit()">
    <br />
    </div>
    <label>Datum povratka:</label>
         <input name="date1" id="date1" autocomplete="off" value=<?=$put['DATUM_POVRATKA'];?> class="form-control" onclick="pickeredit()" onchange="checkDates()">
    <br />
    <div class="alert alert-warning" role="alert" id="mes" hidden="true"></div>
    <input type="submit" name="potvrdi"  id='button' value="Izmjeni" class="btn btn-success" onclick="notifyMe('Vas zahtjev je izmjenjen');"/>
    <button type="button" class="btn btn-default" data-dismiss="modal" >Zatvori</button>
</form>
