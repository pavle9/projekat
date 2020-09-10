<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/20/18
 * Time: 3:00 PM
 */
?>
<table  class='table table-hover'>
    <thead class='thead-dark'>
        <tr>
            <th>Redni broj</th>
            <th>Ime</th>
            <th>Prezime</th>
            <th>Datum pocetka godisnjeg</th>
            <th>Datum povratka</th>
            <th>Godina</th>
            <th>Broj dana</th>
            <th>Bonus dani</th>
            <th>Prvi dio odmora</th>
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
    foreach($requests as $red): ?>
        <tr <?php if($red['STATUS_ID']==1) {echo 'bgcolor="" title="Zahtjev podnesen"';} ?>>
            <td><?= $br++; ?></td>
            <td><?= $red["IME"] ?></td>
            <td><?= $red["PREZIME"] ?></td>
            <td><?= $red["DATUM_POCETKA_GODISNJEG"] ?></td>
            <td><?= $red["DATUM_POVRATKA"] ?></td>
            <td><?= $red["GODINA"] ?></td>
            <td><?= $red["BROJ_DANA"] ?></td>
            <td><?= $red["BONUS_DANI"] ?></td>
            <td><?php if($red["PRVI_DIO_ODMORA"]==1): echo 'Da'; else: echo 'Ne'; endif; ?></td>
            <td>
                <a title="Izmjeni" onclick="editRequest(<?php echo $red["ID_ZAHTJEVA"]; ?>);"><img  id="<?php echo $red["ID_ZAHTJEVA"]; ?>" class="view_data" src="<?=FULL_URL_PATH;?>/assets/icons/edit.png" style="width:20px;height:20px;"></a>
                <a title="Izbrisi" onclick= "requestDelete(<?php echo $red["ID_ZAHTJEVA"];?>);" href="#"><img src="<?=FULL_URL_PATH;?>/assets/icons/delete.png" style="width:20px;height:20px;" ></a>
                <a title="Pogledaj detalje" href="<?=FULL_URL_PATH;?>?view=viewrequest&id=<?php echo $red["ID_ZAHTJEVA"];?>"> <img src="<?=FULL_URL_PATH;?>/assets/icons/view.jpg" style="width:20px;height:20px; "></a>
                <?php if($red['STATUS_ID']==4 && $red['PRVI_DIO_ODMORA']==1 && $red['GODINA']==date('Y')): ?>
                <form method="post">
                <input type="submit" title="Generisi rjesenje" name="create_pdf" style="background: green; width:20px; height:20px; float: right;" value="">
                <input hidden="true"  name="id" value="<?=$red['ID_ZAHTJEVA']?>">
                </form>
                <?php endif; ?>
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