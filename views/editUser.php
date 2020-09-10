<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/8/18
 * Time: 11:00 PM
 */
$userClass = new usersModel();
$user=$userClass->getUser($_GET['id']);
//checking for update user
if(isset($_POST["potvrdi"]))
{
    $userClass->updateEditData($_POST, $_GET['id']);
    header('Location:index.php?view=userslist');
}
//if update is canceled
if(isset($_POST["cancel"]))
{
    header('Location:index.php?view=userslist');
}

?>

<div class='container' style='width:500px;'>
    <form action='' method='post'  name="form"  >
        <br />
        <div hidden="true">
        <label>ID:</label>
        <input type='id'  name='id' value=<?=$_GET['id'];?>  class='form-control'/>
        <br />
        </div>
        <label>Ime:</label>
        <input type='name' name='name' value=<?=$user['IME'];?> class='form-control' />
        <br />
        <label>Prezime:</label>
        <input type='lastname' name='lastname' value=<?=$user['PREZIME'];?> class='form-control'/>
        <br />
        <label>Email:</label>
        <input type='email' name='email'  value=<?=$user['EMAIL'];?> class='form-control'/>
        <br />
        <label>Datum zasnivanja radnog odnosa:</label>
        <input name="date" autocomplete="off" value=<?=$user['DATUM_ZASNIVANJA_RADNOG_ODNOSA'];?> id="date" class='form-control'/>
        <br />
        <label>Godine radnog staza:</label>
        <input name="year"   value=<?=$user['GODINE_RADNOG_STAZA'];?>  class='form-control'/>
        <br />
        <input  type='submit' name='potvrdi' class='btn btn-default btn-success'  value='Potvrdi'  />
        <input  type='submit' name='cancel' class='btn btn-default'  value='Zatvori'  />
    </form>
</div>