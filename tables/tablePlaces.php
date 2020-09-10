<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/20/18
 * Time: 3:00 PM
 */?>
<br>
<table  class='table table-hover'>
    <thead class='thead-dark'>
    <tr>
        <th>Redni broj</th>
        <th>Naziv radnog mjesta</th>
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
    foreach($allPlaces as $red):?>
        <tr>
            <td><?= $br++; ?></td>
            <td><?= $red["NAZIV_RADNOG_MJESTA"] ?></td>
            <td>
                <a title="Izmjeni" href="<?=FULL_URL_PATH;?>?view=editplace&id=<?php echo $red["ID_RADNOG_MJESTA"];?>"><img src="<?=FULL_URL_PATH;?>/assets/icons/edit.png"  style="width:20px;height:20px;"></a>
                <a title="Izbrisi" onclick= "placeDelete(<?php echo $red["ID_RADNOG_MJESTA"];?>);" href="#"><img src="<?=FULL_URL_PATH;?>/assets/icons/delete.png" style="width:20px;height:20px;" ></a>
                <a title="Pogledaj detalje" href="<?=FULL_URL_PATH;?>?view=viewplace&id=<?php echo $red["ID_RADNOG_MJESTA"];?>"> <img src="<?=FULL_URL_PATH;?>/assets/icons/view.jpg" style="width:20px;height:20px; "></a>
            </td>
        </tr>
    <?php endforeach;  ?>
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