<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/7/18
 * Time: 1:00 PM
 */
require_once(dirname(dirname(__FILE__)).'/config.php');
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/loader.php';
require_once FULL_FILE_PATH.'/config/loaderModels.php';
$userClass = new usersModel();
//checking for ajax request
if(HelperModel::isAjax()==true)
{
    //checking for old password
    if(isset($_REQUEST['old_pswd']))
    {
        //session_start();
        $pass = $userClass->getPassword($_SESSION['id_korisnika']);
        header('Content-Type: application/json');
        if(password_verify($_REQUEST['password'],$pass['KORISNICKA_LOZINKA']))
        {
            print json_encode(array('status'=>true, 'message'=> 'Password match'));
        }
        else
        {
            print json_encode(array('status'=>false, 'message'=> 'Password not matched'));
        }
        die();
    }
}
//checking for edit of profile
if(isset($_POST['email']))
{
    var_dump($_POST);
    $userClass->updateProfile($_POST);
    $_SESSION['email']=$_POST['email'];
    header('Location:index.php?view=userslist');
}
//checking if edit is canceled
if(isset($_POST["cancel"]))
{
    header('Location:index.php?view=userslist');
}
?>

<div class='container' style='width:500px;'>
	 <form action='' method='post'  id="form">
         <div class="alert alert-danger" role="alert" id="message" hidden="true"> </div>
            <br />
        	<label>Email:</label>
        	<input type='email' name='email'  value=<?=$_SESSION['email'];?> class='form-control' onblur="editMail()"/><span  id="mejl"></span>
        	<br />
            <label>Korisnicka lozinka:</label>
            <input id="pas" type='password' name='password' class='form-control'/><span id='id_mes'></span>
            <br />
        	<label>Nova lozinka:</label>
        	<input id="pas1" type='password' name='new_password' class='form-control'/>
        	<br />
            <label>Potvrda nove lozinke:</label>
            <input id="pas2" type='password' name='confirm-password' class='form-control' onkeyup='check();' /><span id='mess'></span>
            <br />
        	<input id='dugme' type="button" name='potvrdi' class='btn btn-default btn-success' onclick="return checkPass();" value='Potvrdi'/>
            <input  type='submit' name='cancel' class='btn btn-default'  value='Zatvori' />
	 </form>
 </div>	