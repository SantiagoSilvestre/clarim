<?php
    
    namespace App;

    class Connection
    {
        public static function getDb()
        {
            try
            {
                $conn = new \PDO("mysql:host=localhost;dbname=clarim;charset=utf8",
                "uroot", "0caAb1d00000s");

                return $conn;

            } catch(\PDOException $e) {
                //Tratar falhas na conexão
            }
        }
    }

?>