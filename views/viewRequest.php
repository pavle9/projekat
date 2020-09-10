<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/16/18
 * Time: 10:30 PM
 */
$requestClass = new requestsModel();
//checking for id of request
if(isset($_GET['id']))
{
    $request=$requestClass->getRequest($_GET['id']);
}
else
{
    header('Location:index.php?view=requestslist');
}
?>



<div class='container' style='width:500px;border-style: solid'>
    <br />
    <p type='date' name='date'>Datum pocetka godisnjeg: <?=$request['DATUM_POCETKA_GODISNJEG'];?></p>
    <br />
    <p type='date1' name='date1'>Datum povratka: <?=$request['DATUM_POVRATKA'];?></p>
    <br />
    <p type='year' name='year'>Godina: <?=$request['GODINA'];?></p>
    <br />
    <p name="number">Broj dana: <?=$request['BROJ_DANA'];?></p>
    <br />
    <p name="bonus">Bonus dani: <?=$request['BONUS_DANI'];?></p>
    <br />
    <p name="first">Prvi dio odmora: <?=$request['PRVI_DIO_ODMORA'];?></p>
    <br />
</div>