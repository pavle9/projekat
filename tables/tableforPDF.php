<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/20/18
 * Time: 3:00 PM
 */
ob_start();
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
    <?php foreach($requests as $red): ?>
        <tr <?php if($red['STATUS_ID']==1) {echo 'bgcolor="#ffe6e6" title="Zahtjev podnesen"';} ?>>
            <td><?= $br++; ?></td>
            <td><?= $red["IME"] ?></td>
            <td><?= $red["PREZIME"] ?></td>
            <td><?= $red["DATUM_POCETKA_GODISNJEG"] ?></td>
            <td><?= $red["DATUM_POVRATKA"] ?></td>
            <td><?= $red["GODINA"] ?></td>
            <td><?= $red["BROJ_DANA"] ?></td>
            <td><?= $red["BONUS_DANI"] ?></td>
            <td><?= $red["PRVI_DIO_ODMORA"] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
