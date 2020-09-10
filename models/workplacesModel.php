<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/10/18
 * Time: 4:00 AM
 */

/**
 * Class workplacesModel - class for work with table radno_mjesto
 */
class workplacesModel
{
    /**
     * function for select data in table radno_mjesto
     * @param bool $limit_clause
     * @return array with selected data
     */
    public function workPlaces($limit_clause = FALSE)
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = 'SELECT * FROM radno_mjesto'.$limit_clause;
            }
            else{
                $sql = 'SELECT * FROM radno_mjesto WHERE
                ID_ORGANIZACIONE_JEDINICE='.$_SESSION['id_organization'].$limit_clause;
            }
            //$sql = 'SELECT * FROM radno_mjesto'.$limit_clause;
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
     * function for count rows in table radno_mjesto
     * @return count of results
     */
    public function countPlaces()
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = 'SELECT * FROM radno_mjesto';
            }
            else{
                $sql = 'SELECT * FROM radno_mjesto WHERE
                ID_ORGANIZACIONE_JEDINICE='.$_SESSION['id_organization'];
            }
            //$sql = 'SELECT * FROM radno_mjesto';
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
     * function for select data about work place with id
     * @param int $id - id of work place
     * @return mixed array with data of work place
     */
    public function getPlace($id)
    {
        try
        {
            $sql = 'SELECT * FROM radno_mjesto WHERE ID_RADNOG_MJESTA=:id';
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
     * function for editing users data
     * @param array $data contains updated data for user
     * @param int $id of user for edit
     */
    public function updatePlace($data, $id)
    {
        $place = $data['place'];
        try
        {
            $sql = 'UPDATE radno_mjesto SET NAZIV_RADNOG_MJESTA=:name  WHERE ID_RADNOG_MJESTA=:id';
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':name' => $place,':id' => $id));
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /***
     * function for deleting data from table radno_mjesto
     * @param int $id - id of work place
     */
    public function deletePlace($id)
    {
        try
        {
            $sql = "DELETE FROM korisnik WHERE ID_RADNOG_MJESTA = :id";
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id' => $id) );

            $sql = "DELETE FROM radno_mjesto WHERE ID_RADNOG_MJESTA = :id";
            $query = database::Connect()->prepare($sql);
            $query->execute(array(':id' => $id) );
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for inserting data of new work place
     * @param array $data contains inserted data for work place
     */
    public function insertPlace($data)
    {
        //$id_place = $data['place'];
        $name = $data['name'];
        //$organizaciona_jedinica =  $data['org'];
        try
        {
            $sql = "INSERT INTO radno_mjesto (NAZIV_RADNOG_MJESTA)
                                            VALUES ('$name')";
            $query = database::Connect()->prepare($sql);
            $result=$query->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * function for search data in table radno_mjesto
     * @param string $post for search in table radno_mjesto
     * @return array with selected data
     */
    public function searchPlaces($post, $limit_clause = FALSE)
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = "SELECT * FROM radno_mjesto WHERE NAZIV_RADNOG_MJESTA LIKE '%".$post."%'".$limit_clause;
            }
            else
            {
                $sql = "SELECT * FROM radno_mjesto WHERE NAZIV_RADNOG_MJESTA LIKE '%".$post."%' AND ID_ORGANIZACIONE_JEDINICE=".$_SESSION['id_organization'].$limit_clause;
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
     * function for count rows for search data in table radno_mjesto
     * @return count of results
     */
    public function searchPlacesCount($post)
    {
        try
        {
            if($_SESSION['id_role']==3)
            {
                $sql = "SELECT * FROM radno_mjesto WHERE NAZIV_RADNOG_MJESTA LIKE '%".$post."%'";
            }
            else
            {
                $sql = "SELECT * FROM radno_mjesto WHERE NAZIV_RADNOG_MJESTA LIKE '%".$post."%' AND ID_ORGANIZACIONE_JEDINICE=".$_SESSION['id_organization'];
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
}
