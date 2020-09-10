<?php
/**
 * Created by PhpStorm.
 * User: pavle
 * Date: 2/20/20
 * Time: 1:59 PM
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
            <th>Naziv radnog mjesta</th>
            <th>Datum zasnivanja radnog odnosa</th>
            <th>Godine radnog staza</th>
            <th>Opcije</th>
        </tr>
    </thead>
    <?php if(isset($_GET['p']))
    {
    $br=($_GET['p']-1)*10+1;
    }
    else
    {
    $br=1;
    }
    foreach($admins as $red):?>
    <tr>
        <td><?= $br++; ?></td>
        <td><?= $red["IME"] ?></td>
        <td><?= $red["PREZIME"] ?></td>
        <td><?= $red["EMAIL"] ?></td>
        <td><?= $place["NAZIV_RADNOG_MJESTA"] ?></td>
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
