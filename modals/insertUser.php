<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/21/18
 * Time: 9:00 AM
 */
?>
<div id="add_data_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Unesite podatke o korisniku:</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" onsubmit="return checkforblank()">
                    <label>Tip korisnika:</label>
                    <select name="id" id="rola"  class="form-control">
                        <?php if($_SESSION['id_role']==1): ?>
                        <option>2-Radnik</option>
                        <?php else: foreach($role as $rl): ?>
                            <option><?= $rl['ID_ROLE']?>- <?= $rl['TIP_ROLE']?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <br />
                    <label>Radno mjesto:</label>
                    <div class="row">
                        <div id="popover_div" class="col-10">
                            <select name="place" id="place"  class="form-control">
                                <?php foreach($allPlaces as $wp):?>
                                    <option><?=$wp['ID_RADNOG_MJESTA']?>-<?= $wp['NAZIV_RADNOG_MJESTA']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="button" class="btn btn-secondary col-1.5" data-container="body" data-toggle="popover"  >
                            Dodaj
                        </button>
                    </div>
                    <?php if($_SESSION['id_role']==3): ?>
                    <br />

                    <label>Organizaciona jedinica:</label>

                    <input type="text" name="org_list" id="org_list" list="list" class="form-control" autocomplete="off">
                    <datalist id="list">
                        <?php foreach($organization as $org):?>
                            <option><?=$org['NAZIV_ORGANIZACIONE_JEDINICE']?></option>
                        <?php endforeach; endif;?>
                    </datalist>
                    <br />
                    <label>Ime:</label>
                    <input name="name" id="name" class="form-control">
                    <br />
                    <label>Prezime:</label>
                    <input name="lastname" id="lastname" class="form-control">
                    <br />
                    <label>Email:</label>
                    <input name="email" id="email" class="form-control">
                    <br />
                    <input name="pass" id="pass" class="form-control" hidden="true" value=<?= $pass;?>>
                    <label>Datum zasnivanja radnog odnosa:</label>
                    <input name="date" autocomplete="off" id="date" class="form-control" >
                    <br />
                    <label>Godine radnog staza:</label>
                    <input name="year" id="year" class="form-control">
                    <br />
                    <input type="submit" name="potvrdi"  value="Dodaj" class="btn btn-success" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div id="formica" hidden="true">
    <form id="popover_forma" action="" method="post" >
        <br />
        <label>Naziv radnog mjesta:</label>
        <input name="name" id="name" autocomplete="off" class="form-control">
        <br />
        <button type="button" name="add" id="add" value="Dodaj" class="btn btn-success">Dodaj</button>
        <button type="button" name="close" id="close" class="btn btn-default" data-dismiss="modal">Zatvori</button>
    </form>
</div>


