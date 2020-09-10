<?php
use PHPMailer\PHPMailer\PHPMailer;
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/7/18
 * Time: 1:00 PM
 */
include  $_SERVER['DOCUMENT_ROOT'].$app.'/config/database.php';
require_once FULL_FILE_PATH . '/m/src/Exception.php';
require_once FULL_FILE_PATH . '/m/src/PHPMailer.php';
require_once FULL_FILE_PATH . '/m/src/SMTP.php';
/**
 * Class usersModel - class for login, logout and manipulating with users data
 */
class usersModel
{
    /**
     * function for select users data from database
     * @return array with users data
     */
    public function Users($limit_clause = FALSE)
	{
       try
       {
           if($_SESSION['id_role']==3)
           {
              $sql = 'SELECT * FROM korisnik'.$limit_clause;
           }
           else{
               $sql = 'SELECT * FROM korisnik WHERE ID_ORGANIZACIONE_JEDINICE='.$_SESSION['id_organization'].$limit_clause;
           }
           $query = database::Connect()->prepare($sql);
           $query->execute();
           $result = $query->fetchAll(PDO::FETCH_ASSOC);
           return $result;
       }
       catch(PDOException $e)
       {
           echo  $e->getMessage();
       }
	}

    ///org jedinice

    public function Organization()
    {
        try
        {
            $sql = 'SELECT * FROM organizaciona_jedinica';
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    public function getOrganization($organization)
    {
        try
        {
            $sql = "SELECT * FROM organizaciona_jedinica WHERE NAZIV_ORGANIZACIONE_JEDINICE='".$organization."'";
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetch();
            return $result;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    public function insertOrganization($org_list)
    {
        try
        {
            $sql = "INSERT INTO organizaciona_jedinica (NAZIV_ORGANIZACIONE_JEDINICE)
                                            VALUES ('$org_list')";
            $query = database::Connect()->prepare($sql);
            $result=$query->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }



    ////adminiiiii

    public function Admins()
    {
        try
        {
            $sql = 'SELECT * FROM korisnik WHERE ID_ROLE=1';
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /**
 * function for count rows in table korisnik
 * @return count of results
 */
    public function countUsers()
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = 'SELECT * FROM korisnik';
            }
            else{
                $sql = 'SELECT * FROM korisnik WHERE  ID_ORGANIZACIONE_JEDINICE='.$_SESSION['id_organization'];
            }
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return count($result);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /***
     * function for select user data with id
     * @param int $id - id of user
     * @return mixed array with data of user
     */
    public function getUser($id)
    {
        try
        {
            $sql = 'SELECT * FROM korisnik WHERE ID_KORISNIKA=:id';
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id'=>$id));
            $result = $query->fetch();
            return $result;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /**
     * function validate data inserted in login form
     * @param string $data Data from login form
     */
    public function Login($data)
    {
		$email=$data['email'];
		$sifra=$data['password'];

        try
        {
            if(!empty($email) || !empty($pass))
            {
                $sql = 'SELECT * FROM korisnik WHERE EMAIL=:email';
                $query = database::Connect()->prepare($sql);
                $query->execute(array(':email' => $email));
                $result = $query->fetch();
                if($result && password_verify($sifra, $result['KORISNICKA_LOZINKA']))
                {
                    $_SESSION['is_logged'] = true;
                    $_SESSION['id_role'] = $result['ID_ROLE'];
                    $_SESSION['id_korisnika'] = $result['ID_KORISNIKA'];
                    if($_SESSION['id_role']==1)
                    {
                        $_SESSION['id_admina']=$_SESSION['id_korisinika'];
                    }
                    $_SESSION['ime'] = $result['IME'];
                    $_SESSION['prezime'] = $result['PREZIME'];
                    $_SESSION['email'] = $result['EMAIL'];
                    $_SESSION['r_mjesta'] = $result['ID_RADNOG_MJESTA'];
                    $_SESSION['id_organization'] = $result['ID_ORGANIZACIONE_JEDINICE'];
                    $_SESSION['loginTime'] = date('Y-m-d H:i:s');
                    return true;
                }
                 else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
	}

    /**
     * logout function
     */
    public function Logout()
    {
        try
        {
            session_destroy();
            $database = new database();
            $database->Disconnect();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for update users data
     * @param string $data contains users data
     * @return mixed array with updated users data
     */
    public function updateProfile($data)
    {
        $email=$data['email'];
        $sifra=$data['new_password'];

        try
        {
            $sql = 'UPDATE korisnik SET EMAIL=:email, KORISNICKA_LOZINKA=:sifra WHERE ID_KORISNIKA=:id_korisnika';
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':email' => $email,':sifra' => password_hash($sifra, PASSWORD_DEFAULT), ':id_korisnika' => $_SESSION['id_korisnika']) );
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for verifing password in database
     * @param string $id - id of loged user
     * @return mixed array od users data
     */
    public function getPassword($id)
    {
        try
        {
            $sql = 'SELECT KORISNICKA_LOZINKA FROM korisnik WHERE ID_KORISNIKA=:id';
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id' => $id));
            $result = $query->fetch();
            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for editing users data
     * @param array $data contains updated data for user
     * @param int $id of user for edit
     */
    public function updateEditData($data, $id)
    {
        $name = $data['name'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $date = $data['date'];
        $year = $data['year'];

        try
        {
            $sql = 'UPDATE korisnik SET IME=:name, PREZIME=:lastname, EMAIL=:email, DATUM_ZASNIVANJA_RADNOG_ODNOSA=:date, GODINE_RADNOG_STAZA=:year  WHERE ID_KORISNIKA=:id_user';
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':name' => $name, ':lastname' => $lastname,':email' => $email,':date' => $date,':year' => $year, ':id_user' => $id));
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    /***
     * function for deleting data from table
     * @param int $id - user id
     */
    public function deleteUser($id)
    {
        try
        {
            $sql = "DELETE FROM zahtjev WHERE ID_KORISNIKA = :id";
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id' => $id) );

            $sql = "DELETE FROM korisnik WHERE ID_KORISNIKA = :id";
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id' => $id) );
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for inserting data of new user
     * @param array $data contains inserted data for user
     */
    public function insertUser($data,$get_organization)
    {
        $id = $data['id'];
        $id_place = $data['place'];
        $id_organization = $get_organization['ID_ORGANIZACIONE_JEDINICE'];
        if($_SESSION['id_role']==1)
            $id_organization = $_SESSION['id_organization'];
        $name = $data['name'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $pass = password_hash($data['pass'], PASSWORD_DEFAULT);
        $date = $data['date'];
        $year = $data['year'];

        try
        {
            $sql = "INSERT INTO korisnik (ID_ROLE, ID_RADNOG_MJESTA, IME, PREZIME, EMAIL, KORISNICKA_LOZINKA, DATUM_ZASNIVANJA_RADNOG_ODNOSA, GODINE_RADNOG_STAZA, ID_ORGANIZACIONE_JEDINICE)
                                            VALUES ('$id', '$id_place','$name','$lastname','$email','$pass','$date','$year','$id_organization')";
            $query = database::Connect()->prepare($sql);
            $result=$query->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for select data in table role
     * @return array with selected data
     */
    public function getRole()
    {
        try
        {
            $sql = 'SELECT * FROM role';
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for search data in table korisnik
     * @param string $post for search in table korisnik
     * @return array with selected data
     */
    public function search($post, $limit_clause = FALSE)
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = "SELECT * FROM korisnik WHERE IME LIKE '%".$post."%' OR EMAIL LIKE '%".$post."%'".$limit_clause;
            }
            else
            {
                $sql = "SELECT * FROM korisnik WHERE (IME LIKE '%".$post."%' OR EMAIL LIKE '%".$post."%') AND ID_ORGANIZACIONE_JEDINICE=".$_SESSION['id_organization'].$limit_clause;
            }
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for count rows for search data in table korisnik
     * @return count of results
     */
    public function searchCount($post)
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = "SELECT * FROM korisnik WHERE IME LIKE '%".$post."%' OR EMAIL LIKE '%".$post."%'";
            }
            else
            {
                $sql = "SELECT * FROM korisnik WHERE (IME LIKE '%".$post."%' OR EMAIL LIKE '%".$post."%') AND ID_ORGANIZACIONE_JEDINICE=".$_SESSION['id_organization'];
            }
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return count($result);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for generate password of user
     * @return string password
     */
    function random_password() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0 ,8 );
        return $password;
    }

    function sendMail($msg, $id)
    {
        $mail = new PHPMailer();
        try{
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'pavlepoljcic@gmail.com';                 // SMTP username
            $mail->Password = 'bostonseltiks1';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                      // TCP port to connect to
            $mail->CharSet = "UTF-8";

            //Recipients
            if(isset($_POST['email']))
            {
              $mail->setFrom($_SESSION['email']);
              $mail->addAddress($_POST['email']);
              $mail->Body    = $msg;
            }
            else
            {
                $mail->setFrom($_SESSION['email']);
                $sql='';
                if($_SESSION['id_role']==2)
                {
                    $id = $_SESSION['id_organization'];
                    $sql = 'SELECT * FROM korisnik WHERE ID_ROLE=1 AND ID_ORGANIZACIONE_JEDINICE='.$id;
                }
                if($_SESSION['id_role']==1)
                {
                    $sql = 'SELECT * FROM korisnik,zahtjev WHERE zahtjev.ID_KORISNIKA=korisnik.ID_KORISNIKA AND zahtjev.ID_ZAHTJEVA='.$id;
                }
                $query = database::Connect()->prepare($sql);
                $query->execute();
                $result = $query->fetch();
                var_dump($result);
                $mail->addAddress($result['EMAIL']);
                //$mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo($_SESSION['email']);
                $mail->Body    = $msg;
            }



            //Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Evidencija godišnjeg odmora';
            //$mail->Body    = $msg;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}
