<?php
/**
* Created by Pavle Poljcic.
* User: pavle
* Date: 8/21/18
* Time: 9:00 AM
*/
$request = $allRequests->ownRequests($_SESSION['id_korisnika'], $limit_clause)
?>
<div id="add_data_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Unesite podatke za zahtjev:</h4>
            </div>
            <div class="modal-body"  >
                <form action="" method="post" id="insert">
                    <div hidden="true">
                    <label>Status:</label>
                    <input name="status" id="status"  class="form-control" value="1 - Podnesen">
                    <br />
                        <label>ID korisnika:</label>
                        <input name="id2" id="id2" class="form-control" value="<?php echo $_SESSION['id_korisnika']; ?>" hidden="true">
                        <br />
                        <label>ID Admina:</label>
                        <input name="id3" id="id3"  class="form-control" value="<?php echo $_SESSION['id_korisnika']; ?>">
                        <br />
                    </div>
                    <label>Broj dana na raspolaganju:</label>
                    <input name="number" autocomplete="off" id="number"  class="form-control" <?php if($days==0 /*|| date('Y-m-d')==date('Y').'-09-21'*/):?>value="<?=$number_days?>" <?php else:?>value="<?=$minus?>" <?php endif; ?> readonly>
                    <br />
                    <label>Godina:</label>
                    <select name="year" id="year"  class="form-control">
                            <option><?=date('Y')?></option>
                            <option><?=date('Y')-1;?></option>
                    </select>
                    <br />
                    <label>Prvi dio odmora:</label>
                    <select name="first" id="first"  class="form-control">
                        <option>Da</option>
                        <option>Ne</option>
                    </select>
                    <br />
                    <label>Datum pocetka godisnjeg:</label>
                    <input name="date" id="date" autocomplete="off" class="form-control" >
                    <br />
                    <label>Datum povratka:</label>
                    <input name="date1" id="date1" autocomplete="off" class="form-control" onchange="checkDates(<?php if($days==0): echo $number_days; else: echo $minus;  endif; ?>);">
                    <br />
                    <div class="alert alert-warning" role="alert" id="mes" hidden="true"></div>
                     <input type="button" name="potvrdi" id="button" value="Dodaj" class="btn btn-success"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
