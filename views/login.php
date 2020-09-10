<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/7/18
 * Time: 1:00 PM
 */

require_once FULL_FILE_PATH.'/config/loaderModels.php';
//checking for login
if(isset($_POST["login"]))
{
   $userClass = new usersModel();
   $login=$userClass->Login($_POST);
   if($login==true)
   {
       header('location:index.php?view=userslist');
   }
    else
    {
        header('location:index.php?view=login&error_logging=true');
    }
}
//if users data is wrong
if(isset($_GET['error_logging']))
{
    echo '<p class="alert alert-danger" role="alert"> Podaci nisu potpuni ili nisu tacni </p>';
}
?>

 <div class='container' style='width:500px; height: 250px;  background-color: #ced4da; margin-top: 30px'>
    <form action='' method='post' name='form'>
        <label>Email:</label>
        <input type='email' name='email'  class='form-control'  />
        <br />
        <label>Password:</label>
        <input type='password' name='password' class='form-control'/>
        <br />
        <input type='submit' name='login' class='btn btn-default' value='Prijavi se' />
    </form>
 </div>