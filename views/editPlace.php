<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/10/18
 * Time: 4:00 AM
 */
$workPlace = new workplacesModel();
$place= $workPlace->getPlace($_GET['id']);
//checking for editing work place
if(isset($_POST["potvrdi"]))
{
    $workPlace->updatePlace($_POST, $_GET['id']);
    header('Location:index.php?view=workplaceslist');
}
//if editing is canceled
if(isset($_POST["cancel"]))
{
    header('Location:index.php?view=workplaceslist');
}

?>

<div class='container' style='width:500px;'>
    <form action='' method='post'  name="form"  >
        <br />
        <div hidden="true">
        <label>ID radnog mjesta:</label>
        <input type='id'  name='id' value=<?=$_GET['id'];?>  class='form-control'/>
        <br />
        </div>
        <label>Naziv radnog mjesta:</label>
        <input type='name' name='place' value="<?=$place['NAZIV_RADNOG_MJESTA'];?>" class='form-control' />
        <br />
        <input  type='submit' name='potvrdi' class='btn btn-default btn-success'  value='Potvrdi'  />
        <input  type='submit' name='cancel' class='btn btn-default'  value='Zatvori'  />
    </form>
</div>