<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/13/18
 * Time: 9:00 PM
 */
$placeClass = new workplacesModel();
$userClass = new usersModel();
$users=$userClass->Users();
$br = 0;
//checking for id of work place
if(isset($_GET['id']))
{
    $place=$placeClass->getPlace($_GET['id']);
}
else
{
    header('Location:index.php?view=workplaceslist');
}
?>

<div class='container' style='width:500px;border-style: solid'>
    <br />
    <p type='name' name='name'>Naziv radnog mjesta: <?=$place['NAZIV_RADNOG_MJESTA'];?></p>
    <br />
    <p>Zaposleni:</p>
    <?php foreach($users as $user):
    if($user['ID_RADNOG_MJESTA']==$place['ID_RADNOG_MJESTA']): $br++; ?>
    <p style="margin-left: 80px"><?=$user['IME'];?> <?=$user['PREZIME'];?></p>
    <?php endif; endforeach;?>
    <?php if($br==0){ ?>
    <p><strong>Niko nije zaposlen na ovom radnog mjestu</p>
    <?php } ?>

</div>