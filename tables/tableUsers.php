<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/20/18
 * Time: 3:00 PM
 */
 ?>
<br>
<table  class='table table-hover'>
    <thead class='thead-dark'>
    <tr>
        <th>Redni broj</th>
        <th>Ime</th>
        <th>Prezime</th>
        <th>Email</th>
        <?php if($_SESSION['id_role']==2): ?>
        <th>Naziv radnog mjesta</th>
        <?php endif; ?>
        <th>Datum zasnivanja radnog odnosa</th>
        <th>Godine radnog staza</th>
        <?php if($_SESSION['id_role']==1 || $_SESSION['id_role']==3): ?>
        <th>Opcije</th>
        <?php endif; ?>
    </tr>
    </thead>
    <?php if($_SESSION['id_role']==2): ?>
    <tr>
        <td><?= $br=1; ?></td>
        <td><?= $employ["IME"] ?></td>
        <td><?= $employ["PREZIME"] ?></td>
        <td><?= $employ["EMAIL"] ?></td>
        <td><?= $place["NAZIV_RADNOG_MJESTA"] ?></td>
        <td><?= $employ["DATUM_ZASNIVANJA_RADNOG_ODNOSA"] ?></td>
        <td><?= $employ["GODINE_RADNOG_STAZA"] ?></td>
    </tr>
    <?php else:
    if(isset($_GET['p']))
    {
        $br=($_GET['p']-1)*10+1;
    }
    else
    {
        $br=1;
    }
    foreach($allUsers as $red):?>
        <tr>
            <td><?= $br++; ?></td>
            <td><?= $red["IME"] ?></td>
            <td><?= $red["PREZIME"] ?></td>
            <td><?= $red["EMAIL"] ?></td>
            <td><?= $red["DATUM_ZASNIVANJA_RADNOG_ODNOSA"] ?></td>
            <td><?= $red["GODINE_RADNOG_STAZA"] ?></td>
            <td>
                <a title="Izmjeni" href="<?=FULL_URL_PATH;?>?view=edituser&id=<?php echo $red["ID_KORISNIKA"];?>"><img src="<?=FULL_URL_PATH;?>/assets/icons/edit.png" style="width:20px;height:20px;"></a>
                <a title="Izbrisi" onclick= "messageDelete(<?php echo $red["ID_KORISNIKA"];?>);" href="#"><img src="<?=FULL_URL_PATH;?>/assets/icons/delete.png" style="width:20px;height:20px;" ></a>
                <a title="Pogledaj detalje" href="<?=FULL_URL_PATH;?>?view=viewuser&id=<?php echo $red["ID_KORISNIKA"];?>"> <img src="<?=FULL_URL_PATH;?>/assets/icons/view.jpg" style="width:20px;height:20px; "></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div>
    <div class="float-lg-left" class="col-4"><?=$pg->process(); ?></div>
    <div class="pagination pagination-large float-lg-right">
        <ul class="list-group">
            <li class="list-group-item active">
                Ukupno:
                <span class="badge"><?=$pg->totalrecords ?></span>
            </li>
        </ul>
    </div>
</div>
    <?php endif; ?>