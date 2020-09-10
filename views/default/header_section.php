<?php
/**
* Created by Pavle Poljcic.
* User: pavle
* Date: 8/7/18
* Time: 1:00 PM
*/
?>

<nav class="navbar navbar-expand-lg navbar-light bg-primary nav-tabs">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <?php  if($_SESSION['id_role']==2): ?>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link <?php if($_GET['view']=='userslist') {echo "active";} ?>" href='<?=FULL_URL_PATH;?>?view=userslist'>Podaci o korisniku</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($_GET['view']=='ownlist') {echo "active";} ?>" href='<?=FULL_URL_PATH;?>?view=ownlist'>Zahtjevi</a>
        </li>
    </ul>
    <?php else: ?>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link <?php if($_GET['view']=='userslist') {echo "active";} ?>"  href='<?=FULL_URL_PATH;?>?view=userslist'>Korisnici</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($_GET['view']=='workplaceslist') {echo "active";} ?>" href='<?=FULL_URL_PATH;?>?view=workplaceslist'>Radna mjesta</a>
       </li>
       <li  class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php if($_GET['view']=='requestslist' || $_GET['view']=='ownlist') {echo "active";} ?>" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Zahtjevi</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href='<?=FULL_URL_PATH;?>?view=requestslist'>Zahtjevi korisnika</a>
                <a class="dropdown-item" href='<?=FULL_URL_PATH;?>?view=ownlist'>Vlastiti zahtjevi</a>
            </div>
       </li>
    </ul>
    <?php endif; ?>
    <ul class="nav navbar-nav navbar-right ml-auto">
      <li  class="nav-item dropdown">
        <a class="nav-link dropdown-toggle <?php if($_GET['view']=='editprofile') {echo "active";} ?>" style="margin-left:100px;" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
          <?=$_SESSION['ime']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href='<?=FULL_URL_PATH;?>?view=editprofile'>Izmjeni profil</a>
          <a class="dropdown-item" href='<?=FULL_URL_PATH;?>?logout=true'>Izadji</a>
        </div>
      </li>
    </ul>
  </div>
</nav>


