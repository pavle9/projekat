<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/21/18
 * Time: 9:00 AM
 */?>
<div id="add_data_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Unesite novo radno mjesto:</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" onsubmit="return checkPlace()">
                    <br />
                    <label>Naziv radnog mjesta:</label>
                    <input name="name" id="name" autocomplete="off" class="form-control">
                    <br />
                    <div hidden="true">
                        <label>Organizaciona jedinica:</label>
                        <input name="org" id="org" class="form-control" value="<?=$_SESSION['id_organization']?>">
                    </div>
                    <input type="submit" name="potvrdi"   value="Dodaj" class="btn btn-success" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>