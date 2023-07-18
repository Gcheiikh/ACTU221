<?php
class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!isset(self::$connection)) {
            self::$connection = mysqli_connect("localhost", "root", "TrapperK5/*", "mglsi_news");

            if (mysqli_connect_errno()) {
                echo "Erreur de connexion à la base de données : " . mysqli_connect_error();
                exit();
            }
        }
        return self::$connection;
    }
}
