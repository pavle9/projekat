<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/16/18
 * Time: 9:30 PM
 */

/**
 * Class usersModel - class for manipulating with data of table zahtjev
 */
require_once $_SERVER['DOCUMENT_ROOT'].$app.'/config/database.php';

class requestsModel
{
    /**
     * function for select data from table zahtjev and korisnik
     * @return array with data of table zahtjev and korisnik
     */
    public function Requests($limit_clause = FALSE)
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = 'SELECT * FROM zahtjev,korisnik WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA'.$limit_clause;
            }
            else
            {
                $sql = 'SELECT * FROM zahtjev,korisnik WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND
            korisnik.ID_ORGANIZACIONE_JEDINICE='.$_SESSION['id_organization'].$limit_clause;
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

    /**
     * function for select data of requests for users
     * @param int $d - number of days for holiday
     * @return html result
     */
    function fetch_data($d)
    {
        try
        {
            $output = '';
            if($_SESSION['id_role']==3)
            {
                $sql = "SELECT * FROM zahtjev,korisnik,status,radno_mjesto WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND status.STATUS_ID=zahtjev.STATUS_ID AND korisnik.ID_RADNOG_MJESTA=radno_mjesto.ID_RADNOG_MJESTA";
            }
            else
            {
                $sql = "SELECT * FROM zahtjev,korisnik,status,radno_mjesto WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND status.STATUS_ID=zahtjev.STATUS_ID AND korisnik.ID_RADNOG_MJESTA=radno_mjesto.ID_RADNOG_MJESTA AND radno_mjesto.ID_ORGANIZACIONE_JEDINICE=".$_SESSION['id_organization'];
            }
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $br=1;
            foreach($result as $row)
            {
                if($row['PRVI_DIO_ODMORA']==1 && $row['GODINA']==date('Y') && $row['STATUS_ID']==4)
                {
                    $br++;
                    $output .= '<body><div align="left"><h3 align="center">Univerzitet u Istocnom Sarajevu</h3><h3 align="center">Elektrotehnicki fakultet</h3><br />
                      <p align="center">Vuka Karadzica 30, 71123 Istocno Sarajevo</p>
                      <p align="center" style="word-spacing:3px;">kontakt@etf.unssa.rs.ba +387 57 342 788 www.etf.unssa.rs.ba</p>
                      <p>02-939-06/18</p>
                      <p>Datum: '.date("d.m.Y").'. godine</p>
                      <p>Na osnovu clana 72. Zakona o visokom obrazovanju Republike Srpske („Sluzbeni glasnik RS", br. 73/10, 104/11, 84/12, 108/13
                      , 44/15 i 90/16) i clana 65. Studentskog Univezriteta u Istocnom Sarajevu, a u skladu sa clanom 79. 80. i 84. Zakona o radu Republike Srpske
                      („Sluzbeni glasnik RS", br. 1/16) i clana 5. stav 1. Posebnog kolektivnog ugovora za zaposlene u oblasti obrazovanja i kulture Republike Srpske
                      („Sluzbeni glasnik RS", br. broj 70/16), dekan Fakulteta, donosi</p>
                      <h3 align="center">RJESENJE</h3><h3 align="center">I</h3><p>'.$row["IME"].' '.$row["PREZIME"].', rasporedjenom na poslove i zadatke '.$row["NAZIV_RADNOG_MJESTA"].',
                                    utvrdjuje se pravo na godisnji odmor za '.$row["GODINA"].'. godinu u trajanju od '.$row["BROJ_DANA"].'.
                        <br><h3 align="center">II</h3><p>Imenovani ce godisnji koristiti u intervalu od '
                        .date('d-m-Y', strtotime($row["DATUM_POCETKA_GODISNJEG"])).'. godine do '.date('d-m-Y', strtotime($row["DATUM_POVRATKA"])).
                        '. godine, s tim da je duzan javiti se na posao '.date('d-m-Y', strtotime("+1 day", strtotime($row["DATUM_POVRATKA"]))).
                        '. godine. <br><h3 align="center">III</h3><p>Za koriscenje godisnjeg odmora imenovani ima pravi naknadu plate u visini pune
                         plate.<br><h3 align="center">Obrazlozenje</h3><br><p>Duzina godisnjeg odmora iz tacke 1. dispozitiva rjesenja je odredjena
                         na nacin da je zakonski minimum od 20 radnih dana uvecan za po jedan dan na svake navrsene cetiri godine radnog staza
                         , sto ukupno iznosi '.$d.' radna dana. Neradni radni dani (nacionalni i drzavni praznici) u koje se po zakonu ne radi
                     , vrijeme privremene sprijecenosti za rad u smislu potpisa o zdravstvenom osiguranju, placeno odsustvo, ne racunaju se u ukupnu duzinu trajanje godisnjeg odmora, te
                     se godisnji odmor produzava za taj vremenski period.<br>Imenovani za vrijeme koriscenja odmora ima pravo na naknadu plate u visini pune plate.<br>
                     Polazeci od prethodno navedenog, odluceno je kao u dispozitivu rjesenja.<br>Protiv ovog rjesenja radnik ima pravo podnijeti zahtjev
                      za zastitu prava, dekanu fakulteta u roku od 15 dana od dana prijema rjesenja.<br><h3>Dostaviti:</h3><ol>
                      <li>Imenovanom;</li><li>Dosije;</li><li>06;</li><li>a/a.</li><ol></div></body>';
                }
            }
               return $output;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /**
     * function for select data of request for user
     * @param int $id - id of request
     * @param int $d - number of days for holiday
     * @return html result
     */
    function fetch_data_for_user($d,$id)
    {
        try
        {
            $output = '';
            $sql = "SELECT * FROM zahtjev,korisnik,status,radno_mjesto WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND status.STATUS_ID=zahtjev.STATUS_ID AND korisnik.ID_RADNOG_MJESTA=radno_mjesto.ID_RADNOG_MJESTA AND zahtjev.ID_ZAHTJEVA=".$id;
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $br=1;
            $output .= '<h3 align="center">Универзитет у Источном Sarajevu</h3><h3 align="center">Elektrotehnicki fakultet</h3><br />
              <p align="center">Vuka Karadzica 30, 71123 Istocno Sarajevo</p>
              <p align="center" style="word-spacing:3px;">kontakt@etf.unssa.rs.ba +387 57 342 788 www.etf.unssa.rs.ba</p>
              <p>02-939-06/18</p>
              <p>Datum: '.date("d.m.Y").'. godine</p>
              <p>Na osnovu clana 72. Zakona o visokom obrazovanju Republike Srpske („Sluzbeni glasnik RS", br. 73/10, 104/11, 84/12, 108/13
              , 44/15 i 90/16) i clana 65. Studentskog Univezriteta u Istocnom Sarajevu, a u skladu sa clanom 79. 80. i 84. Zakona o radu Republike Srpske
              („Sluzbeni glasnik RS", br. 1/16) i clana 5. stav 1. Posebnog kolektivnog ugovora za zaposlene u oblasti obrazovanja i kulture Republike Srpske
              („Sluzbeni glasnik RS", br. broj 70/16), dekan Fakulteta, donosi</p>
              <h3 align="center">RJESENJE</h3><h3 align="center">I</h3><p>'.$result["IME"].' '.$result["PREZIME"].', rasporedjenom na poslove i zadatke '.$result["NAZIV_RADNOG_MJESTA"].',
                            utvrdjuje se pravo na godisnji odmor za '.$result["GODINA"].'. godinu u trajanju od '.$result["BROJ_DANA"].'.
                <br><h3 align="center">II</h3><p>Imenovani ce godisnji koristiti u intervalu od '
                .date('d-m-Y', strtotime($result["DATUM_POCETKA_GODISNJEG"])).'. godine do '.date('d-m-Y', strtotime($result["DATUM_POVRATKA"])).
                '. godine, s tim da je duzan javiti se na posao '.date('d-m-Y', strtotime("+1 day", strtotime($result["DATUM_POVRATKA"]))).
                '. godine. <br><h3 align="center">III</h3><p>Za koriscenje godisnjeg odmora imenovani ima pravi naknadu plate u visini pune
                 plate.<br><h3 align="center">Obrazlozenje</h3><br><p>Duzina godisnjeg odmora iz tacke 1. dispozitiva rjesenja je odredjena
                 na nacin da je zakonski minimum od 20 radnih dana uvecan za po jedan dan na svake navrsene cetiri godine radnog staza
                 , sto ukupno iznosi'.$d.' radna dana. Neradni radni dani (nacionalni i drzavni praznici) u koje se po zakonu ne radi
             , vrijeme privremene sprijecenosti za rad u smislu potpisa o zdravstvenom osiguranju, placeno odsustvo, ne racunaju se u ukupnu duzinu trajanje godisnjeg odmora, te
             se godisnji odmor produzava za taj vremenski period.<br>Imenovani za vrijeme koriscenja odmora ima pravo na naknadu plate u visini pune plate.<br>
             Polazeci od prethodno navedenog, odluceno je kao u dispozitivu rjesenja.<br>Protiv ovog rjesenja radnik ima pravo podnijeti zahtjev
              za zastitu prava, dekanu fakulteta u roku od 15 dana od dana prijema rjesenja.<br><h3>Dostaviti:</h3><ol>
              <li>Imenovanom;</li><li>Dosije;</li><li>06;</li><li>a/a.</li><ol>';

            return $output;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /**
     * function for count rows in table zahtjev
     * @return count of results
     */
    public function countRequests()
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = 'SELECT * FROM zahtjev,korisnik WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA';
            }
            else
            {
                $sql = 'SELECT * FROM zahtjev,korisnik WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND
            korisnik.ID_ORGANIZACIONE_JEDINICE='.$_SESSION['id_organization'];
            }
            //$sql = 'SELECT * FROM zahtjev';
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
     * function for select data of request with id
     * @param int $id - id of request
     * @return mixed array with data of request and status
     */
    public function getRequest($id)
    {
        try
        {
            $sql = 'SELECT * FROM zahtjev,status WHERE zahtjev.STATUS_ID=status.STATUS_ID AND ID_ZAHTJEVA=:id';
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
     * function for select data from table zahtjev for user
     * @param int $id - id of user
     * @return array with data of table zahtjev and korisnik
     */
    public function ownRequests($id, $limit_clause = FALSE)
    {
        try
        {
            $sql = 'SELECT * FROM zahtjev,korisnik WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND zahtjev.ID_KORISNIKA='.$id.''.$limit_clause;
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
     * function for count rows in table zahtjev for user
     * @param int $id - id of user
     * @return count of results
     */
    public function countOwnRequests($id)
    {
        try
        {
            $sql = 'SELECT * FROM zahtjev WHERE ID_KORISNIKA='.$id;
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return count($result);
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /***
     * function for deleting data from table zahtjev
     * @param int $id - id of request
     */
    public function deleteRequest($id)
    {
        try
        {
            $sql = "DELETE FROM zahtjev WHERE ID_ZAHTJEVA = :id";
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id' => $id) );
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function count rest of days for holiday
     * @param $id_user - id of user
     * @return int $number - number of days
     */
    public function CountDays($id_user)
    {
        try
        {
            $sql = 'SELECT * FROM zahtjev WHERE ID_KORISNIKA='.$id_user;
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $days=0;
            foreach($result as $c)
            {
                $days=+$c['BROJ_DANA'];
            }
            return $days;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    public function calculateDays($date_one, $date_two){
        $start = strtotime($date_one);
        $end = strtotime($date_two);
        $count = 0;

        while(date('Y-m-d', $start) < date('Y-m-d', $end)){
            $count += date('N', $start) < 6 ? 1 : 0;
            $start = strtotime("+1 day", $start);
        }
        $count++;
        return $count;
    }

    /**
     * function for updating request data
     * @param array $data contains updated data for request
     */
    public function updateRequestData($data,$days)
    {
        $id_z = $data['id1'];
        $id_k = $data['id_k'];
        $id_a = $data['id3'];
        $id_s = $data['status'];
        $com = $data['com'];
        $y = $data['year'];
        $n = $data['number'];
        $bonus=$data['bonus'];
        $user=new usersModel();
        $years = $user -> getUser($_SESSION['id_korisnika']);
        $date = (date('Y')+1).'-'.substr($years['DATUM_ZASNIVANJA_RADNOG_ODNOSA'], -5, 5);
        if($years['DATUM_ZASNIVANJA_RADNOG_ODNOSA']==$date)
        {
            $bonus+=1;
        }

        //$req=new requestsModel();
        //$user=new usersModel();
        //$years = $user -> getUser($_SESSION['id_korisnika']);
        //$n = $req -> numberOfDays($years, $data['number']);
        if($data['first']=="Da")
            $f = 1;
        else
            $f = 0;
        $date1=$data['date'];
        $date2=$data['date1'];

        try
        {
            $sql = 'UPDATE zahtjev SET  ID_KORISNIKA=:id_k, ID_ADMINA=:id_a, STATUS_ID=:id_s, DATUM_POCETKA_GODISNJEG=:b, DATUM_POVRATKA=:e, KOMENTAR=:com,  GODINA=:y, BROJ_DANA=:n, BONUS_DANI=:bonus, PRVI_DIO_ODMORA=:f WHERE ID_ZAHTJEVA=:id_z';
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id_k' => $id_k, ':id_a' => $id_a,':id_s' => $id_s,':b' => $date1,':e' => $date2, ':com' => $com, ':y' => $y, ':n' => $n-$days, ':bonus' =>$bonus , ':f' => $f, ':id_z' => $id_z));
            return $date;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /***
     * function for select data of table status
     * @return mixed array with data of status
     */
    public function getStatus()
    {
        try
        {
            $sql = 'SELECT * FROM status';
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /**
     * function for inserting data of new user
     * @param array $data contains inserted data for user
     */
    public function insertRequest($data)
    {
        $id_k = $data['id2'];
        $id_a = $data['id3'];
        $b = $data['date'];
        $e = $data['date1'];
        $y = $data['year'];
        if($data['first']=="Da")
            $f = 1;
        else
            $f = 0;
        $number_of_days = $data['number'];
        $user=new usersModel();
        $years = $user -> getUser($_SESSION['id_korisnika']);
        $bonus = floor($years['GODINE_RADNOG_STAZA']/4);

        try
        {
            $sql = "INSERT INTO zahtjev (ID_KORISNIKA, ID_ADMINA, STATUS_ID, DATUM_POCETKA_GODISNJEG, DATUM_POVRATKA,  GODINA, BROJ_DANA, BONUS_DANI, PRVI_DIO_ODMORA)
                                            VALUES ('$id_k', '$id_a',' 1',' $b','$e', ' $y', '$number_of_days' , ' $bonus' , ' $f')";
            $query = database::Connect()->prepare($sql);
            $result=$query->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /***
     * function for count number of days for users holiday
     * @param number $years is number of users working years
     * @return number $number_of_days
     */
    public function numberOfDays($years)
    {
        $year_of_work = new usersModel();
        $s = $year_of_work -> getUser($_SESSION['id_korisnika']);
        $bonus=$s['GODINE_RADNOG_STAZA']/4;
        $number_of_days = 20 + $bonus;
        return (int)$number_of_days;
    }

    /***
     * function for select data between two dates
     * @param date $d1 contains first date
     * @param date $d2 contains second date
     * @return mixed array with selected data
     */
    public function filterDate($d1, $d2, $limit_clause=false)
    {
        $date1 = $d1;
        $date2 = $d2;
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = "SELECT * FROM zahtjev,korisnik
            WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND DATUM_POCETKA_GODISNJEG BETWEEN '".$date1."' AND '".$date2."' ".$limit_clause;
            }
            else
            {
                $sql = "SELECT * FROM zahtjev,korisnik
            WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND DATUM_POCETKA_GODISNJEG BETWEEN '".$date1."' AND '".$date2."' AND korisnik.ID_ORGANIZACIONE_JEDINICE=".$_SESSION['id_organization'].$limit_clause;
            }
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /***
     * function for count data between two dates
     * @param date $d1 contains first date
     * @param date $d2 contains second date
     * @return count of selected data
     */
    public function CountDate($d1, $d2)
    {
        $date1 = $d1;
        $date2 = $d2;
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = "SELECT * FROM zahtjev
            WHERE DATUM_POCETKA_GODISNJEG BETWEEN '".$date1."' AND '".$date2."'";
            }
            else
            {
                $sql = "SELECT * FROM zahtjev,korisnik
            WHERE DATUM_POCETKA_GODISNJEG BETWEEN '".$date1."' AND '".$date2."' AND korisnik.ID_ORGANIZACIONE_JEDINICE=".$_SESSION['id_organization'];
            }
            $query = database::Connect()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return count($result);
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /***
     * function for select data between two dates for user
     * @param date $d1 contains first date
     * @param date $d2 contains second date
     * @param int $id - id of user
     * @return mixed array with selected data
     */
    public function filterDateforOwnlist($d1, $d2,$limit_clause=false, $id)
    {
        $date1 = $d1;
        $date2 = $d2;
        try
        {
            $sql = "SELECT * FROM zahtjev,korisnik
            WHERE korisnik.ID_KORISNIKA=zahtjev.ID_KORISNIKA AND zahtjev.ID_KORISNIKA=:id AND DATUM_POCETKA_GODISNJEG BETWEEN '".$date1."' AND '".$date2."' ORDER BY DATUM_POCETKA_GODISNJEG DESC".$limit_clause;
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id'=> $id));
            $result = $query->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }

    /***
     * function for count data between two dates for user
     * @param date $d1 contains first date
     * @param date $d2 contains second date
     * @param int $id - id of user
     * @return count of selected data
     */
    public function CountDateforOwnlist($d1, $d2, $id)
    {
        $date1 = $d1;
        $date2 = $d2;
        try
        {
            $sql = "SELECT * FROM zahtjev
            WHERE ID_KORISNIKA=:id AND DATUM_POCETKA_GODISNJEG BETWEEN '".$date1."' AND '".$date2."'";
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id'=> $id));
            $result = $query->fetchAll();
            return count($result);
        }
        catch(PDOException $e)
        {
            echo  $e->getMessage();
        }
    }
}