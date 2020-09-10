<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/7/18
 * Time: 1:00 PM
 */
/**
 * Class database
 * Class for connection and disconnection with database
 */
class database
{
    /**
     * @var string Name of server
     */
    private static $servername = "localhost";
    /**
     * @var string Name of database
     */
    private static $dbname = "projekat1";
    /**
     * @var string Username on server
     */
    private static $username = "root";
    /**
     * @var string Password on server
     */
    private static $password = "";
    /**
     * @var string for connection on database
     */
    private static $_pdo;

    /**
     * Function which allows connection on database
     * @return PDO
     * @throws Exception
     */
    public static function Connect()
    {
        try
        {
        if(self::$_pdo==null){
        self::$_pdo = new PDO("mysql:host=".self::$servername.";dbname=".self::$dbname, self::$username, self::$password);
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        self::$_pdo->exec("SET NAMES UTF8");
        }
         return self::$_pdo;
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * Function which allows disconnection from database
     * @throws Exception
     */
    public function Disconnect()
    {
        self::$_pdo = null;
    }
}
