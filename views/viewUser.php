<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/8/18
 * Time: 11:00 PM
 */
$userClass = new usersModel();
//checking for id of user
if(isset($_GET['id']))
{
    $user=$userClass->getUser($_GET['id']);
}
else
{
    header('Location:index.php?view=userslist');
}
?>



<div class='container' style='width:500px;border-style: solid'>
        <br />
        <p type='name' name='name'>Ime: <?=$user['IME'];?></p>
        <br />
        <p type='lastname' name='lastname'>Prezime: <?=$user['PREZIME'];?></p>
        <br />
        <p type='email' name='email'>Email: <?=$user['EMAIL'];?></p>
        <br />
        <p name="date">Datum zasnivanja radnog odnosa: <?=$user['DATUM_ZASNIVANJA_RADNOG_ODNOSA'];?></p>
        <br />
        <p name="year">Godine radnog staza: <?=$user['GODINE_RADNOG_STAZA'];?></p>
        <br />
</div>